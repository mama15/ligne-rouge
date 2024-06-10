CREATE ROLE sonar WITH LOGIN PASSWORD 'votre_mot_de_passe';
ALTER ROLE sonar CREATEDB;
CREATE DATABASE sonarqube OWNER sonar;
