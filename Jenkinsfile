pipeline {
  agent any
  stages {
   
    stage ('test') {
      steps {
        sh 'docker ps -a'
      }
    }
    stage ('Run Docker Compose') {
      steps {
        sh 'docker-compose up  -d'
      }
    }
  }
  post {
    success {
      slackSend channel: 'groupe4', message: 'succe'
    }
    failure {
      slackSend channel: 'groupe4', message: 'echou'
    }
  }
}
// b
