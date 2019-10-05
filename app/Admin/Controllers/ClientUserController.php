<?php

namespace App\Admin\Controllers;



use App\Admin\Extensions\Tools\ClientsUpload;
use App\Models\AdminUser;
use App\Models\ClientUser;
use App\Models\Rule;
use App\Models\RulesDetail;
use App\Models\User;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Client;
use function foo\func;
use Illuminate\Http\Request;

class ClientUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '客户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        Admin::disablePjax();
        Admin::js('/js/mychange.js');

        Permission::check('clients');
        $admin = Admin::user();

        //超级管理员可以看到所有信息，销售只能看到自己的
        $grid = new Grid(new ClientUser());


        $grid->model()->setPerPage(60);
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');

        $grid->model()->orderBy('id', 'desc');
        $grid->client()->user_name('客户');
        $grid->user()->name('销售');

        $grid->column('id','ID')->sortable();

        $grid->column('status','销售状态')->display(function ($status){
            return ClientUser::$status[$status];
        });

        $grid->column('created_at', '创建时间');
        $grid->column('accepted_at', '接受');
        $grid->filter(function($filter){
            $filter->disableIdFilter();
        });

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });


        $grid->tools(function ($tools)  {
            $tools->append(new ClientsUpload());

        });
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

        $show = new Show(ClientUser::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('status', '状态');
        $show->field('remark', '备注');
        return $show;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id)
    {

        $form = new Form(new ClientUser());
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });

        $admin = Admin::user();
        $isAdmin = $admin->isRole('administrator');
        $isPutong = $admin->isRole('putong');
        $form->hidden('id');

        if($isAdmin or $isPutong){

            $form->display('remark', '销售备注');
            $form->textarea('complain_remark', '申诉备注')->disable();
            $form->select('complain_status', '申诉状态')->options(ClientUser::$complain_status)->required();
            $form->html(function ($form){
                return '<a href="'.$form->model()->complain_file.'">'.$form->model()->complain_file.'</a>';
            }, '申诉文件');

            $form->select('status', '销售状态')->options(ClientUser::$status)->disable();
            $form->textarea('complain_reply', '申诉回复');

        }


        $form->saving(function ($form) {


        });




        return $form;
    }
}
