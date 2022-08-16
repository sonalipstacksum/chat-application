# chat-application

## How to setup 

### Step 1 : Clone the git url

### Step 2 : Install the composer dependency
`composer install`

### Step 3 : Install the npm packages
`npm install`
`npm run watch`

### Step 4 : Copy the environment file
Copy the `.env.example` file and rename it to `.env`. Set the database connection details into it.
After that to clear the cache run below command
`php artisan cache:clear`
`php artisan config:cache`

### Step 5 : Run migration files and add fake data for users
`php artisan migrate`
`php artisan db:seed`

### Step 7 : Now serve the project
`php artisan serve`

### Step 7 : Start socket server to send and receive the messages
`php artisan websocket:init`

