<?php

namespace App\Admin\Extensions\Tools;

use App\Models\Client;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class AdminRemark extends AbstractTool
{
    protected function script()
    {

        return <<<EOT

$('.admin_remark_submit').on('click', function() {
    
    ids = $.admin.grid.selected();
    console.log(ids);
    if(ids.length==0){
        alert('请选择客户');
        return false;
    }

    $.ajax({
        method: 'post',
        url: 'clients/admin-remark',
        data: {
            _token:LA.token,
            admin_remark:$('.admin_remark').val(),
            ids: $.admin.grid.selected(),
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

$('.admin_status_submit').on('click', function() {
    
    ids = $.admin.grid.selected();
    console.log(ids);
    if(ids.length==0){
        alert('请选择客户');
        return false;
    }

    $.ajax({
        method: 'post',
        url: 'clients/admin-status',
        data: {
            _token:LA.token,
            admin_status:$('#admin_status').val(),
            ids: $.admin.grid.selected(),
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});


EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        //状态选择
        $statuses = Client::$status;

        return view('admin.tools.admin-remark',[
            'statuses'=>$statuses
        ]);
    }
}
