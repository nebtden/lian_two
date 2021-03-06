<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;

class UsersUpload extends AbstractTool
{
    protected function script()
    {

        return <<<EOT

        $(function(){
           var url = "/admin/users-import/index";
           $('.upload').attr('href',url);
        });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        return view('admin.tools.upload');
    }
}
