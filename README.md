Host a website for tracking results of a shooting competition.

Each shooter makes 13 shoots. Best ten get counted. The website is used to record and display the results.

Consists of three containers:
- mariadb
- php engine
- nginx

The nginx is used unmodified. The php container is derived from standard php. But has mysql and pdo added. MariaDB container is customized to create the database and tables.
