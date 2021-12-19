## Installation

#### Clone the project

<pre>
git clone -b master https://github.com/mthomasdev/aichatexam.git masteraichat
</pre>

#### Install composer

<pre>
composer install
</pre>


#### copy/create .env

<pre>
cp .env.example .env
</pre>

#### generate key

<pre>
php artisan key:generate
</pre>

### Database 
Create your local database for this project.

#### Open .env file then update db credentials

<pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xxx
DB_USERNAME=xxx
DB_PASSWORD=xxx
</pre>

then
<pre>
php artisan config:cache
</pre>

#### run migrations and seeder

<pre>
php artisan migrate:fresh --seed
</pre>


#### install passport

<pre>
php artisan passport:install
</pre>
or
<pre>
php artisan passport:install --force
</pre>

#### optimizing project

<pre>
php artisan config:cache
php artisan route:cache
php artisan optimize
</pre>

#### run the project

<pre>
php artisan serve
</pre>
