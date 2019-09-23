<?php

namespace App\Admin\Controllers;


use App\Models\AdminUser;
use App\Models\Rule;
use App\Models\User;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;

class RuleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '设置';



    protected function grid()
    {
        //超级管理员可以看到所有信息，销售只能看到自己的
        $grid = new Grid(new Rule());
        $isAdmin = Admin::user()->isRole('administrator');
        if(!$isAdmin){
            Permission::error();
        }
        $grid->name('规则名');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Rule::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Rule());

        $form->text('name','配置值');

        $form->hasMany('detail','规则', function (Form\NestedForm $form) {
//            $form->text('title');
            $admin = Admin::user();

            $form->text('time_last');
            $form->text('index');
            $form->select('user_id', '销售')->rules('required')->options(User::all()->pluck('name', 'id'));
//            $form->hidden('user_id')->value($admin->id);
        });

        return $form;
    }
}
