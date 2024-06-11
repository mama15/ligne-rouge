pipeline {
    environment {
        SONAR_SCANNER_HOME = '/opt/sonar-scanner-6.0.0.4432-linux'
        SONAR_HOST_URL = 'http://sonarqube:9000'
        SONAR_TOKEN = 'sqp_0aa4e3fd4d34eeea2d4a5232dcb972023f6b6258'
        // webDockerImageName = "martinez42/ligne-rouge-web"
        // dbDockerImageName = "martinez42/ligne-rouge-db"
        // webDockerImage = ""
        // dbDockerImage = ""
        // registryCredential = 'docker-credentiel'
    //     KUBECONFIG = "/home/rootkit/.kube/config"
    //     TERRA_DIR  = "/home/rootkit/ligne-rouge/terraform"
    //     ANSIBLE_DIR = "/home/rootkit/ligne-rouge/ansible"
    }
    agent any
    stages {
        stage('Build Docker images') {
            steps {
                script {
                    sh 'docker-compose up --build -d'
                }
            }
        }
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh """
                    ${SONAR_SCANNER_HOME}/bin/sonar-scanner \
                    -Dsonar.projectKey=ligne-rouge \
                    -Dsonar.sources=. \
                    -Dsonar.host.url=${SONAR_HOST_URL} \
                    -Dsonar.login=${SONAR_TOKEN}
                    """
                }
            }
        }
        stage('Push Docker images to registry') {
            steps {
                script {
                    def dockerRegistry = "https://registry.hub.docker.com/"
                    sh "docker login $dockerRegistry -u martinez42 -p Passer@4221"
                    def dockerImages = [
                        "ligne-rouge_master-postgres-1:latest",
                        "ligne-rouge_master-db-1:latest",
                        "ligne-rouge_master-sonarqube-1:latest",
                        "ligne-rouge_master-web-1:latest"
                    ]
                    dockerImages.each { dockerImage ->
                        def taggedImage = "${dockerRegistry}/${dockerImage}"
                        sh "docker push ${taggedImage}"
                    }
                }
            }
        }

        // stage('Pushing Images to Docker Registry') {
        //     steps {
        //         script {
        //             docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
        //                 webDockerImage.push('latest')
        //                 dbDockerImage.push('latest')
        //             }
        //         }
        //     }
        // }
        // stage("Provision Kubernetes Cluster with Terraform") {
        //     steps {
        //         script {
        //             sh """
        //             cd ${TERRA_DIR}
        //             terraform init
        //             terraform plan
        //             terraform apply --auto-approve
        //             """
        //         }
        //     }
        // }
        // stage('Install Python dependencies and Deploy with Ansible') {
        //     steps {
        //         script {
        //             sh """
        //             sudo apt-get install -y python3-venv
        //             cd ${ANSIBLE_DIR}
        //             sudo python3 -m venv venv
        //             . venv/bin/activate
        //             pip install kubernetes ansible
        //             ansible-playbook ${ANSIBLE_DIR}/playbook.yml
        //             """
        //         }
        //     }
        // }
    }
    // post {
    //     success {
    //         slackSend channel: 'groupe4', message: 'Success to deploy'
    //     }
    //     failure {
    //         slackSend channel: 'groupe4', message: 'Failed to deploy'
    //     }
    // }
}