# Installing
Use composer to install this extension to your Laravel admin project:
```
composer require abyssgoing/task-scheduling
```

## Publish Resources
```
php artisan vendor:publish --provider="Encore\Admin\TaskScheduling\Providers\TaskScheduleServiceProvider"
```

Run the migration
```
php artisan migrate:migrate --path=vendor/abyssgoing/task-scheduling/database/migrations
```

Refresh the migration
```
php artisan migrate:refresh --path=vendor/abyssgoing/task-scheduling/database/migrations
```

## Screenshots
### Task List
<img src="https://raw.githubusercontent.com/abyssgoing/task-scheduling/main/screenshots/task-list.png?raw-true" alt="Task List"/>

### Task Detail
<img src="https://raw.githubusercontent.com/abyssgoing/task-scheduling/main/screenshots/task-detail.png?raw-true" alt="Task Detail"/>

## License
This software is released under the [MIT](LICENSE) License.