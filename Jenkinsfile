pipeline {
    environment {
        webDockerImageName = "martinez42/ligne-rouge-web"
        dbDockerImageName = "martinez42/ligne-rouge-db"
        webDockerImage = ""
        dbDockerImage = ""
        registryCredential = 'docker-credentiel'
    }
    agent any
    stages {
        stage('Checkout Source') {
        steps {
            git 'https://github.com/issa2580/ligne-rouge.git'
        }
        }
        stage('Build Web Docker image') {
        steps {
            script {
            webDockerImage = docker.build webDockerImageName, "-f App.Dockerfile ."
            }
        }
        }
        stage('Build DB Docker image') {
        steps {
            script {
            dbDockerImage = docker.build dbDockerImageName, "-f Db.Dockerfile ."
            }
        }
        }
        stage('Pushing Images to Docker Registry') {
        steps {
            script {
            docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
                webDockerImage.push('latest')
                dbDockerImage.push('latest')
            }
            }
        }
        }
        stage('Deploying to Kubernetes') {
        steps {
            script {
            kubernetesDeploy(configs: "deployment.yaml", "service.yaml")
            }
        }
        }
        stage('Deploy') {
            steps {
                withCredentials([file(credentialsId: 'kube-config', variable: 'KUBECONFIG')]) {
                    script {
                        sh 'kubectl apply -f db-deployment.yml --kubeconfig=${KUBECONFIG} --validate=false'
                        sh 'kubectl apply -f app-deployment.yml --kubeconfig=${KUBECONFIG} --validate=false'
                    }
                }
            }
        }
    }
}