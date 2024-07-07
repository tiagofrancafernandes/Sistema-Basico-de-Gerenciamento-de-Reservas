## Laravel + Vue.js + Inertia.js + TailwindCSS + Primevue

### Install

```sh
composer install
```

```sh
npm install
```

```sh
cp .env.example .env
```

```sh
php artisan key:generate
```

```sh
# or change SGDB driver on .env file
touch database/database.sqlite
```

```sh
php artisan storage:link --force
```

```sh
php artisan migrate --step --seed
```

```sh
## to build assets
npm run build

## or to listen changes
npm run dev
```

```sh
php artisan serve
```

* User info
```sh
# email
admin@mail.com

#password
power@123
```

### Features

- Primevue [auto-import](https://github.com/primefaces/primevue-examples/blob/main/auto-import)
- Laravel Auth (breeze Vue)

### Links
- [Laravel](https://laravel.com/)
- [Vue.js](https://vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [TailwindCSS](https://tailwindcss.com/)
- [Primevue](https://tailwind.primevue.org/vite/)
