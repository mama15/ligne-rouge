pipeline {
    agent any  
    stages {
        stage("test") {
            steps {
                echo "hello world"
            }
        }
        stage("build") {
            steps {
                sh "docker-compose up -d "
            }
        }
    }
    post {
        success {
            emailext (
                subject: "Notification de build Jenkins - Succès",
                body: "Le build de votre pipeline Jenkins s'est terminé avec succès.",
                to: "kimd03361@gmail.com",
            )
        }
        failure {
            emailext (
                subject: "Notification de build Jenkins - Échec",
                body: "Le build de votre pipeline Jenkins a échoué.",
                to: "kimd03361@gmail.com",
            )
        }
    }
}
