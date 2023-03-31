<?php
namespace Encore\Admin\TaskScheduling\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{

    protected $fillable = [
        'description',
        'command',
        'enabled',
    ]; 

	/**
     * @return string
     */
    public function getTable(): string
    {
        return Str::contains(parent::getTable(), config('task-scheduling.table_prefix')) ? parent::getTable() : config('task-scheduling.table_prefix') . parent::getTable();
    }

    public function frequencies()
    {
        return $this->hasMany(TaskFrequency::class);
    }

    public function commandLogs()
    {
        return $this->hasMany(CommandLog::class); 
    }

    public function templates()
    {
        return $this->hasMany(TaskTemplate::class); 
    }
}