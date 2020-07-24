---
layout: post
title: Things about Rails
categories: Technology
tags: Ruby on Rails
---

Just some very brief and rough notes taken from my recent Ruby on Rails experience. Stuffs include:

* How to set up a Rails production server
* How to set up a development environment
* How to deploy the application to the server
* Something about PostgreSQL

Server-side Installation 
=======================

1. Generate key, put public key on GitHub. [Reference] (https://help.github.com/articles/generating-ssh-keys)

2. Install RVM + Ruby + Gem + Rails

		\curl -sSL https://get.rvm.io | bash -s stable --rails --ruby=<version>
		echo '[[ -s "/usr/local/rvm/scripts/rvm" ]] && . "/usr/local/rvm/scripts/rvm" >> ~/.bashrc

3. Allow development group's member to write to the RVM directory

		chgrp -R <developer group> /usr/local/rvm

6. Install Apache and PostgreSQL

		aptitude install apache2 postgresql-common postgresql-9.3 libpq-dev

7. Install gems for production

		gem install bundler
		gem install pg
		gem install passenger
		passenger-install-apache2-module
		bundle install

8. Configure Apache with SSL

		vim /etc/apache2/http.conf


		1 LoadModule passenger_module /usr/local/rvm/gems/ruby-<version>/gems/passenger-<version>/buildout/apache2/mod_passenger.so
		2    <IfModule mod_passenger.c>
		3      PassengerRoot /usr/local/rvm/gems/ruby-<version>/gems/passenger-<version>
		4      PassengerDefaultRuby /usr/local/rvm/gems/ruby-<version>/wrappers/ruby
		5    </IfModule>
		6 
		7 <VirtualHost *:80>
		8     ServerName <your server name>
		9     ServerAlias <your other server name>
		10     Redirect permanent / https://<your server name>/
		11 </VirtualHost>
		12 
		13 <VirtualHost *:443>
		14     SSLEngine on
		15     SSLCertificateFile /etc/apache2/ssl.crt/<crt>
		16     SSLCertificateKeyFile /etc/apache2/ssl.key/<key>
		17     DocumentRoot <your document directory>
		18     ServerName <your server name>
		19     ServerAlias <your other server name>
		20     RailsEnv production
		21     <Directory <your document directory>>  
		22         SSLRequireSSL
		23         Options -MultiViews
		24     </Directory>
		25 </VirtualHost>


		a2enmod ssl
		a2enmod headers

9. Set up document root
		
		mkdir <your document directory>
		chgrp -R <developer group> <your document directory>
		chmod -R 775 <your document directory>

10. Set up SSL certificate
	* Buy/get/generate a set of certificate file using the corresponding key.
	* Create a SSL certificate chain [intermed-1] -> [intermed-2] -> [root](optional) by ``cat [intermed-1.crt] [intermed-2.crt] [root.crt] > CAchain.crt``
	* Put CAchain.crt in /etc/apache2/ssl.crt/
	* Put the user SSL certificate in /etc/apache2/ssl.crt/
	* Put the key file in /etc/apache2/ssl.key/
	* Set all the key and certificate files as read only by root (chmod 400).

Client-side Setting
=======================

1. Generate SSH key, put public key on the server (for Capistrano) and GitHub

2. Install RVM + Ruby + Gem + Rails (May need sudo or root access, depending on your client machine settings)

		\curl -sSL https://get.rvm.io | bash -s stable --rails --ruby=<version>
		echo '[[ -s "/usr/local/rvm/scripts/rvm" ]] && . "/usr/local/rvm/scripts/rvm" >> ~/.bashrc

3. Get source code from GitHub

		cd <your project directory>
		git clone <your git project location>

4. Install gems for development

		cd <your project directory>
		gem install bundler
		rvmsudo bundle install --without production

5. Edit Capistrano settings 

		vim config/deploy/production.rb

Development and Deployment
=======================

1. Do your own development, to run development server

		// Put database.yml under config/
		rake db:migrate
		rails s -p <port>

2. Commit the updates to GitHub

		git add .
		git commit -m "<log message>"
		git push origin

3. Deploy the source code (update the production server)

		cap production deploy

4. If some things fail after deployment, it is useful to check ``/var/log/apache2/error.log`` on the server.

Database Administration
=======================

### Account information

* Check the user name, password and database name in the server ``database.yml``

### Backup

		pg_dump -U <user name> -h localhost -Fc -f <backup file name> <database name>

### Restore data

		service apache2 stop
		dropdb -U <user name> -h localhost <database name>
		pg_restore -U <user name> --password -h localhost -v -C -d template1 <backup file name>
		service apache2 start

### Access database via command prompt

		psql -U <user name> -h localhost -d <database name>

### Access database via rails console

		Login your server
		Go to <your project directory>
		rails console production [gem install rails (as root) if console fails to start]
		//useful commands:
		//	User.find(1)
		//	User.find_by(name: "")
		//	User.set_attribute(:admin, false)
	
Useful Websites
=======================

* [Ruby Version Manager (RVM)](http://rvm.io/)
* [How To Setup Ruby on Rails with Postgres](https://www.digitalocean.com/community/articles/how-to-setup-ruby-on-rails-with-postgres)
* [How to Create and Install an Apache Self Signed Certificate](https://www.sslshopper.com/article-how-to-create-and-install-an-apache-self-signed-certificate.html)
* [Ruby on Rails Tutorial](http://ruby.railstutorial.org/ruby-on-rails-tutorial-book)

