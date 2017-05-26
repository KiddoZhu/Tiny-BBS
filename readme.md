# Tiny BBS

A simple bulletin board system based on PHP and MySQL.

![](https://github.com/KiddoZhu/Tiny-BBS/blob/master/pic/cover.png)

## Features
- Login system
- Post and reply
- Permission Rules
- SQL injection free


## Installation

1. Install `Apache`, `PHP` and `MySQL`.
```
sudo apt-get install apache2
sudo apt-get install libapache2-mod-php5 php5
sudo apt-get install mysql-server mysql-client
```
MySQL will require a password for the root during the installation.

2. You may also install `phpmyadmin` if you want to visualize the database.
```
sudo apt-get install phpmyadmin
sudo ln -s /usr/share/phpmyadmin /path/to/site
```
Choose apache2 as the web server, and enter your root password for MySQL.

3. Add the following lines to `/etc/apache2/sites-enabled/000-default.conf` to config the site.
```
DocumentRoot /path/to/site
<Directory /path/to/site/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
```
And restart your apache by
```
sudo /etc/init.d/apache2 restart
```

4. Modify `utils/connect.php` with your root password and your database name.

5. Reset the database through `localhost/init.html` in your browser.

## Now you can enjoy Tiny BBS!