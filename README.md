# Moja Strona WWW

[![Strona CI](https://github.com/onufry7/Strona/actions/workflows/test.yml/badge.svg)](https://github.com/onufry7/Strona/actions/workflows/test.yml)

Moja prywatna strona na której znajdują się:

- Kolekcja gier planszowych.
- Moje projekty.
- Proste szyfry.

## Wymagania

- Laravel 12
- Composer 2
- Wersja **PHP 8.4**
- Wersja **Node.js 22.14**
- Baza danych: **MariaDB 10**

## Konfiguracja PHP

- Wymagane rozszerzenie **GD** *(php.ini => extension=gd)*
- Pamiętać aby rozszerzenie **exif** było po **mbstring**
- Włączone rozszerzenia PHP:
  - zip, pcov, apcu, soap, pdo_sqlite, pdo_mysql, openssl, mysqli, mbstring, exif, intl, ftp, fileinfo, gd, gettext

## Instalacja

```bash
    git clone https://github.com/onufry7/strona.git
```

```bash
    cd strona
```

- Utworzyć plik .env
- Skopiować zawartość pliku .env.example do pliku .env
- Skonfigurować plik .env pod własne środowisko. (Baza danych, mail, nazwa strony etc.)

```bash
    composer install
```

```bash
    php artisan key:generate
```

```bash
    npm install
```

```bash
    php artisan migrate
```

```bash
    php artisan db:seed
```

```bash
    php artisan storage:link
```

Środowisko developerskie

```bash
    php artisan serve
```

```bash
    npm run dev
```

Lub w jednym kroku (jeśli używasz skrótu):

```bash
    composer dev
```

środowiska produkcyjne

```bash
    npm run build
```

## Zależności

PROD

- **[Laravel Framework](https://laravel.com)**
- **[Laravel Jetstream](https://jetstream.laravel.com/introduction.html)**
- **[Laravel Sanctum](https://github.com/laravel/sanctum)**
- **[Laravel Tinker](https://github.com/laravel/tinker)**
- **[Laravel Livewire](https://laravel-livewire.com)**
- **[Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf)**
- **[Laravel Breadcrumbs](https://github.com/diglactic/laravel-breadcrumbs)**
- **[Blade RPG Awesome Icons](https://github.com/codeat3/blade-rpg-awesome-icons)**
- **[Blade UI Kit - Blade Icons](https://blade-ui-kit.com/blade-icons)**

DEV

<!-- - **[PhpMetrics (DEV)](https://phpmetrics.org)** -->
- **[PHPUnit (DEV)](https://phpunit.de/index.html)**
- **[PHPStan (DEV)](https://phpstan.org)**
- **[PHPStan PHPUnit (DEV)](https://github.com/phpstan/phpstan-phpunit)**
- **[Larastan (DEV)](https://github.com/larastan/larastan)**
- **[Laravel Pint (DEV)](https://github.com/laravel/pint)**
- **[Laravel Debugbar (DEV)](https://github.com/barryvdh/laravel-debugbar)**
- **[Laravel Sail (DEV)](https://github.com/laravel/sail)**
- **[Laravel Ignition (DEV)](https://github.com/spatie/laravel-ignition)**
- **[Faker (DEV)](https://fakerphp.org)**
- **[Mockery (DEV)](https://docs.mockery.io/en/stable)**
- **[Collision (DEV)](https://github.com/nunomaduro/collision)**

## Testowanie i walidacja kodu

Testowanie aplikacji można wykonać komendą:

```bash
    composer test-app
```

*Wykona ona kolejno:*

1. Laravel Pint: `vendor/bin/pint`,
2. PHPStan: `vendor/bin/phpstan analyse`,
3. Testy: `php artisan test`,

---

### Laravel Pint

- Automatycznie napraw problemy z kodem:

    ```bash
        vendor/bin/pint
    ```

- Sprawdź kod bez dokonywania zmian:

    ```bash
        vendor/bin/pint --test
    ```

- Szczegółowe informacje o plikach i błędach: *flaga* `-v`

---

### PHPStan

- Statyczna analiza kodu:

    ```bash
        vendor/bin/phpstan analyse
    ```

---

### Testy "PHPUnit"

- Uruchomienie testów:

    ```bash
        php artisan test
    ```

---

### Aktualizacje

- Aplikację można zaktualizować komendą:

    ```bash
        composer project-update
    ```

---
