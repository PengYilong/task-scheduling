<?php
return [
	'table_prefix' => env('TASK_SCHEDULING_TABLE_PREFIX', 'ts_'),
	'frequencies' => [
		'cron' => 'cron',
		'everyMinute' => 'everyMinute',
		'everyFiveMinutes' => 'everyFiveMinutes',
		'everyTenMinutes' => 'everyTenMinutes',
		'everyFifteenMinutes' => 'everyFifteenMinutes',
		'everyThirtyMinutes' => 'everyThirtyMinutes',
		'hourly' => 'hourly',
		'hourlyAt' => 'hourlyAt',
		'daily' => 'daily',
		'dailyAt' => 'dailyAt',
		'twiceDaily' => 'twiceDaily',
		'weekly' => 'weekly',
		'weeklyOn' => 'weeklyOn',
		'monthly' => 'monthly',
		'monthlyOn' => 'monthlyOn',
		'quarterly' => 'quarterly',
		'yearly' => 'yearly',
		'timezone' => 'timezone',
	],
];