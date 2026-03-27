#!/bin/sh
set -e

echo "Aguardando vendor..."

until [ -f /var/www/html/vendor/autoload.php ]; do
  sleep 2
done

echo "Vendor pronto."

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

exec php artisan queue:work --tries=3 --timeout=90
