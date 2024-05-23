pipeline {
    environment {
        webDockerImageName = "martinez42/ligne-rouge-web"
        dbDockerImageName = "martinez42/ligne-rouge-db"
        webDockerImage = ""
        dbDockerImage = ""
        registryCredential = 'docker-credentiel'
        KUBECONFIG = "/home/rootkit/.kube/config"
        TERRA_DIR  = "/home/rootkit/ligne-rouge/terraform"
        ANSIBLE_DIR = "/home/rootkit/ligne-rouge/ansible"
    }
    agent any
    stages {
        stage('Checkout Source') {
            steps {
                git 'https://github.com/issa2580/ligne-rouge.git'
            }
        }
        // stage('Build Web Docker image') {
        //     steps {
        //         script {
        //             webDockerImage = docker.build webDockerImageName, "-f App.Dockerfile ."
        //         }
        //     }
        // }
        // stage('Build DB Docker image') {
        //     steps {
        //         script {
        //             dbDockerImage = docker.build dbDockerImageName, "-f Db.Dockerfile ."
        //         }
        //     }
        // }
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
        stage('Set Permissions for Kubernetes Config') {
            steps {
                script {
                    sh """
                    sudo chown jenkins:jenkins ${KUBECONFIG}
                    sudo chmod 777 ${KUBECONFIG}
                    """
                }
            }
        }
        stage("Provision Kubernetes Cluster") {
            steps {
                script {
                    sh """
                    sudo chown -R jenkins:jenkins ${TERRA_DIR}
                    sudo chmod -R 777 ${TERRA_DIR}
                    cd ${TERRA_DIR}
                    terraform init
                    terraform plan
                    terraform apply --auto-approve
                    """
                }
            }
        }
        // stage('Install Python dependencies') {
        //     steps {
        //         script {
        //             sh """
        //             #!/bin/bash
        //             sudo apt-get update
        //             sudo apt-get install -y python3-venv
        //             python3 -m venv venv
        //             . venv/bin/activate
        //             pip install kubernetes ansible
        //             """
        //         }
        //     }
        // }
        // stage('Deploying with Ansible') {
        //     steps {
        //         script {
        //             sh """
        //             ansible-playbook ${ANSIBLE_DIR}/playbook.yml
        //             """
        //         }
        //     }
        // }
        stage('Install Python dependencies and Deploy with Ansible') {
    steps {
        script {
            sh """
            sudo apt-get update
            sudo apt-get install -y python3-venv
            cd ${ANSIBLE_DIR}
            sudo python3 -m venv venv
            sudo chown -R jenkins:jenkins venv
            source venv/bin/activate
            export PATH="$PATH:/usr/local/bin" 
            export ANSIBLE_CONFIG="/etc/ansible/ansible.cfg" 
            pip install kubernetes ansible
            ansible-playbook playbook.yml
            """
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