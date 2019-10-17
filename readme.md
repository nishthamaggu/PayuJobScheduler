# PayuJobScheduler

PHP - 7.1  
Laravel - 5.7  
mysql - 5.7  

**clone the project**

`git clone git@github.com:nishthamaggu/PayuJobScheduler.git`

**install composer**


    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
    composer -V


**Move to the project folder**

    cd {project path}

**Run composer**

    composer install
    
**Give permission to folders**
    
    sudo chmod -R 777 storage
    sudo chmod -R 777 bootstrap
    
**Copy .env file**

    cp .env.example .env

**Generate Key**
    
    php artisan key:generate

**Change variables inside .env accordingly**
    
    DB_DATABASE=<database_name>
    DB_USERNAME=<user>
    DB_PASSWORD=<password>


**Generate Database**

    php artisan migrate

**Running Seeder**

    composer dump-autoload
    php artisan db:seed --class=PaymentTableSeeder

**Running Queue**

    php artisan queue:work
