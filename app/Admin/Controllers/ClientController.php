<?php

namespace App\Admin\Controllers;



use App\Admin\Extensions\Tools\ClientsUpload;
use App\Models\AdminUser;
use App\Models\ClientUser;
use App\Models\User;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends AdminController
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
        $grid = new Grid(new Client());


        $grid->model()->setPerPage(60);
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');
        if($isAdmin){
            $id = Request()->get('admin_user_id');
            $grid->model()->where('admin_user_id',$id);
        }elseif ($isPutong){
            $grid->model()->where('admin_user_id',$admin->id);
        }

        $grid->model()->orderBy('id', 'desc');


        $grid->column('id','ID')->sortable();
        $grid->column('user_name','姓名');
        $grid->column('phone','手机号码');
        $grid->column('sales','销售列表')->display(function (){
            $id = $this->id;
            $client_users = ClientUser::where([
                ['client_id','=',$id],
                ['status','>',0]
            ])->with('user')->get();
            $html  = ' ';
            foreach($client_users as $value){
                $html = $html . $value->user->name;
                $html = $html . ' :';
                $html = $html . $value->remark;
                $html = $html . '<br>';
            }
            return $html;
        });

        $grid->rule()->name('分配策略');
        $grid->column('is_rule_stopped','策略是否停止')->select(Client::$is_rule_stopped);


        $grid->column('status','最终订单状态')->display(function ($status){
            return Client::$status[$status];
        });
        $grid->user()->name('最终成交销售');

        $grid->column('created_at', '创建时间');
        $grid->filter(function($filter){

            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user_name', '客户名');
            $filter->equal('phone', '手机号');
            $filter->equal('status', '订单状态')->select(Client::$status);


            $filter->between('created_at', '创建时间')->datetime();

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
//            $form->select('admin_user_id', '指派所属销售去管理')->rules('required')->options(AdminUser::all()->pluck('name', 'id'));
//            $form->textarea('remark', '客户备注');
            $form->textarea('sales_remark', '销售备注');
            $form->textarea('transfer_remark', '客户交费进度');
            $form->select('status', '订单状态')->options(Client::$status)->required();
            $form->select('user_id', '最终成交公司')->options(User::all()->pluck('name','id'));
//            $form->select('sales_status','销售反馈')->options(Client::$sales_status);

        }


        $form->saving(function ($form) {
            if(isset($form->phone)){
                $form->phone = trim($form->phone);
            }

            $form->user_id= $form->user_id??0;
            if($form->status == 4){


            }
        });



        return $form;
    }
}
