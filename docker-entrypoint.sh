#!/bin/sh
set -e

# Bind-mounted host files (esp. on Windows) can land with permissions that
# block www-data from writing runtime state - panel login attempts, and
# content edited through the panel (data/*.json, uploads/*). Normalize on
# every start so a fresh mount never leaves the panel throwing "Permission
# denied" warnings.
chmod 666 /var/www/html/panel/_attempts.json 2>/dev/null || true
chmod -R a+rwX /var/www/html/data /var/www/html/uploads 2>/dev/null || true

exec "$@"
