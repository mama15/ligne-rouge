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
        sh 'docker-compose up  -d --build'
      }
    }
  }
  post {
    success {
      slackSend channel: 'groupe4', message: 'build success'
    }
    failure {
      slackSend channel: 'groupe4', message: 'build error'
    }
  }
}
