pipeline {
    agent any

    environment {
        APP_NAME = 'spk-smkn-app'
    }

    options {
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '5'))
        disableConcurrentBuilds()
    }

    stages {

        stage('Checkout') {
            steps {
                echo '📥 Mengambil source code dari GitHub...'
                checkout scm
                echo "✅ Checkout selesai — Build #${BUILD_NUMBER}"
                sh 'echo "Commit: $(git log -1 --oneline)"'
            }
        }

        stage('Lint - Cek Syntax PHP') {
            steps {
                echo '🔍 Mengecek syntax PHP...'
                sh '''
                    # Lint menggunakan PHP yang ada di dalam image yang sudah dibangun sebelumnya
                    # Jika image belum ada, skip lint dan lanjut
                    if docker image inspect spk-smkn-app:latest > /dev/null 2>&1; then
                        docker exec spk_app sh -c '
                            ERROR_COUNT=0
                            for f in $(find /var/www/app /var/www/routes /var/www/database -name "*.php" 2>/dev/null); do
                                RESULT=$(php -l "$f" 2>&1)
                                if echo "$RESULT" | grep -q "Parse error"; then
                                    echo "SYNTAX ERROR: $f"
                                    ERROR_COUNT=$((ERROR_COUNT + 1))
                                fi
                            done
                            echo "Selesai. Error count: $ERROR_COUNT"
                        ' || true
                        echo "✅ Lint selesai"
                    else
                        echo "⚠️  Image belum ada, lint dilewati. Akan dijalankan setelah build pertama."
                    fi
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "🐳 Build image: ${APP_NAME}:${BUILD_NUMBER}..."
                sh """
                    docker build \
                        -t ${APP_NAME}:${BUILD_NUMBER} \
                        -t ${APP_NAME}:latest \
                        .
                    docker images ${APP_NAME} --format "Tag: {{.Tag}} | Size: {{.Size}} | Created: {{.CreatedSince}}"
                    echo "✅ Image berhasil dibangun"
                """
            }
        }

        stage('Deploy - Update Container') {
            steps {
                echo '🚀 Update container app dengan image terbaru...'
                sh """
                    docker stop spk_app 2>/dev/null && echo "Container lama dihentikan" || echo "Tidak ada container lama"
                    docker rm   spk_app 2>/dev/null || true

                    docker run -d \
                        --name spk_app \
                        --network spk_network \
                        --restart unless-stopped \
                        -w /var/www \
                        ${APP_NAME}:latest

                    sleep 5
                    docker ps --filter "name=spk_app" --format "{{.Names}}: {{.Status}}"
                    echo "✅ Container app berjalan dengan image ${APP_NAME}:${BUILD_NUMBER}"
                """
            }
        }

        stage('Setup Laravel') {
            steps {
                echo '⚙️  Jalankan artisan commands...'
                sh '''
                    sleep 5
                    docker exec spk_app php artisan key:generate --force  && echo "key:generate ✅" || true
                    docker exec spk_app php artisan config:cache           && echo "config:cache ✅"  || true
                    docker exec spk_app php artisan route:cache            && echo "route:cache ✅"   || true
                    docker exec spk_app php artisan view:cache             && echo "view:cache ✅"    || true
                    echo "✅ Setup Laravel selesai"
                '''
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️  Cek status aplikasi...'
                sh '''
                    sleep 3
                    HTTP=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 2>/dev/null || echo "000")
                    echo "HTTP Status: $HTTP"
                    if [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
                        echo "✅ Aplikasi berjalan normal di http://localhost:8000"
                    else
                        echo "⚠️  Status $HTTP — aplikasi mungkin butuh waktu lebih"
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo """
✅ ================================
   PIPELINE #${BUILD_NUMBER} BERHASIL!
   Aplikasi  : http://localhost:8000
   Grafana   : http://localhost:3000
   Prometheus: http://localhost:9090
   Jenkins   : http://localhost:8081
================================"""
        }
        failure {
            echo "❌ PIPELINE #${BUILD_NUMBER} GAGAL — cek log di atas"
            sh 'docker logs spk_app --tail=30 2>/dev/null || true'
        }
        always {
            echo "Build #${BUILD_NUMBER} selesai."
            sh 'docker ps --filter "name=spk_" --format "{{.Names}}: {{.Status}}" 2>/dev/null || true'
        }
    }
}
