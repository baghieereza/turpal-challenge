# Turpal - Technical Challenge

## Description

to run the project please follow these steps : 
1. run ``composer update``
2. copy and create new ``.env`` file from ``.env.example`` file
3. run ``php artisan migrate``

### pull data from Heavenly Tours

to pulling data from this 3d party you must run this command : 
`` php artisan heavenlyTours:pull
``

### searching
now for searching you can search by this endpoint
``{baseurl}/api/search``

### implementation

1. A new module for integration with Heavenly Tours
2. A command for scheduling to pull data
