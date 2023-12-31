<?php

namespace Encore\Admin\TaskScheduling\Services;

use Encore\Admin\TaskScheduling\Http\Models\Task;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\ManagesFrequencies;
use Closure;

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
            if( 'cron' != $frequency->function ) {
                $parameters = !empty($frequency->parameters) ? explode(',', $frequency->parameters) : []; 
                call_user_func_array([$this, $frequency->function], explode(',', $frequency->parameters));
            } else {
                call_user_func_array([$this, $frequency->function], [$frequency->parameters]); 
            }
			
		}

		$expression = $this->expression;

		$this->expression = null;

		return $expression;
	}

    /**
     * Register a callback to further filter the schedule.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function when(Closure $callback)
    {
        $this->filters[] = $callback;

        return $this;
    }

	public function execute($task)
	{
        $start = microtime(true);
        try {
            Artisan::call($task->command);
            $output = Artisan::output();
			$task->commandLogs()->create([
				'duration' => microtime(true)-$start,
				'result' => $output,
			]);
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }

        return $task;
	}
}