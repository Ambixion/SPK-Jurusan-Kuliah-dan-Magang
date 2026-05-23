pipeline {

    agent any

    environment {
        APP_NAME = 'spk-smkn-app'
        PATH = "/usr/bin:/usr/local/bin:${env.PATH}"
        DB_ROOT_PASSWORD = 'rootpassword123'
    }

    options {
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds()
    }

    stages {

        stage('Checkout') {
            steps {
                echo "📥 Checkout — Build #${BUILD_NUMBER}"
                checkout scm
                sh 'git log -1 --oneline'
                echo '✅ Checkout selesai'
            }
        }

        stage('Build') {
            steps {
                echo "🐳 Build Docker image..."
                sh '''
                    cd $WORKSPACE

                    # Pastikan .env tersedia sebelum build agar aplikasi dapat memuat APP_KEY
                    if [ ! -f $WORKSPACE/.env ]; then
                        cp $WORKSPACE/.env.example $WORKSPACE/.env || true
                    fi

                    sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' $WORKSPACE/.env || true
                    sed -i 's/^# *DB_HOST=.*/DB_HOST=db/' $WORKSPACE/.env || true
                    sed -i 's/^DB_HOST=.*/DB_HOST=db/' $WORKSPACE/.env || true
                    sed -i 's/^# *DB_PORT=.*/DB_PORT=3306/' $WORKSPACE/.env || true
                    sed -i 's/^DB_PORT=.*/DB_PORT=3306/' $WORKSPACE/.env || true
                    sed -i 's/^# *DB_DATABASE=.*/DB_DATABASE=spk_smkn/' $WORKSPACE/.env || true
                    sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spk_smkn/' $WORKSPACE/.env || true
                    sed -i 's/^# *DB_USERNAME=.*/DB_USERNAME=root/' $WORKSPACE/.env || true
                    sed -i 's/^DB_USERNAME=.*/DB_USERNAME=root/' $WORKSPACE/.env || true
                    sed -i 's/^# *DB_PASSWORD=.*/DB_PASSWORD=rootpassword123/' $WORKSPACE/.env || true
                    sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=rootpassword123/' $WORKSPACE/.env || true

                    if ! grep -q '^APP_KEY=.\+' $WORKSPACE/.env 2>/dev/null; then
                        echo '🔐 Generating APP_KEY before image build'
                        APP_KEY=$(docker run --rm php:8.2-cli php -r "echo 'base64:'.base64_encode(random_bytes(32));")
                        if [ -z "$APP_KEY" ]; then
                            echo 'ERROR: gagal membuat APP_KEY' >&2
                            exit 1
                        fi

                        if grep -q '^APP_KEY=' $WORKSPACE/.env 2>/dev/null; then
                            sed -i "s#^APP_KEY=.*#APP_KEY=$APP_KEY#" $WORKSPACE/.env
                        else
                            printf '\nAPP_KEY=%s\n' "$APP_KEY" >> $WORKSPACE/.env
                        fi
                    fi

                    docker build \
                        -t $APP_NAME:$BUILD_NUMBER \
                        -t $APP_NAME:latest \
                        -f Dockerfile .
                '''
                echo '✅ Build selesai'
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Deploy aplikasi...'
                sh '''
                    cd $WORKSPACE

                    # Pastikan network sudah ada
                    docker network inspect spk_network >/dev/null 2>&1 || \
                        docker network create spk_network

                    # Deploy ulang hanya service app dengan 2 replica untuk tetap melayani saat update
                    docker compose -p spk up -d --no-deps --build --scale app=2 app
                '''
                echo '✅ Deploy selesai'
            }
        }

        stage('Wait Container') {
            steps {
                echo '⏳ Menunggu container siap...'
                sh 'sleep 20'
            }
        }

        stage('Laravel Setup') {
            steps {
                echo '⚙️ Setup Laravel...'
                sh '''
                    docker compose -p spk exec -T app sh -c "
                        cd /var/www

                        if [ ! -f .env ]; then
                            cp .env.example .env
                        fi

                        sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env || true
                        sed -i 's/^# *DB_HOST=.*/DB_HOST=db/' .env || true
                        sed -i 's/^DB_HOST=.*/DB_HOST=db/' .env || true
                        sed -i 's/^# *DB_PORT=.*/DB_PORT=3306/' .env || true
                        sed -i 's/^DB_PORT=.*/DB_PORT=3306/' .env || true
                        sed -i 's/^# *DB_DATABASE=.*/DB_DATABASE=spk_smkn/' .env || true
                        sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spk_smkn/' .env || true
                        sed -i 's/^# *DB_USERNAME=.*/DB_USERNAME=root/' .env || true
                        sed -i 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env || true
                        sed -i 's/^# *DB_PASSWORD=.*/DB_PASSWORD=rootpassword123/' .env || true
                        sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=rootpassword123/' .env || true

                        sed -n '1,240p' .env
                    "

                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan config:clear"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan cache:clear" || true
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan route:clear"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan view:clear"

                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan migrate --force"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan db:seed --force" || true

                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan config:cache"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan route:cache"

                    echo "✅ Laravel setup selesai"
                '''
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️ Health check aplikasi...'
                sh '''
                    sleep 10

                    # Curl dari app container ke nginx (internal network)
                    HTTP=$(docker compose -p spk exec -T app sh -c "curl -s -o /dev/null -w '%{http_code}' http://nginx" || echo "000")
                    echo "HTTP STATUS: $HTTP"

                    if [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
                        echo "✅ Aplikasi berjalan normal"
                    else
                        echo "❌ Aplikasi gagal diakses, cek logs:"
                        docker compose -p spk logs nginx --tail=30 || true
                        docker compose -p spk logs app --tail=30 || true
                        exit 1
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo "✅ PIPELINE #${BUILD_NUMBER} BERHASIL"
            echo "🌐 App        : http://localhost"
            echo "📊 Grafana    : http://localhost:3000"
            echo "📈 Prometheus : http://localhost:9090"
        }
        failure {
            echo "❌ PIPELINE #${BUILD_NUMBER} GAGAL"
            sh '''
                docker compose -p spk logs app --tail=50 || true
                docker compose -p spk ps || true
                # Ensure app keluar dari maintenance mode if possible
                docker compose -p spk exec -T app sh -c "cd /var/www && php artisan up" || true
            '''
        }
        always {
            sh 'docker compose -p spk ps || true'
            sh 'docker compose -p spk exec -T app sh -c "cd /var/www && php artisan up" || true'
        }
    }
}
