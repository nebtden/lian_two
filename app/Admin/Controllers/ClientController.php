<?php

namespace App\Admin\Controllers;



use App\Admin\Extensions\Tools\ClientsUpload;
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

        Permission::check('clients');
        $admin = Admin::user();

        //超级管理员可以看到所有信息，销售只能看到自己的
        $grid = new Grid(new Client());


        $grid->model()->setPerPage(60);
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');
        if($isAdmin){
            $id = Request()->get('admin_user_id');
            if($id){
                $grid->model()->where('admin_user_id',$id);
            }
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
                $user_id = $value->id;
                $html = $html ."<a href='/admin/clients-users/$user_id/edit'>".$value->user->name."</a>";
                $html = $html . ' :';
                $html = $html .ClientUser::$status[$value->status];
                $html = $html . ' :';
                $html = $html . $value->remark;
                $html = $html . '<br>';
            }
            return $html;
        });

        $grid->rule()->name('分配策略');
        $grid->column('rule_id','分配策略')->select(Rule::all()->pluck('name','id'));

        $grid->column('is_rule_stopped','策略是否停止')->select(Client::$is_rule_stopped);

//        $grid->column('is_rule_stopped','策略是否停止')->display(function ($status){
//            return Client::$is_rule_stopped[$status];
//        });

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
//            $form->textarea('sales_remark', '销售备注');
//            $form->textarea('transfer_remark', '客户交费进度');
            $form->select('status', '订单状态')->options(Client::$status)->required();
            $form->select('user_id', '最终成交销售')->options(User::all()->pluck('name','id'))->required();
            $form->select('rule_id', '策略选择')->options(Rule::all()->pluck('name','id'))->required();
            $form->select('is_rule_stopped', '策略是否停止')->options(Client::$is_rule_stopped)->required();


        }


        $form->saving(function ($form) {
            if(isset($form->phone)){
                $form->phone = trim($form->phone);
            }
            $old_rule_id = $form->model()->rule_id;

            //检测规则是否一样
            $new_rule_id = $form->rule_id;
            if($new_rule_id && $new_rule_id!=$old_rule_id){
                //停止之前的规则 @todo

                ClientUser::where([
                    'rules_id'=>$old_rule_id,
                    'client_id'=>$form->model()->id,
                ])->update([
                    'status'=>-2
                ]);

                //根据规则，增加，添加到系统里面
                $details = RulesDetail::where([
                    'rule_id'=>$new_rule_id
                ])->get();

                foreach ($details as $detail){
                    $user_id = $detail->user_id;
                    $client_id = $form->model()->id;

                    $client_user = new ClientUser();
                    $client_user->client_id = $client_id;
                    $client_user->user_id = $user_id;
                    $client_user->status = -1;
                    $client_user->effect_at = date('Y-m-d H:i:s',time()+$detail->time_last*3600);
                    $client_user->save();

                }
            }

            //策略是否停止



            //当有数据成交时，根据


        });




        return $form;
    }
}
