# Setting Up the Project with Laravel Sail

## 1. Create Environment File

Make a copy of the `.env.example` file and name it `.env`. This file contains environment-specific configurations for your Laravel application.

```bash
cp .env.example .env
```

## 2. Install Dependencies

If you don't have Composer installed on your local machine, you can utilize a Docker container to handle the PHP dependencies:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install
```

## 3. Start Laravel Sail

To initialize the Laravel Sail environment, you'll want to run the following command:

```bash
./vendor/bin/sail up -d
```
## 4. Run Application Tests

After setting up your environment with Laravel Sail, it's a good practice to ensure everything is working as expected. To run your application's tests:

```bash
./vendor/bin/sail artisan test

