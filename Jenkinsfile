pipeline {
    environment {
        webDockerImageName = "martinez42/ligne-rouge-web"
        dbDockerImageName = "martinez42/ligne-rouge-db"
        webDockerImage = ""
        dbDockerImage = ""
        registryCredential = 'docker-credentiel'
        kube_config = "/home/rootkit/.kube/config"
        terra_dir = "/home/rootkit/ligne-rouge/terraform"
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
        stage("Terraform Initialiization") {
            steps {
                script {
                    sh "sudo chmod +w ${terra_dir}"
                    sh "cd ${terra_dir} && terraform init"
                }
            }
        }
        stage("Terraform Plan") {
            steps {
                script {
                    sh "cd ${terra_dir} && terraform plan"
                }
            }
        }
        stage("Terraform Apply") {
            steps {
                script {
                    sh "cd ${terra_dir} && terraform apply --auto-approve"
                }
            }
        }
    }
    post {
        success {
            slackSend channel: 'groupe4', message: 'Success to deploy'
        }
        failure {
            slackSend channel: 'groupe4', message: 'Failed to deploy'
        }
    }
}