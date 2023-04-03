# Installing
Use composer to install this extension to your Laravel admin project:
```
composer require abyssgoing/task-scheduling
```

Add `TaskScheduleServiceProvider` to the providers array of your Laravel applications's config/app.php
```php
Encore\Admin\TaskScheduling\Providers\TaskScheduleServiceProvider::class
```

Run the migration
```
php artisan migrate:migrate --path=vendor/abyssgoing/task-scheduling/database/migrations
```

Refresh the migration
```
php artisan migrate:refresh --path=vendor/abyssgoing/task-scheduling/database/migrations
```

## License
This software is released under the [MIT](LICENSE) License.