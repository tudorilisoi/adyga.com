#!/bin/bash

if [ "$ROOTLESS_DOCKER" = "no" ]; then
    echo "Running as docker root"
    # Your command here
    chown -R www-data:www-data /var/www/html
    echo "chown to www-data and chmod"
    chown -R www-data:www-data /var/www/html
    chmod -R 755 /var/www/html
fi

# echo "User: "
# whoami
# id
# id -g
# echo "ENV: "
# printenv
# exit;

printenv | grep DB_ >/etc/container.env
printenv | grep WP_ >>/etc/container.env
# printenv | grep WORDPRESS_ >> /etc/container.env
echo "PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin" >>/etc/container.env
cat /etc/container.env

# echo "Starting rsyslog (for cron logging)"
# service rsyslog start

# Start cron service
echo "Starting cron"
# service cron start
cron -f 2>&1 &

# Start PHP-FPM
echo "Starting PHP"
php-fpm -D -R

# Start Nginx
if [ "$WP_ENV" = "dev" ]; then
    echo "Starting Nginx"
    nginx -g "daemon off;" &
else
    echo "*** Skipping nginx ***"
fi

# Keep container running and capture logs
tail -f /var/log/cron.log /var/log/cron/wp-cron.log /var/log/nginx/access.log /var/log/nginx/error.log
