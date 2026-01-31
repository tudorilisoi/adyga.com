#!/bin/bash
set -a  # automatically export all variables
source /etc/container.env
set +a

# TODO fix this for wp snapshots

# 1. Backup
wp db export pre-migration-backup.sql

# 2. Update WordPress URLs
wp option update home 'https://newdomain.com'
wp option update siteurl 'https://newdomain.com'

# 3. Replace URLs in content
wp search-replace 'https://olddomain.com' 'https://newdomain.com' --dry-run
wp search-replace 'https://olddomain.com' 'https://newdomain.com'

# 4. Clear caches and flush rewrites
wp cache flush
wp rewrite flush

# 5. Verify
wp option get home
wp option get siteurl

