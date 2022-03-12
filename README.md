# Локальная установка
# 1. Установка зависимостей

```
composer install
```

# 2. Создание базы данных и миграция данных
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

# 3. Запуск воркера
Если запустить несколько воркеров, то задачи будут уходить в работу в асинхронном режиме
```
bin/console buzmarev:run-worker
```

# 4. Запуск сервера
```
symfony server:start
```
Будет работать сайт http://localhost:8000/