## Installation

1. composer install
1. copy .env.example ke .env kemudian atur konfigurasi di .env (database, app_url, dll)
1. generate application key ``php artisan key:generate``
1. migrasi tabel database ``php artisan migrate``
1. seed database data ``php artisan db:seed``