## CS6400 GT_Online Sample Project

## Introduction

- Tech Stack: WAMP (Windows, Apache, MySQL, PHP)

## Technology

- Tech Stack: WAMP (Windows, Apache, MySQL, PHP)
- Languages: HTML, CSS, PHP, MySQL
- Database: MySQL

## Configuring the application

```
define('DB_HOST', "localhost");
define('DB_PORT', "3306");
define('DB_USER', "gatechUser");
define('DB_PASS', "gatech123");
define('DB_SCHEMA', "cs6400_fa17_team001");
```

Then run the SQL script through phpMyAdmin --> Import to create the DB you need.
![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spr17/6400Spring17_Phase3_Sample_Submission/blob/master/img/import_sql.png)

Then restart your Apache server: (here alternative http port 8080 is used)
Now launch the URL:
[http://localhost:8080/Phase3_Sample_Submission/login.php](http://localhost:8080/Phase3_Sample_Submission/login.php)

Lastly, login with username and password below (prefilled):

```
username: michael@bluthco.com
password: michael123
```

Note: by default, the queries are shown to the user as a learning tool. To turn this off, flip the boolean flag on lib/common.php for the showQueries = false;

If needed, read the server logs:
Bitnami \*AMP Stack Manager Tool --> Manager Server --> Configure --> Open Error Log:

![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spr17/6400Spring17_Phase3_Sample_Submission/blob/master/img/error_log.png)

### Congratulations!

You've successfully set up the GT_Online project on your local development machine!

## Authors

- **TeamMember1Name** email: [uid1@gatech.edu](mailto:uid1@gatech.edu)
- **TeamMember2Name** email: [uid2@gatech.edu](mailto:uid2@gatech.edu)
- **TeamMember3Name** email: [uid3@gatech.edu](mailto:uid3@gatech.edu)
- **TeamMember4Name** email: [uid4@gatech.edu](uid4@gatech.edu)
