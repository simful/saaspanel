# Saaspanel
Saaspanel is a free and open source management system for SaaS, written in PHP using Laravel 4. Created and maintained by [Ibrahim Yusuf](http://twitter.com/ibrahimyu_).

Current features include customer, subscription, billing, support ticket, and e-mail campaign management system.


## Status
This is a work in progress and not ready for production yet, but feel free to test it. Contributions and pull requests are very much welcome.


## Installation
Saaspanel needs Composer, Grunt and Bower to be installed.

	git clone https://github.com/simful/saaspanel.git
	cd saaspanel
	composer install
	npm install
	bower install

Next, compile the assets:	

	grunt	
	
Modify `app/config/database.php` to match your database credentials, then run

	php artisan migrate

For development and testing, you can also fill the tables with dummy data.

	php artisan db:seed


## Running
To start development server:

	php artisan serve
	
And navigate your browser to `http://localhost:8000`.


## License
Saaspanel is licensed under GNU AGPL v3.
