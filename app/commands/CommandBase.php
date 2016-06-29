<?php

use Illuminate\Console\Command;

class CommandBase extends Command
{

    /** @var Object logWriterオブジェクト */
    protected $log;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();

        //バッチ処理のログ出力先を別にする為
        $this->log = new Illuminate\Log\Writer(new Monolog\Logger('Batch log'));
        $this->log->useDailyFiles(app_path() . '/storage/logs/batch.log');
    }

    // function __destruct() {
    //     $this->log->info("CommandBase Class END!" );
    // }

    /*
     * DB接続のための初期情報をredisより取得し、初期化する
     */
    function init_DB($sid)
    {
        //DB接続の初期化
        $rmdd = new RedisModelDefineData();
        $rmdd->sid = $sid;
        $data = $rmdd->getAllDefine();
        // $this->log->info($data);
        $defData = [];
        foreach ($data as $val) {
            if (is_array($val)) {
                foreach ($val as $key => $valval) {
                    $defData[$key] = $valval;
                }
            }
        }
        if (TEST_SERVER) {
            krsort($defData);
        }
        // $this->log->info($defData);

        $i = new Initialize($defData);
        $i->exec();
        // $this->log->debug(Config::get('database.connections.GAME_DB'));

    }
}
