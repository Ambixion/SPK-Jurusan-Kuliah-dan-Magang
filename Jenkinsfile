pipeline {
    agent any

    environment {
        APP_NAME   = 'spk-smkn-app'
    }

    options {
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds()
    }

    stages {

        stage('Checkout') {
            steps {
                echo '📥 Mengambil source code...'
                checkout scm
                echo "Build : #${BUILD_NUMBER}"
            }
        }

        stage('Lint - Cek Syntax PHP') {
            steps {
                echo '🔍 Mengecek syntax PHP...'
                sh '''
                    ERROR_COUNT=0
                    for f in $(find app routes database -name "*.php" 2>/dev/null); do
                        RESULT=$(php -l "$f" 2>&1)
                        if echo "$RESULT" | grep -q "Parse error"; then
                            echo "SYNTAX ERROR: $f"
                            echo "$RESULT"
                            ERROR_COUNT=$((ERROR_COUNT + 1))
                        fi
                    done
                    if [ $ERROR_COUNT -gt 0 ]; then
                        echo "❌ Ditemukan $ERROR_COUNT file dengan syntax error!"
                        exit 1
                    fi
                    echo "✅ Semua file PHP syntax OK"
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "🐳 Build image: ${APP_NAME}:${BUILD_NUMBER}..."
                sh """
                    docker build -t ${APP_NAME}:${BUILD_NUMBER} -t ${APP_NAME}:latest .
                    docker images ${APP_NAME}
                """
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Deploy aplikasi...'
                sh '''
                    # Hentikan container app lama jika ada
                    docker stop spk_app 2>/dev/null || true
                    docker rm spk_app   2>/dev/null || true

                    # Jalankan container app baru dengan image terbaru
                    docker run -d \
                        --name spk_app \
                        --network spk_network \
                        --restart unless-stopped \
                        -w /var/www \
                        spk-smkn-app:latest

                    sleep 5
                    docker ps | grep spk_app && echo "✅ Container app berjalan" || echo "⚠️ Container tidak ditemukan"
                '''
            }
        }

        stage('Setup Laravel') {
            steps {
                echo '⚙️  Setup Laravel...'
                sh '''
                    sleep 5
                    docker exec spk_app php artisan key:generate --force  || true
                    docker exec spk_app php artisan config:cache           || true
                    docker exec spk_app php artisan route:cache            || true
                    echo "✅ Setup Laravel selesai"
                '''
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️  Health check...'
                sh '''
                    sleep 3
                    HTTP=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 || echo "000")
                    echo "HTTP Status: $HTTP"
                    if [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
                        echo "✅ Aplikasi berjalan normal"
                    else
                        echo "⚠️ Status $HTTP - aplikasi mungkin butuh waktu lebih"
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo '✅ PIPELINE BERHASIL! Aplikasi: http://localhost:8000 | Grafana: http://localhost:3000'
        }
        failure {
            echo '❌ PIPELINE GAGAL!'
            sh 'docker logs spk_app --tail=20 2>/dev/null || true'
        }
        always {
            echo "Build #${BUILD_NUMBER} selesai."
        }
    }
}
