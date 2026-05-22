pipeline {

    agent any

    environment {
        APP_NAME = 'spk-smkn-app'
        PATH = "/usr/bin:/usr/local/bin:${env.PATH}"
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
                    export COMPOSE_PROJECT_NAME=spk
                    cd ${WORKSPACE}

                    # Hapus container lama yang mungkin tidak ikut down
                    docker compose down --remove-orphans || true

                    # Pastikan network sudah ada (external network)
                    docker network inspect spk_network >/dev/null 2>&1 || \
                        docker network create spk_network

                    docker compose -p spk down --remove-orphans || true

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
                        if [ ! -f .env ]; then
                            cp .env.example .env
                        fi
                    "

                    docker compose -p spk exec -T app php artisan key:generate --force || true
                    docker compose -p spk exec -T app php artisan config:clear || true
                    docker compose -p spk exec -T app php artisan cache:clear || true
                    docker compose -p spk exec -T app php artisan route:clear || true
                    docker compose -p spk exec -T app php artisan view:clear || true
                    docker compose -p spk exec -T app php artisan migrate --force || true
                    docker compose -p spk exec -T app php artisan db:seed --force || true
                    docker compose -p spk exec -T app php artisan config:cache || true
                    docker compose -p spk exec -T app php artisan route:cache || true

                    echo "✅ Laravel setup selesai"
                '''
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️ Health check aplikasi...'
                sh '''
                    sleep 10

                    HTTP=$(curl -s -o /dev/null -w "%{http_code}" http://localhost || echo "000")
                    echo "HTTP STATUS: $HTTP"

                    if [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
                        echo "✅ Aplikasi berjalan normal"
                    else
                        echo "❌ Aplikasi gagal diakses, cek logs:"
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
            '''
        }
        always {
            sh 'docker compose -p spk ps || true'
        }
    }
}
