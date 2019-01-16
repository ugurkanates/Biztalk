FROM mysql:5.7

RUN mkdir -p /docker-entrypoint-initdb.d
ADD schemas.sql /docker-entrypoint-initdb.d/script.sql
RUN chmod -R 775 /docker-entrypoint-initdb.d

ENV MYSQL_ROOT_PASSWORD my-secret-pw
