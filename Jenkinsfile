pipeline {
    environment {
        webDockerImageName = "martinez42/ligne-rouge-web"
        dbDockerImageName = "martinez42/ligne-rouge-db"
        webDockerImage = ""
        dbDockerImage = ""
        registryCredential = 'docker-credential'
    }
    agent any
    stages {
        stage('Set Docker environment') {
            steps {
                sh 'export DOCKER_HOST=unix:///run/docker.sock'
            }
        }
        stage('Active minikube') {
            steps {
                sh 'minikube start'
                sh 'minikube status' // Vérifiez l'état de Minikube
            }
        }
        stage('create namespace') {
            steps {
                sh 'kubectl create namespace K8s'
            }
        }
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
        stage('Deploy to Kubernetes') {
            steps {
                script {
                    sh 'kubectl apply -f deployment-web.yaml -n K8s'
                    sh 'kubectl apply -f deployment-db.yaml -n K8s'
                    sh 'kubectl apply -f service-web.yaml -n K8s'
                    sh 'kubectl apply -f service-db.yaml -n K8s'
                }
            }
        }
    }
}
