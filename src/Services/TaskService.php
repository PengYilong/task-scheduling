<?php

namespace Encore\Admin\TaskScheduling\Services;

use Encore\Admin\TaskScheduling\Http\Models\Task;

use Illuminate\Console\Scheduling\ManagesFrequencies;

class TaskService
{

	use ManagesFrequencies; 

	/**
     * Generate a cron expression from frequencies.
     *
     * @return string
     */
    public function getCronExpression(Task $task): string
    {
		$this->expression = '* * * * *';

		foreach($task->frequencies as $frequency) {
			$parameters = !empty($frequency->parameters) ? explode(',', $frequency->parameters) : []; 
			call_user_func_array([$this, $frequency->function], explode(',', $frequency->parameters));
		}

		$expression = $this->expression;

		$this->expression = null;

		return $expression;
	}
}