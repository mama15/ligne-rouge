pipeline {
    environment {
        SONAR_SCANNER_HOME = '/opt/sonar-scanner-6.0.0.4432-linux'
        SONAR_HOST_URL = 'http://sonarqube:9000'
        SONAR_TOKEN = 'squ_97f5bdbfdd12d0f0a62c829a66f7573590201d71'
        // webDockerImageName = "martinez42/ligne-rouge-web"
        // dbDockerImageName = "martinez42/ligne-rouge-db"
        // webDockerImage = ""
        // dbDockerImage = ""
        // registryCredential = 'docker-credentiel'
        // KUBECONFIG = "/home/rootkit/.kube/config"
        // TERRA_DIR  = "/home/rootkit/ligne-rouge/terraform"
        // ANSIBLE_DIR = "/home/rootkit/ligne-rouge/ansible"
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
                withSonarQubeEnv('SONARQUBE') {
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
    //    stage('Pushing Images to Docker Registry') {
    //         steps {
    //             script {
    //                 def dockerRegistry = "https://registry.hub.docker.com/"
    //                 def dockerUsername = "martinez42"
    //                 def dockerPassword = "Passer@4221"
    //                 sh "docker login $dockerRegistry -u $dockerUsername -p $dockerPassword"
    //                 sh "docker push ligne-rouge_master-web:latest"
    //                 sh "docker push ligne-rouge_master-sonarqube:latest"
    //                 sh "docker push ligne-rouge_master-postgres:latest"
    //                 sh "docker push ligne-rouge_master-db:latest"
    //             }
    //         }
    //     }
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