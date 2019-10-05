<?php
namespace App\Console\Commands;

use App\Models\ClientUser;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';
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

        //不管策略是否生效，都更新时间查看规则，是否满足需求
        $this->info('test');
        $test  = new \App\Models\Test();
//        $client_user->client_id = $client_id;
        $test->save();

        return ;
    }
}
