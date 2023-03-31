<?php
namespace Encore\Admin\TaskScheduling\Http\Controllers;

use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\TaskScheduling\Http\Models\Task;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\TaskScheduling\Actions\Tasks\ExecuteManually;
Use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Artisan;

class TaskSchedulingController
{

    use HasResourceActions;

	/**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '计划任务';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }


    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return $this->title;
    }

	public function grid()
	{ 
		$grid = new Grid(new Task);
        $grid->id('Id')->sortable();
        $grid->column('description', '描述')->sortable()->modal('执行日志', function ($model) {

            $logs = $model->commandLogs()->take(10)->orderBy('created_at', 'desc')->get()->map(function ($log) {
                return $log->only(['id', 'duration', 'created_at']);
            });
        
            return new Table(['ID', '花费时间', '执行时间'], $logs->toArray());
        });
        $grid->column('command', '命令');
        $states = [
            'on' => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];

        $grid->column('enabled', '开关')->switch($states);

        $grid->column('execute', '执行')->action(ExecuteManually::class);

		return $grid;
	}

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Task());

        $form->text('description', '描述')->required();

        $commands = Artisan::all();
        foreach($commands as $key => $command) {
            $options[$key] = $key;
        }
 
        $form->select('command', '命令')->options($options)->required();

        $states = [
            'on' => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];

        $form->hasMany('frequencies', function (Form\NestedForm $form) {
            $form->select('function')->options(config('task-scheduling.frequencies'));
            $form->text('parameters');
        })->required();

        $form->hasMany('templates', function (Form\NestedForm $form) {
            $form->textarea('content');
        });

        $form->switch('enabled', '开关')->states($states)->default(1);

        return $form;
    }
}