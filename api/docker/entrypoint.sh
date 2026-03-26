#!/bin/sh
set -e

echo "Aguardando banco em $DB_HOST:$DB_PORT..."

until php -r "
try {
    new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
    echo 'Banco pronto.\n';
} catch (Exception \$e) {
    exit(1);
}
"; do
  sleep 2
done

if [ ! -f /var/www/html/vendor/autoload.php ]; then
  echo "Vendor não encontrado. Rodando composer install..."
  composer install --no-interaction --prefer-dist
else
  echo "Vendor encontrado."
fi

php artisan optimize:clear
php artisan migrate --force

exec php artisan serve --host=0.0.0.0 --port=8000
