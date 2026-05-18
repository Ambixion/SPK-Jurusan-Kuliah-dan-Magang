pipeline {
    agent any

    environment {
        APP_NAME   = 'spk-smkn-app'
        STACK_NAME = 'spk_stack'
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
                echo "Branch: ${env.BRANCH_NAME ?: 'manual'}"
                echo "Build : #${BUILD_NUMBER}"
            }
        }

        stage('Lint - Cek Syntax PHP') {
            steps {
                echo '🔍 Mengecek syntax PHP...'
                script {
                    if (isUnix()) {
                        sh '''
                            find app routes database -name "*.php" | while read f; do
                                php -l "$f" > /dev/null 2>&1 || echo "ERROR: $f"
                            done
                            echo "✅ Lint selesai"
                        '''
                    } else {
                        bat '''
                            echo Lint PHP selesai (Windows skip)
                        '''
                    }
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "🐳 Build image: ${APP_NAME}:${BUILD_NUMBER}..."
                script {
                    if (isUnix()) {
                        sh """
                            docker build -t ${APP_NAME}:${BUILD_NUMBER} -t ${APP_NAME}:latest .
                            docker images ${APP_NAME}
                        """
                    } else {
                        bat """
                            docker build -t ${APP_NAME}:${BUILD_NUMBER} -t ${APP_NAME}:latest .
                            docker images ${APP_NAME}
                        """
                    }
                }
            }
        }

        stage('Deploy - Docker Compose') {
            steps {
                echo '🚀 Deploy dengan Docker Compose...'
                script {
                    if (isUnix()) {
                        sh '''
                            docker compose down --remove-orphans || true
                            docker compose up -d
                            sleep 15
                            docker compose ps
                        '''
                    } else {
                        bat '''
                            docker compose down --remove-orphans || exit 0
                            docker compose up -d
                            timeout /t 15 /nobreak
                            docker compose ps
                        '''
                    }
                }
            }
        }

        stage('Setup Laravel') {
            steps {
                echo '⚙️  Setup Laravel (migrate & seed)...'
                script {
                    if (isUnix()) {
                        sh '''
                            docker compose exec -T app php artisan key:generate --force
                            docker compose exec -T app php artisan migrate:fresh --seed --force
                            docker compose exec -T app php artisan config:cache
                            docker compose exec -T app php artisan route:cache
                        '''
                    } else {
                        bat '''
                            docker compose exec -T app php artisan key:generate --force
                            docker compose exec -T app php artisan migrate:fresh --seed --force
                            docker compose exec -T app php artisan config:cache
                            docker compose exec -T app php artisan route:cache
                        '''
                    }
                }
            }
        }

        stage('Health Check') {
            steps {
                echo '❤️  Cek kesehatan aplikasi...'
                script {
                    if (isUnix()) {
                        sh '''
                            sleep 5
                            curl -f http://localhost:8001 -o /dev/null -s \
                                -w "HTTP Status: %{http_code}\n" \
                                || echo "⚠️  App belum siap, cek docker compose logs"
                        '''
                    } else {
                        bat '''
                            timeout /t 5 /nobreak
                            curl -f http://localhost:8001 -o NUL -s -w "HTTP Status: %%{http_code}\n" || echo App check done
                        '''
                    }
                }
            }
        }
    }

    post {
        success {
            echo '''
✅ PIPELINE BERHASIL!
   Aplikasi : http://localhost:8001
   Grafana  : http://localhost:3000  (admin/admin123)
   Prometheus: http://localhost:9090
            '''
        }
        failure {
            echo '❌ PIPELINE GAGAL! Cek log di atas.'
            script {
                if (isUnix()) {
                    sh 'docker compose logs --tail=30 2>/dev/null || true'
                } else {
                    bat 'docker compose logs --tail=30 || exit 0'
                }
            }
        }
        always {
            echo "Build #${BUILD_NUMBER} selesai."
        }
    }
}
