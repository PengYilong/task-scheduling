<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('task-scheduling.table_prefix').'command_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->string('duration');
            $table->longText('result');
            $table->timestamps();
            $table->foreign('task_id', 'command_logs_task_id_fk')
            ->references('id')->on(config('task-scheduling.table_prefix').'tasks')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('task-scheduling.table_prefix').'command_logs');
    }
}
