FROM mariadb

ENV MYSQL_ROOT_PASSWORD svhpokal

# When a container is started for the first time, a new database with the specified name 
# will be created and initialized with the provided configuration variables. Furthermore, 
# it will execute files with extensions .sh, .sql and .sql.gz that are found in 
# /docker-entrypoint-initdb.d. Files will be executed in alphabetical order.

COPY  crdb.sql /docker-entrypoint-initdb.d/


