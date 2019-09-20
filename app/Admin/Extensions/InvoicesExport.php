<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\7\30 0030
 * Time: 16:35
 */
namespace App\Admin\Extensions;


use Maatwebsite\Excel\Concerns\FromArray;

class InvoicesExport implements FromArray
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}
