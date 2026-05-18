#!/usr/bin/env bash
set -euo pipefail

exec php artisan queue:work --sleep=3 --tries=3 --timeout=90
