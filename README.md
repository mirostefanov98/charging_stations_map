ChargingStationMap setup steps:

1. Clone repo - git@github.com:mirostefanov98/charging_stations_map.git
2. Install packages - composer install
3. Create database
4. Change .env values for connection to your database
5. Generate key - php artisan key:generate
6. Run migrations - php artisan migrate
7. Run seeders - php artisan db:seed --class=AdminSeeder
8. Link storage folder - php artisan storage:link
9. Start project - php artisan serve
10. Login with admin credentials:
    1.  email: admin@test.com
    2.  password: admin