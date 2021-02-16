# Setup
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `rm -rf vendor/64robots/nova-fields`
6. `ln -s ../nova-fields vendor/64robots/nova-fields`

7. Inside nova-fields pacakge `yarn watch`