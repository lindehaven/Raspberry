# Raspbian LAMP Install

## (L) Linux
    sudo bash
    apt-get update
    apt-get upgrade

## (A) Apache
    apt-get install -y apache2 apache2-doc apache2-utils
    systemctl enable apache2.service
    systemctl start apache2.service

## (M) Maria DB
    apt-get install -y mariadb-server
    mysql_secure_installation

## (P) PHP
    apt-get install -y libapache2-mod-php
    apt-get install -y php php-apcu php-curl php-mbstring php-gd php-mysql php-opcache php-pear
    systemctl restart apache2.service
    php -v

## Python module for MariaDB
    apt-get install -y python-mysqldb

## Remove trashed installations (if needed)
    apt autoremove

## Clean-up
    apt-get clean
