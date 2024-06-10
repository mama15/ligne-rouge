FROM sonarqube:10.3.0-community

COPY database/init-sonar-db.sql /docker-entrypoint-initdb.d/