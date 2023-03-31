<?php
namespace Encore\Admin\TaskScheduling\Http\Controllers;

use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\TaskScheduling\Http\Models\Task;
use Encore\Admin\Controllers\HasResourceActions;

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
        $grid->column('description', '描述')->sortable();
        $grid->column('command', '命令');
        $grid->column('template', '模板');
        $states = [
            'on' => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];

        $grid->column('enabled', '开关')->switch($states);

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

        $form->text('description', '描述');
        $form->text('command', '命令');

        $states = [
            'on' => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];

        $form->hasMany('frequencies', function (Form\NestedForm $form) {
            $form->text('function');
            $form->text('parameters');
        });

        $form->hasMany('templates', function (Form\NestedForm $form) {
            $form->textarea('content');
        });

        $form->switch('enabled', '开关')->states($states)->default(1);

        return $form;
    }
}