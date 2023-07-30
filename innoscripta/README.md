### Generate keys

1) generate private key :
```
openssl genrsa -out private.key 2048
```
2) get public key out of private key.
type following command in the same directory private key exists,
```
openssl rsa -in private.key -pubout -out public.key
```
3) generate encryption key
```
php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'
```

finally, put these 3 generated values in the settings.
you can achieve so using both admin dashboard and database .

### Installation

1) Create tables
```
php artisan migrate
```

2) Seed initial Data
```
php artisan db:seed
```
3) Seed initial Data
```
php artisan storage:link
```
4) Go to admin and then go to settings and change values to match your needs.

4) change admin(root) username and password in .env file, so you can log in admin panel

clear-cache :
```
php artisan config:clear
```

```
php artisan cache:clear
```

```
php artisan view:clear
```
```
php artisan route:clear
```
```
composer dump-autoload
```

## todo: duplicate role
