<?php
namespace App\Console\Commands;

use App\Models\Client;
use App\Models\ClientUser;
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

        //不管策略是否生效，都更新时间查看规则，是否满足需求
        ClientUser::where([
            ['status','=',-1],
        ])->whereColumn('effect_at', '<', 'created_at')->update([
            'status'=>0
        ]);

        //发送短信,如果是
        $where = [];

        $where[] =['clients_users.status','=',-1];
        $where[] =['clients.user_id','>',0];  //对于确定了的用户，

//        >leftJoin('posts', 'users.id', '=', 'posts.user_id')
        $clients =  ClientUser::where(
            $where
        )->leftJoin('clients','clients_users.client_id','=','clients.id')->with('client')->orderBy('clients_users.id','desc')->paginate(7);




        return ;
    }
}
