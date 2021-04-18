### 1. Clone Repository

```sh
    git clone https://github.com/pourt/blog-laravel-api.git
```

### 2. Installation Laravel Dependencies

```sh
    composer update
```

### 3. Installation VueJs Dependencies

```sh
    npm update
```

### 3. Database Setup

Edit .env file and add database credintials

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD={{password}}
```

### 4. Database Migration

```sh
    php artisan migrate
```

### 5. Seed Database

```sh
    php artisan db:seed PostSeeder
```
### 6. Run API Local Server

```sh
    php artisan serve
```

### 7. Build application and run mix watcher
```sh
    npm run dev && npm run watch
```

### 8. Access application

Open a browser and access the local URL
```
   http://127.0.0.1:8000
```