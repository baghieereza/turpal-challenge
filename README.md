# Turpal - Technical Challenge

## Description

to run the project please follow these steps : 
1. run ``composer update``
2. copy and create new ``.env`` file from ``.env.example`` file
3. run ``php artisan migrate``
4. run ``composer dump-autoload``
5. finally run `` php artisan heavenlyTours:pull  `` to pulling data from **Heavenly Tours**

### searching
now you can search by this endpoint
``{baseurl}/api/search``

### implementation structure
1. A new module for integration with Heavenly Tours
2. A command for scheduling to pull data
