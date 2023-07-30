#!/bin/bash

  php artisan migrate --seed
  php artisan storage:link
  php artisan config:clear
  php artisan cache:clear
  php artisan view:clear
  php artisan route:clear
  composer dump-autoload

