<?php
namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClientSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client_send';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'client send';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 处理数据库的操作。。每天定时更新
     *
     * @return mixed
     */
    public function handle()
    {

        //查看规则，是否满足需求
        for


        $this->info('测试成功！');
        return ;
    }
}
