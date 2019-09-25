<?php

namespace App\Admin\Controllers;

use App\Imports\ClientsImport;
use App\Models\Client;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Exception;
use Encore\Admin\Layout\Content;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Facades\Excel;

class ClientsImportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '导入客户信息';

    public function index(Content $content)
    {
        session(['client_phone' => []]);
//        Session::save();
        return $content
            ->title($this->title())
            ->description('')
            ->body($this->form());
    }



    protected function form()
    {

        $form = new Form(new Client);

        $form->html(' 
                     请按要求导入数据，模板参考如下。。
                      <div class="links">
    <a href="/excel/clients.xlsx" target="_blank">模板下载</a>
       </div>');
//        $form->setAction('/admin/upload/store');
        $form->file('file','请选择excel');
        $form->saving(function ($form) {

            try{
                Excel::import(new ClientsImport, $form->file);
                $message = '客户全部导入成功！';
                $phones = session()->get('client_phone');
                if($phones){
                    $phones = implode(',',$phones);
                    $message = $message.'重复电话号码有：'.$phones;
                }
                $success = new MessageBag([
                    'title'   => '恭喜！',
                    'message' =>$message
                ]);

                return back()->with(compact('success'));
            }catch ( \Exception $exception){


                $error = new MessageBag([
                    'title'   => '错误，请检查！',
                    'message' => $exception->getMessage(),
                ]);

                return back()->with(compact('error'));
            }

        });
        return $form;
    }




}
