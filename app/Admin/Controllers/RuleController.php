<?php

namespace App\Admin\Controllers;


use App\Models\Setting;
use App\Models\User;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

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
        $grid = new Grid(new Setting());
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
        $show = new Show(Setting::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Setting());

//        $form->display('id', __('ID'));
//        $form->display('key','字段名(无法修改)');
        $form->display('remark', '备注');
        $form->textarea('value','配置值');


        return $form;
    }
}
