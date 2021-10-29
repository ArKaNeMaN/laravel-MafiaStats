@echo off

php artisan ide-helper:models --reset --nowrite
php artisan ide-helper:generate
php artisan ide-helper:meta

echo .
set /p q=Done.
