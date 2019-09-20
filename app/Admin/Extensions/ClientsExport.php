<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/5/29
 * Time: 14:57
 */

namespace App\Admin\Extensions;

use App\Models\Client;
use App\Models\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Facades\Excel;

class ClientsExport extends ExcelExporter
{
    protected $fileName = '客户导出.xlsx';

    protected $headings = ['ID','姓名','电话','渠道商','渠道商类型'
        ,'外拓经理','状态','销售顾问',
        '客户备注','管理员备注','销售备注','销售反馈','客户交费进度','创建时间'];

    public function export()
    {
//        parent::export(); // TODO: Change the autogenerated stub
        $isAdmin = Admin::user()->isRole('administrator');
        $isPutong = Admin::user()->isRole('putong');
        $isXiaoshou = Admin::user()->isRole('xiaoshou');
        $isCaiwu = Admin::user()->isRole('caiwu');


        $rows = [];
        $rows[] = $this->headings;

        $data = $this->getData();

        if(count($data))
        {
            foreach ($data as $v)
            {
                $row = [];
                $row[] = $v['id'];
                $row[] = $v['user_name'];
                $row[] = $v['phone'];
                $row[] = $v['user']['name'];
                $row[] = $v['user']['type']?User::$type[$v['user']['type']]:'';
                $row[] = $v['top']['name'];
                $row[] = Client::$status[$v['status']];
                $row[] = $v['admin']['name'];

                $row[] = $v['remark'];
                $row[] = $v['admin_remark'];
                $row[] = $v['sales_remark'];
                $row[] = Client::$sales_status[$v['sales_status']];
                $row[] = $v['transfer_remark'];
                $row[] = $v['created_at'];
                $rows[] = $row;
            }
        }

        // 数据格式化
        $export = new InvoicesExport($rows);

        // 导出
        return Excel::download($export, $this->fileName)->send();
    }
}
