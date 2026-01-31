#!/bin/bash

set -a  # automatically export all variables
source /etc/container.env
set +a

# su www-data -s /bin/bash -c "cd /var/www/html && wp cron event run --due-now"
#/usr/bin/curl -s http://localhost:80/wp-cron.php?doing_wp_cron

cd /var/www/html && wp cron event run --due-now --allow-root
