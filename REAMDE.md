# Installing
Use composer to install this extension to your Laravel admin project:
```
composer require laravel-admin-extensions/task-scheduling
```

Add `TaskScheduleServiceProvider` to the providers array of your Laravel applications's config/app.php
```php
Encore\Admin\TaskScheduling\Providers\TaskScheduleServiceProvider::class
```

Run the migration
```
php artisan migrate ./vendor/laravel-admin-ext/task-scheduling/database/migrations
```

# License
This software is released under the MIT License.