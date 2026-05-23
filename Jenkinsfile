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
                sh """
                    cd ${WORKSPACE}
                    docker build \
                        -t ${APP_NAME}:${BUILD_NUMBER} \
                        -t ${APP_NAME}:latest \
                        -f Dockerfile .
                """
                echo '✅ Build selesai'
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Deploy aplikasi...'
                sh """
                    cd ${WORKSPACE}

                    # Hapus container lama
                    docker compose -p spk down --remove-orphans || true

                    # Pastikan network sudah ada
                    docker network inspect spk_network >/dev/null 2>&1 || \
                        docker network create spk_network

                    docker compose -p spk up -d --build
                """
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

                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan key:generate --force" || true
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan config:clear"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan cache:clear" || true
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan route:clear"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan view:clear"

                    # Enter maintenance mode before running migrations to avoid inconsistent state
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan down --message='Maintenance for deploy #${BUILD_NUMBER}' || true"

                    # Run migrations and seeds while in maintenance mode
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan migrate --force"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan db:seed --force" || true

                    # Clear and cache configs/routes after migrations
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan config:cache"
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan route:cache"

                    # Exit maintenance mode when setup finished
                    docker compose -p spk exec -T app sh -c "cd /var/www && php artisan up" || true

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
