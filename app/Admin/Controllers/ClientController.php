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
        $isXiaoshou = Admin::user()->isRole('xiaoshou');
        if($isXiaoshou){
            $grid->disableRowSelector();
            $id = Admin::user()->id;
            $grid->model()->where('admin_user_id', '=', $id);
            $grid->model()->where('status', '!=', 2);
        }

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id','ID')->sortable();
        $grid->column('user_name','姓名');
        $grid->column('phone','手机号码');

        if($isAdmin or $isPutong){
            $grid->column('my_user_name','成交渠道商')->display(function (){
                if($this->user_id){
                    $user = User::find($this->user_id);
                    if($user){
                        $return = "<a href='/admin/users/$this->user_id'>".$user->name."</a>";
                        $user_phone = $this->user->phone;
                        $parent_client = Client::where(['phone'=>$user_phone])->first();
                        if($parent_client && $parent_client->admin_user_id){

                            $admin = AdminUser::find($parent_client->admin_user_id);
                            if ($admin){
                                $return = $return.'(老销售顾问'.$admin->name.")";
                            }else{
                                $return = $return."(老销售顾问已不在系统）";
                            }
                        }
                    }else{
                        $return = '';
                    }

                }else{
                    $return = '';
                }
                return $return;
            });

            $grid->admin()->name('分配的销售顾问');
            $grid->upload()->name('数据提交');
            
        }
		$grid->column('status','订单状态')->display(function ($status){
                return Client::$status[$status];
        });
        $grid->user()->type('成交渠道商类型')->display(function ($value){
            if($value){
                return User::$type[$value];
            }else{
                return '渠道商没注册';
            }
        });


        $grid->column('sales_status','销售反馈')->display(function ($status){
            return Client::$sales_status[$status];
        });
        $grid->column('admin_remark','管理员备注');
        $grid->column('remark','客户备注');
        $grid->column('sales_remark','销售备注');
        $grid->column('transfer_remark','客户交费进度');
        $grid->column('created_at', '创建时间');
        $grid->filter(function($filter){

            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user_name', '客户名');
            $filter->equal('phone', '手机号');
            $filter->equal('status', '订单状态')->select(Client::$status);
            $filter->like('admin_remark', '管理员备注');
            $filter->like('sales_remark', '销售备注');
            $filter->like('transfer_remark', '客户交费进度');
            $filter->equal('sales_status', '销售状态')->select(Client::$sales_status);

            $isXiaoshou = Admin::user()->isRole('xiaoshou');
            if(!$isXiaoshou){
                $admins = AdminUser::all()->pluck('name','id')->toArray();
                $admins[0]='无';
                $filter->equal('admin_user_id', '销售顾问')->select($admins);
                $filter->equal('user_id', '渠道商或外销经理')->select(User::all()->pluck('name','id'));
                $filter->equal('user.parent_id', '直属外拓经理')->select(User::where(['status'=>1,'type'=>4])->get()->pluck('name','id'));
                $filter->equal('top_parent_id', '外拓经理')->select(User::where(['type'=>4])->get()->pluck('name','id'));
                $filter->equal('upload_admin_id', '上传者')->select(User::all()->pluck('name','id'));

            }
            $filter->between('created_at', '创建时间')->datetime();

        });

        if($isAdmin or $isPutong){
            $grid->top()->name('外拓经理');
            $grid->actions(function ($actions) {
                $actions->disableView();
            });

            $grid->column('change', '转换为老客户')->display(function (){
                //检查是否转换过
                $user =    User::where(['phone'=>$this->phone])->first();
                if(!$user){
                    return  "<a href='javascript:void(0)' class='client_change_to_user' data-id='".$this->id."'>一键转换</a>";
                }
            });
            $grid->column('transfer', '佣金记录')->display(function (){
               return  "<a target='_blank' href='/admin/transfer?client_id=$this->id'>查看</a>";
            });
        }

        if(!$isAdmin){
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
            });
        }
        if($isXiaoshou){
            $grid->exporter(new SalesClientsExport());
        }else{
            $grid->exporter(new ClientsExport());
        }

        $grid->tools(function ($tools)  {
            $tools->append(new ClientsUpload());
            $tools->append(new AdminRemark());
//            $tools->append(new Change());
            $tools->batch(function ($batch) {
                $isAdmin = Admin::user()->isRole('administrator');
                if(!$isAdmin){
                    $batch->disableDelete();
                }

                $admins = AdminUser::all();
                foreach ($admins as $key=>$admin){
                    if($key==0){
                        $batch->add('批量指定到'.$admin->username,new BatchToAdmin($admin->id));
                    }else{
                        $batch->add($admin->username,new BatchToAdmin($admin->id));
                    }
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
