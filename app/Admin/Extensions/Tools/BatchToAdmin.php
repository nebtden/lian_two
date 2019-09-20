<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class BatchToAdmin extends BatchAction
{
    protected $admin_user_id;

    public function __construct($admin_user_id = 1)
    {
        $this->admin_user_id = $admin_user_id;
    }

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '{$this->resource}/to-admin',
        data: {
            _token:LA.token,
            ids: $.admin.grid.selected(),
            admin_user_id: {$this->admin_user_id}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
