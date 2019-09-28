<?php
namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TimeAnalysis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time_analysis';
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



        $this->info('测试成功！');
        return ;
    }
}
