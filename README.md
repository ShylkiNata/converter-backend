# backend
1. run:
composer update
2. copy .env.example to .env
3. generate the API key:
php artisan key:generate 
4. publish the config file for JWT using the following command:
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
5. set the jwt-auth secret:
php artisan jwt:secret
6. publish CORS configs:
php artisan vendor:publish --provider="Barryvdh\Cors\ServiceProvider"
7. Create symlink:
php artisan storage:link
