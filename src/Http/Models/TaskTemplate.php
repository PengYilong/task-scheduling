<?php
namespace Encore\Admin\TaskScheduling\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TaskTemplate extends Model
{

    protected $fillable = [
        'task_id',
		'content',
    ]; 

	/**
     * @return string
     */
    public function getTable(): string
    {
        return Str::contains(parent::getTable(), config('task-scheduling.table_prefix')) ? parent::getTable() : config('task-scheduling.table_prefix') . parent::getTable();
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}