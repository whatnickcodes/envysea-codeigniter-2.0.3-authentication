# Open Source Codeigniter Authentication.

A complete web sample and template of a secure authentication system using the Codeigniter PHP framework. Very simple configuration, as most of it has been done in this sample.


## Authored by: envysea.com

## Demo available at envysea.com/showcase/openm

## Requirements

PHP version 5.1.6 or newer.

## Changes

Updated to CodeIgniter 2.1.0

## Intro and Notes

1.	Cross-site request forgery protection (CSRF)
2.	Protects against cross-site scripting (XSS)
3. 	Encrypted Cookies and sessions are securely stored in the database
4.	Utilizes query bindings and active records -- all queries are escaped
5.	Site is divided into three sections: normal pages, secure pages, and admin pages
6.	Windows 8 Developer Preview 8102 will have problems logging in
7.	Remember me cookies/persistent login deliberately left out, message me for the code if you would like it


## Installation Instructions

###	Installing

1.	Unzip package
2.	Upload entire folders to server
3.	Create a database on your server, import envysea.sql (phpMyAdmin)
4.	Go to application/config/config.php
5.	Change $config['base_url'] to your base URL
6.	Change $config['encryption_key'] to a completely random character string (random means random -- uppercase, lowercase, number, symbol, etc. and do not leave it as the current value)
7.	Go to application/config/envysea.php and make all changes between the comment blocks
8.	Open application/config/database.php and enter your database paramters (username, password, database)
9.	Open site and enjoy

###	Creating your users
1.	There are two users by default - username: "admindude", password: "admindude" and username: "normaldude", password: "normaldude" - We are going to delete both of them and create your own separate to your site
2.	On the website go to members, create two users -- one for normal access and one for normal access
3.	Login with "admindude, "admindude"
4.	Go to the admin panel, go to make someone an admin, make your new admin an admin
5.	Logout, and login with the newly created admin
6.	Go to the admin panel, and delete the two default users (admindude and normaldude)
7.	You are now 100% done with the installation and have a fully featured membership site unique and secure to you


##	Documentation

### To be continued

The "module" variable is just a way for you to distinguish which header and footer you want to use when loading views:
-	Use the envysea module when loading views for all normal access websites
-	Use the secure module when loading views for all secure pages
-	Use the admin module when loading views for all admin pages

The construct of controllers require:
-	Nothing (no code) for normal pages
-	$this->auth->is_logged_in() for secure pages
-	$this->auth->is_logged_in() and $this->auth->is_admin() for admin pages

Auth Library
-	The create function in the auth library is shared between the normal user registration and the admin create a person views
-	The update function in the auth library is shared between the normal user account update and the admin update a person views
-	The delete function in the auth library is shared between the normal user account delete and the admin update a person views

Feel free to email me at ncerminara@envysea.com for questions or help. Unfortunately the rest of this documentation will have to be continued at a later