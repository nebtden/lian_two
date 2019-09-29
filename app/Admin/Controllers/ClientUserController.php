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

        $grid->column('status','最终订单状态')->display(function ($status){
            return Client::$status[$status];
        });

        $grid->column('created_at', '创建时间');
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

        $show = new Show(Client::findOrFail($id));
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

        $form = new Form(new Client);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });

        $admin = Admin::user();
        $isAdmin = $admin->isRole('administrator');
        $isPutong = $admin->isRole('putong');

        $form->hidden('upload_admin_id')->value($admin->id);
//        $form->hidden('user_id')->default(0);
        $form->hidden('id');


        if($isAdmin or $isPutong){
            $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id);
            $form->text('user_name', '姓名');
            $form->textarea('admin_remark', '管理员备注');
            $form->textarea('sales_remark', '销售备注');
            $form->textarea('transfer_remark', '客户交费进度');
            $form->select('status', '订单状态')->options(Client::$status)->required();
            $form->select('rule_id', '策略选择')->options(Rule::all()->pluck('name','id'))->required();
            $form->select('user_id', '最终成交公司')->options(User::all()->pluck('name','id'))->required();

        }


        $form->saving(function ($form) {
            if(isset($form->phone)){
                $form->phone = trim($form->phone);
            }

            //规则分配
            $rule_id = $form->rule_id;
            $details = RulesDetail::where([
                'rule_id'=>$rule_id
            ])->all();

            //根据规则，增加，添加到系统里面
            foreach ($details as $detail){
                $user_id = $detail->user_id;
                $client_id = $form->id;

                $client_user = new ClientUser();
                $client_user->client_id = $client_id;
                $client_user->user_id = $user_id;
                $client_user->status = -1;
                $client_user->effect_at = date('Y-m-d H:i:s',time()+$detail->time_last*3600);
                $client_user->save();

            }

            //当有数据成交时，根据


        });




        return $form;
    }
}
