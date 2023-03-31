<?php

namespace Encore\Admin\TaskScheduling\Actions\Tasks;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\TaskScheduling\Services\TaskService;

class ExecuteManually extends RowAction
{
    public $name = 'execute';

    public function handle(Model $model)
    {
        $service = new TaskService(); 
        $service->execute($model);
         
        return $this->response()->success('Success message.');
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($target)
    {
        return '手动执行';
    }

    public function dialog()
    {
        $this->confirm('确认执行吗');
    }

}