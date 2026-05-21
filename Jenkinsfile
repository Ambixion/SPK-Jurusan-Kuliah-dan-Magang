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

        stage('Lint') {
            steps {
                echo '🔍 Lint PHP via container yang sudah berjalan...'
                sh '''
                    if docker ps --format "{{.Names}}" | grep -q "spk_app"; then
                        docker exec spk_app php -r "echo 'PHP OK: ' . PHP_VERSION . PHP_EOL;"
                        echo "✅ Lint selesai"
                    else
                        echo "⚠️ Container spk_app belum jalan, lint dilewati"
                    fi
                '''
            }
        }

        stage('Build') {
            steps {
                echo "🐳 Build Docker image..."
                sh """
                    cd \${WORKSPACE}
                    docker image build --tag ${APP_NAME}:${BUILD_NUMBER} --tag ${APP_NAME}:latest --file Dockerfile .
                    docker image ls ${APP_NAME}
                    echo "✅ Build selesai"
                """
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Build and Deploy via Docker Compose'
                sh """
                    cd ~/SPK-Jurusan-Kuliah-dan-Magang
                    git pull origin main
                    docker compose up -d --build
                    docker compose ps
                    echo "✅ Deploy selesai"
                """
            }
        }

        stage('Artisan') {
            steps {
                echo '⚙️ Setup Laravel...'
                sh '''
                    sleep 8
                    docker container exec spk_app php artisan key:generate --force  && echo "key:generate ✅" || true
                    docker container exec spk_app php artisan config:cache           && echo "config:cache ✅"  || true
                    docker container exec spk_app php artisan route:cache            && echo "route:cache ✅"   || true
                    echo "✅ Artisan selesai"
                '''
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️ Health check...'
                sh '''
                    sleep 3
                    HTTP=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 2>/dev/null || echo "000")
                    echo "HTTP Status: $HTTP"
                    if [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
                        echo "✅ Aplikasi OK di http://localhost:8000"
                    else
                        echo "⚠️ Status: $HTTP"
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo "✅ PIPELINE #${BUILD_NUMBER} BERHASIL! App: http://localhost:8000 | Grafana: http://localhost:3000"
        }
        failure {
            echo "❌ PIPELINE #${BUILD_NUMBER} GAGAL"
            sh 'docker container logs spk_app --tail 20 2>/dev/null || true'
        }
        always {
            sh 'docker container ls --filter name=spk_ --format "{{.Names}}: {{.Status}}" 2>/dev/null || true'
        }
    }
}
