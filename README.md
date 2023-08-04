## Pre Installation
1. OS (Ubuntu or linux base)
1. Webserver Apache
   ``sudo apt install apache2``
1. mysql
   ``sudo apt install mysql-server``
1. PHP 7.4
   ``sudo apt install php libapache2-mod-php php-mysql``
1. Extensi PHP 
   ``sudo apt install php-xml php-gd php-zip``
1. Composer (Package Manager)
   ``sudo apt install composer``

## Installation
1. clone project kemudian masuk ke folder project
1. composer install
1. Buat database dan user database

  - masuk ke mysql ``sudo mysql``
  - ``CREATE DATABASE database_name;``
  - buat user database 
  - ``CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';``
  - ``GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';``

1. copy .env.example ke .env kemudian atur konfigurasi di .env (database, app_url, dll)

   - Setting Database
   - Sesuaikan APP_URL dengan url aplikasi ex: http://localhost atau http://ip_komputer

   
1. generate application key ``php artisan key:generate``
1. migrasi tabel database ``php artisan migrate``
1. seed database data ``php artisan db:seed``
1. Generate Oauth key ``php artisan passport:install``
1. Set vhost ke folder public project

 - masuk folder vhost ``cd /etc/apache2/sites-avaliable``
 - edit default vhost atau buat baru ``sudo nano 000-default.conf``
   edit 
   ``DocumentRoot /var/www/wms-sharp/public``
   dan 
   ``
   <Directory /var/www/wms-sharp/public>
        Options Indexes FollowSymLinks
        AllowOverride All
      allow from all
  </Directory>
   ``
  - reload web server ``sudo service apache2 reload``
1. Jika mengalami error permission / error laravel log storage lakukan langkah berikut.
   - sudo chown -R www-data:www-data <Folder Projek> / Folder yang ingin diubah permission nya.
   - masuk ke folder projek kemudian masukan perintah ls -l untuk mengecek apakah permission sudah berubah atau belum. 
2. Jika mengalami error not found lakukan langkah berikut
   - cd /etc/apache2 
   - sudo nano apache2.conf
   - cari isi file konfigurasi "<Directory /var/www/>
   Options Indexes FollowSymLinks
   AllowOverride none
   Require all granted
</Directory>"
   - ubah AllowOverride none menjadi AllowOverride All
   - Save -> restart apache menggunakan perintah sudo systemctl restart apache2.service
   - sudo a2enmod rewrite
   - sudo systemctl restart apache2.service



## Reset database ke kondisi awal
1. ``php artisan migrate:refresh``
1. ``php artisan db:seed``
