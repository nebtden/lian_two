<?php

namespace App\Admin\Controllers;


use App\Admin\Extensions\Tools\UsersUpload;
use App\Admin\Extensions\UsersExport;
use App\Models\AdminUser;
use App\Models\User;
use Encore\Admin\Auth\Permission;
//use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Client;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '销售登录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    public function tree(){
        Admin::js('/js/bootstrap-treeview.js');
        Admin::js('/js/mytree.js');
        $content = new Content();
        return $content
            ->title('渠道商列表')
            ->description('可以搜索、可以展示...')
            ->body(' 
 <div class="form-group row">
        <div class="col-md-3"> 
            <label for="input-select-node" class="sr-only">Search Tree:</label>
            <input type="input" class="form-control" id="input-select-node" placeholder="输入渠道商姓名进行搜索"  > 
            
          </div>
          <div class="col-md-3">
              <button type="button" class="btn btn-success select-node" id="btn-select-node">搜索</button>
          </div>
          </div>
           
      <div id="tree"></div>');
    }

    protected function grid()
    {
        Admin::disablePjax();
//        Permission::check('users');
        $isXiaoshou = Admin::user()->isRole('xiaoshou');
        $isAdmin = Admin::user()->isRole('administrator');
        $isCaiwu = Admin::user()->isRole('caiwu');
        $isPutong = Admin::user()->isRole('putong');
        if($isXiaoshou){
            Permission::error();
        }
        $grid = new Grid(new User());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id','ID')->sortable();
        $grid->column('name','用户名');
        if($isAdmin){
            $grid->column('phone','手机号码');
        }else{
            $grid->column('phone','手机号码')->display(function ($value){
                return substr($value,0,9).'**';
            });
        }

//        $grid->column('status','状态');
        $grid->column('bank_name','银行');
        $grid->column('card_number','卡号');
        $grid->column('remark','备注');
//        $grid->image('remark','备注');

        if($isPutong or $isAdmin){
            $grid->invitaion_register_image('邀请下级注册链接')->display(function ($value){
                if($this->type==1 or $this->type==2){
                    return '';
                }
                return  '<img style="max-width:200px;max-height:200px" class="img img-thumbnail" src="'.$this->invitaion_register_image.'" >';
            });
            $grid->invitaion_client_image('邀请用户注册链接')->display(function ($value){

                return  '<img style="max-width:200px;max-height:200px" class="img img-thumbnail" src="'.$this->invitaion_client_image.'" >';
            });
        }



        $grid->column('status','状态')->display(function ($status){
            return User::$status[$status];
        });
        $grid->parent()->name('上级渠道商')->display(function ($value){
            return "<a href='/admin/users?parent_id=$this->parent_id'>".$value."</a>";
        });
        $grid->top()->name('所属外拓经理')->display(function ($value){
            return "<a href='/admin/users?top_parent_id=$this->top_parent_id'>".$value."</a>";
        });
        $grid->column('type','类型')->display(function ($type){
            return User::$type[$type];
        });


        $grid->column('created_at', '创建时间');
//        $grid->column('updated_at', '更新时间');
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
//            $filter->expand();


            // 在这里添加字段过滤器
            $filter->like('name', '客户名');
            $filter->equal('phone', '手机号');
            $filter->equal('status', '状态')->select(User::$status);
            $filter->equal('type', '类型')->select(User::$type);
            $filter->equal('parent_id', '直属外拓经理')->select(User::where(['status'=>1,'type'=>4])->get()->pluck('name','id'));
            $filter->equal('top_parent_id', '源头外拓经理')->select(User::where(['status'=>1,'type'=>4])->get()->pluck('name','id'));
            $filter->between('created_at', '创建时间')->datetime();
//            $filter->in('user_id', '经销商')->ajax('/admin/api/users');;
        });
        $grid->disableRowSelector();
        $grid->exporter(new UsersExport());
        $grid->tools(function ($tools) {
            $tools->append(new UsersUpload());
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
//            $actions->disableView();
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
        $form = new Form(new User);
        $user = User::find($id);

        $form->display('name','真实姓名')->value($user->name);
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');
        if($isAdmin){
            $form->display('phone','电话号码')->value($user->phone);
        }else if($isPutong){
            $form->display('phone','电话号码')->value(substr($user->phone,0,9).'**');
        }


        $form->text('bank_name','银行名')->value($user->bank_name);
        $form->display('card_number','银行卡号')->value($user->card_number);

        $user_model = new User();
        $user_model->get_parent($user);
        $html = $user_model->get_parent_html();

        $form->html("上级渠道链条:<br>".$html);
        return $form;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id)
    {
//        Admin::js('/js/myform.js');
        $form = new Form(new User);

        $admin = Admin::user();
        $isAdmin = $admin->isRole('administrator');
        $isPutong = $admin->isRole('putong');
        $isXiaoshou = $admin->isRole('xiaoshou');

        $form->hidden('id', __('ID'));

        if( $isAdmin){
            $form->text('name','真实姓名')->required();
            $form->text('phone','手机号')->required()->rules('unique:users,phone,'.$id);
            $form->text('bank_name','银行名');
            $form->text('card_number','银行卡号');
        }else{
            if($id){
                $form->text('name','真实姓名')->required()->readOnly(boolval($id));;
//                $form->text('phone','手机号')->required()->readOnly(boolval($id));
                $form->text('bank_name','银行名')->readOnly(boolval($id));;
                $form->text('card_number','银行卡号')->readOnly(boolval($id));;
            }else{
                $form->text('name','真实姓名')->required();
                $form->text('phone','手机号')->required()->rules('unique:users');
                $form->text('bank_name','银行名');
                $form->text('card_number','银行卡号');
            }
        }
        $form->select('type', '类型')->options(User::$type)->addElementClass('type');


        if($isAdmin){

            $parents = User::where(['status'=>1])->whereIn('type', [3,4])->get()->pluck('name','id');
            $form->select('parent_id', '上级渠道商')->options($parents);
            $form->select('top_parent_id', '外拓经理')->options(User::where(['status'=>1,'type'=>4])->get()->pluck('name','id'));

        }else{
            $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
                $tools->disableList();
            });
        }

        $form->select('status', '状态')->options(User::$status)->default(1);

        $form->textarea('remark', '备注');


        $form->password('password', '密码');
        $form->hidden('ip');



        $form->saving(function (Form $form) {
            //检查是否重复
			$form->phone = trim($form->phone );

            if($form->id){
                $user = User::find($form->id);
                if($form->password!=$user->password){
                    $form->password =  Hash::make($form->password);
                }
                $form->ip =  '0.0.0.0';
            }else{
                $form->password =  Hash::make($form->password);

            }
            $form->phone =  Request()->get('phone');
            $form->parent_id =  $form->parent_id??0;
            $form->top_parent_id =  $form->top_parent_id??0;
            $form->bank_name = $form->bank_name??'';
            $form->card_number = $form->card_number??'';
            $form->remark = $form->remark??'';

            if($form->type==2){
                $form->parent_id = 0;
                $form->top_parent_id = 0;
            }elseif ($form->type==4){
                $form->parent_id = 0;
                $form->top_parent_id = $form->id??0;
            }else{
                if($form->type==1){
                    if($form->parent_id>0){
                        //根据这个结果，计算外拓经理
                        $parent = User::find($form->parent_id);
                        $form->top_parent_id =    $parent->top_parent_id??$parent->id;
                        // throw new \Exception('普通渠道商必须选择外拓经理');
                    }
                    //处理
                }

            }
        });

        //如果没有id，则更新图片
        $form->saved(function (Form $form){
                User::generateImage($form->model()->id);
                if($form->model()->type==4){
                    $form->model()->top_parent_id = $form->model()->id;
                    $form->model()->save();
                }
        });

        return $form;
    }

}
