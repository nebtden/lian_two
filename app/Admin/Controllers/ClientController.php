<?php

namespace App\Admin\Controllers;


use App\Admin\Extensions\ClientsExport;
use App\Admin\Extensions\SalesClientsExport;
use App\Admin\Extensions\Tools\AdminRemark;
use App\Admin\Extensions\Tools\BatchToAdmin;
use App\Admin\Extensions\Tools\ClientsUpload;
use App\Models\AdminUser;
use App\Models\User;
use Encore\Admin\Auth\Permission;
//use Encore\Admin\Controllers\AdminController;
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

        //超级管理员可以看到所有信息，销售只能看到自己的
        $grid = new Grid(new Client());
        $grid->model()->setPerPage(60);
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');


        $grid->model()->orderBy('id', 'desc');

        $grid->column('id','ID')->sortable();
        $grid->column('user_name','姓名');
        $grid->column('phone','手机号码');

        if($isAdmin or $isPutong){

//            $grid->admin()->name('分配的销售顾问');
//            $grid->upload()->name('数据上传者');
            
        }
		$grid->column('status','订单状态')->display(function ($status){
                return Client::$status[$status];
        });

//        $grid->column('admin_remark','管理员备注');
//        $grid->column('remark','客户备注');
//        $grid->column('sales_remark','销售备注');
        $grid->column('created_at', '创建时间');
        $grid->filter(function($filter){

            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user_name', '客户名');
            $filter->equal('phone', '手机号');
            $filter->equal('status', '订单状态')->select(Client::$status);
//            $filter->like('sales_remark', '销售备注');
//            $filter->equal('sales_status', '销售状态')->select(Client::$sales_status);


//                $admins = AdminUser::all()->pluck('name','id')->toArray();
//                $admins[0]='无';
//                $filter->equal('admin_user_id', '销售顾问')->select($admins);
//                $filter->equal('user_id', '渠道商或外销经理')->select(User::all()->pluck('name','id'));
//                $filter->equal('upload_admin_id', '上传者')->select(User::all()->pluck('name','id'));


            $filter->between('created_at', '创建时间')->datetime();

        });

        if($isAdmin or $isPutong){
//            $grid->top()->name('外拓经理');
            $grid->actions(function ($actions) {
                $actions->disableView();
            });


        }

        if(!$isAdmin){
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
            });
        }


        $grid->tools(function ($tools)  {
            $tools->batch(function ($batch) {
                $isAdmin = Admin::user()->isRole('administrator');
                if(!$isAdmin){
                    $batch->disableDelete();
                }

            });
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

    public  function toAdmin(Request $request)
    {
        foreach (Client::find($request->get('ids')) as $client) {
            $client->admin_user_id = $request->get('admin_user_id');
            $client->save();
        }
    }


    public  function adminRemark(Request $request)
    {
        foreach (Client::find($request->get('ids')) as $client) {
            $client->admin_remark = $request->get('admin_remark');
            $client->save();
        }
    }

    public  function adminStatus(Request $request)
    {
        foreach (Client::find($request->get('ids')) as $client) {
            $client->status = $request->get('admin_status');
            $client->save();
        }
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
        $isXiaoshou = $admin->isRole('xiaoshou');
        $form->hidden('upload_admin_id')->value($admin->id);
        $form->hidden('user_id')->default(0);
        $form->hidden('id');
        $form->hidden('transfer_remark');


        if($isAdmin){
            $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id);

            $form->text('user_name', '姓名');
            $form->textarea('admin_remark', '管理员备注');
            $form->select('admin_user_id', '指派所属销售去管理')->rules('required')->options(AdminUser::all()->pluck('name', 'id'));
            $form->textarea('remark', '客户备注');
            $form->textarea('sales_remark', '销售备注');
            $form->textarea('transfer_remark', '客户交费进度');
            $form->select('status', '订单状态')->options(Client::$status)->required();
            $form->select('sales_status','销售反馈')->options(Client::$sales_status);
            $form->datetime('created_at','创建时间');
        }

        if($isPutong){
            if($id){
                $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id)->disable();
            }else{
                $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id);
            }
            $form->text('user_name', '姓名');
            $form->textarea('admin_remark', '管理员备注');
            $form->select('admin_user_id', '指派所属销售去管理')->rules('required')->options(AdminUser::all()->pluck('name', 'id'));
            $form->textarea('remark', '客户备注');
            $form->textarea('sales_remark', '销售备注');
            $form->textarea('transfer_remark', '客户交费进度');
            $form->select('status', '订单状态')->options(Client::$status)->required();
            $form->select('sales_status','销售反馈')->options(Client::$sales_status);
        }

        if($isXiaoshou){
            if($id){
                $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id)->disable();
            }else{
                $form->text('phone', '电话号码')->required()->rules('unique:clients,phone,'.$id);
            }
            $form->text('user_name', '姓名');
            $form->select('sales_status','销售反馈')->options(Client::$sales_status);
            $form->textarea('sales_remark', '销售备注');

                $form->hidden('admin_user_id', '指派所属销售去管理')
                    ->rules('required')
                    ->value($admin->id);

        }

        $form->saving(function ($form) {
            if(isset($form->phone)){
                $form->phone = trim($form->phone);
            }
            if(isset($form->status) && $form->status==3){
                $form->sales_status= 2;
            }
            $form->user_id= $form->user_id??0;
            if($form->status == 4){
                //处理交易记录，检查记录是否添加
                $transfer = Transfer::where([
                    'client_id'=>$form->id
                ])->first();
                if($transfer){
//
                }else{
                    if($form->user_id){
                        $user = User::find($form->user_id);
                        if($user->type!=4){
                            $transfer = new Transfer();
                            $transfer->client_id = $form->id;
                            $transfer->user_id = $form->user_id;
                            $transfer->status = 0;
                            $transfer->user_type = 1;
                            $transfer->remark = $form->transfer_remark;
                            $transfer->save();

                            if($user->parent_id){
                                $parent = User::find($user->parent_id);
                                if($parent->type==3){
                                    $transfer = new Transfer();
                                    $transfer->client_id = $form->id;
                                    $transfer->user_id = $user->parent_id;
                                    $transfer->status = 0;
                                    $transfer->user_type = 2;
                                    $transfer->remark =  $form->transfer_remark;
                                    $transfer->save();
                                }
                            }
                        }

                    }
                }



            }

        });



        return $form;
    }
}
