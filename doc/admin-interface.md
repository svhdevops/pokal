### Admin interface
The admin interface is intended to allow data import through the web frontend. Since this is
a security issue by itself it is not enabled by default. But it may be useful for testing
and debugging. So this feature must be activated in the database by setting the field 'status'
of table 'admin' to TRUE. This can be done within the container only (see below for sample).
Not possible by using the webinterface. Once the value is set the 'dangerous' functions may
be used. The last set/added value does define the state. Older values are retained but not
evaluated.

### How to activate the admin interface
```
admin@myhost:~$ sudo docker exec -it pokal_db /bin/bash
[sudo] password for admin:
root@d61526bf81f6:/# mysql -p pokal
Enter password:

Welcome to the MariaDB monitor.  Commands end with ; or \g.
Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [pokal]> INSERT INTO admin(status) VALUES(TRUE);
Query OK, 1 row affected (0.002 sec)

MariaDB [pokal]> select status,since from admin order by since desc ;
+--------+---------------------+
| status | since               |
+--------+---------------------+
|      1 | 2020-02-16 15:56:05 |
|      0 | 2020-02-12 20:07:30 |
|      1 | 2020-02-10 21:55:33 |
|      0 | 2020-02-10 21:52:24 |
|      0 | 0000-00-00 00:00:00 |
+--------+---------------------+
5 rows in set (0.001 sec)

MariaDB [pokal]>
```
