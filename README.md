<p align="center"><img src="https://redmedial.com/dist/img/logo.svg" width="600"></p>

----------

## Installation

Please check the official laravel installation guide for server requirements before you start.
[Official Documentation](https://laravel.com/docs/master)

- Clone the repository `git clone git@gitlab.com:Sheshlyuk/redmedial.git`
- Switch to the repo folder
- Install all the dependencies using composer and npm
- Copy the example env file and make the required configuration changes in the .env file
- Generate a new application key
- Run the database migrations (**Set the database connection in .env before migrating**)
- Run `npm run prod`
- Start the local development server
- Run the database seeder and you're done `php artisan db:seed`

# Code overview

## Main dependencies

### PHP

Name | 
--- | 
laravel/framework | 
nwidart/laravel-modules | 
inertiajs/inertia-laravel | 
laravel/sanctum|
willvincent/feeds|
dingo/api|

### JS

Name | 
--- | 
vue |
@inertiajs/inertia-vue |
@vue/composition-api |
bootstrap-vue |
lodash |

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application
fully working.

## API Specification

> [Full API Spec](https://api.redmedial.com/apidoc/)

Scheduler: <code>/opt/php74/bin/php /var/www/h27990i/data/www/redmedial.com/artisan schedule:run</code>
