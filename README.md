## Context

Technical test for job application at Fareva IT Apps.

## Requirements

-   Apache
-   PHP >= 8.0
-   Mysql
-   Composer

## Installation

-   Create a virtual host for the app, pointing to the public folder and with this config (public folder and apache2 paths to your discretion):

```
<VirtualHost *:80>
	DocumentRoot "/var/www/fareva-test/public"
	<Directory "/var/www/fareva-test/public">
		Options +FollowSymLinks
		AllowOverride all
		Require all granted
	</Directory>
	ErrorLog /var/log/apache2/error.fareva-test.log
	CustomLog /var/log/apache2/access.fareva-test.log combined
</VirtualHost>
```

-   Install dependencies :

```
composer install
```

-   Change the .env file at the root of the project by defining database variables depending on your mysql user's credentials, for example:

```
DB_HOST = localhost
DB_NAME = fareva_test
DB_USER = <your user>
DB_PASSWORD = <your user's password>
```

(if the .env file doesn't exist, create it.)
