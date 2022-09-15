<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## About the Application

This application consists of managing a possible network of supermarkets.

## Installation

The first step is cloning repositorie:

    git clone https://github.com/dandrade96/Hubvet.git

After cloning the repository, install the dependencies via composer


    composer install

## Usage

Now that we're done installing the dependencies, let's run the migrations:

    php artisan migrate

With the migrations running, it's time to move up the seeders and factories:

    php artisan db:seed

>Remember that to execute the above commands your `.env` file must be configured with your database server.

## Routes

After executing all the configurations, it's time to run our application.

    php artisan serve

### Route paths

The basic routes of our application:
- login -> ```POST: {base_url}/api/login```
- Register -> ```POST: {base_url}/api/register```
- logout -> ```GET: {base_url}/api/logout```

Now let's bring the authenticated routes to the entities of our application:

### Home
This is the application overview route:
- Verb.: `GET`, URL: `{base_url}/api/supermarket/home`
#
> Entities: markets, sectors and products

### List API :

- Verb.: `GET`, URL: `{base_url}/api/supermarket/{entities}`
#
### Create API :

- Verb.: `POST`, URL: `{base_url}/api/supermarket/{entities}`
#
### Show API :

- Verb.: `GET`, URL: `{base_url}/api/supermarket/{entities}/{id}`
#
### Update API :

- Verb.: `PUT`, URL: `{base_url}/api/supermarket/{entities}/{id}`
#
### Delete API :

- Verb.: `DELETE`, URL: `{base_url}/api/supermarket/{entities}/{id}`
#
### Conclusion
After all the information above, your application will be live in full working order.