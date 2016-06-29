<?php
/**
 * Phalanx
 */

/**
 * データベース操作の基底モデルクラス
 */
class ModelBase
{
    /** @var Object PDOオブジェクト */
    protected $pdo;
    /** @var Object 読み取り用PDOオブジェクト */
    protected $readPdo;
    /** @var string データベース名 */
    protected $dbName;
    /** @var string ホスト名(IP) */
    protected $host;
    /** @var string DB接続ユーザー */
    protected $user;
    /** @var string DB接続パスワード */
    protected $pass;
    /** @var string DB接続名(database.php内) */
    protected $conName;
    /** @var array PDOのデフォルトオプションパラメータ */
    protected $pdoOption = [
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ];

    /**
     * DB情報の初期化(保持)
     */
    public function __construct() {
        $this->init();
    }

    /**
     * 変数の定義
     */
    public function init() {
        if (empty($this->conName)) {
            $this->conName  = DB::getName();
        }
        $this->host     = DB::connection($this->conName)->getConfig('host');
        $this->dbName   = DB::connection($this->conName)->getConfig('cakephp_db');
        $this->readPdo  = DB::connection($this->conName)->getReadPdo();
        $this->pdo      = DB::connection($this->conName)->getPdo();
        $this->user     = DB::connection($this->conName)->getConfig('username');
        $this->pass     = DB::connection($this->conName)->getConfig('password');
    }

    /**
     * DBコネクションを変更する
     * ※app/config/database.phpで定義してある場合は本クラスで変更せずに
     * changeDbName()で変更できます。
     * 本関数は緊急時の使用に限定して下さい。
     * @param string $dbName データベース名
     * @param null $host ホスト名(IP)
     * @param null $user ユーザー名
     * @param null $pass パスワード
     * @throws Exception
     */
    public function changeConnection($dbName, $host = null, $user = null, $pass = null) {
        try {
            if (empty($host)) { $host = $this->host; } // 引数が無い場合は現在のものを引き継ぎ
            if (empty($user)) { $user = $this->user; } // 引数が無い場合は現在のものを引き継ぎ
            if (empty($pass)) { $pass = $this->pass; } // 引数が無い場合は現在のものを引き継ぎ
            $pdoStr = 'mysql:dbname=%s;host=%s';
            $pdo = new PDO(sprintf($pdoStr, $dbName, $host), $user, $pass, $this->pdoOption);
            DB::connection($this->conName)->setDatabaseName($dbName);
            DB::connection($this->conName)->setReadPdo($pdo);
            DB::connection($this->conName)->setPdo($pdo);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * DBのコネクションを変更します。
     * 基本的にDB::connection('ここ')が変更されます。
     * @param $dbName
     */
    public function changeDbName($dbName) {
        $this->conName = $dbName;
    }

    /**
     * database.phpのコネクション名に接続しなおします
     * @param $configStr
     */
    public function changeConfigConnection($configStr) {
        $this->conName = $configStr;
        $this->init();
    }

    /**
     * 接続を解除する
     */
    public function disconnect() {
        DB::connection($this->conName)->disconnect();
    }

    /**
     * トランザクションを開始する
     */
    public function beginTransaction() {
        DB::connection($this->conName)->beginTransaction();
    }

    /**
     * コミットを行う
     */
    public function commit() {
        DB::connection($this->conName)->commit();
    }

    /**
     * ロールバックを行う
     */
    public function rollBack() {
        DB::connection($this->conName)->rollback();
    }

    /**
     * select文の発行(selectのwrap関数)
     * @param $query
     * @param array $bindings
     * @param bool $useReadPdo
     * @return mixed
     */
    public function select($query, $bindings = array(), $useReadPdo = true) {
        return DB::connection($this->conName)->select($query, $bindings, $useReadPdo);
    }

    /**
     * テーブル選択(tableのwrap関数)
     * @param $table
     * @return mixed
     */
    public function table($table) {
        return DB::connection($this->conName)->table($table);
    }

    /**
     * インサート文の発行(insertのwrap関数)
     * @param $query
     * @param array $bindings
     * @return mixed
     */
    public function insert($query, $bindings = array()) {
        return DB::connection($this->conName)->insert($query, $bindings);
    }

    /**
     * アップデート文の発行(updateのwrap関数)
     * @param $query
     * @param array $bindings
     * @return mixed
     */
    public function update($query, $bindings = array()) {
        return DB::connection($this->conName)->update($query, $bindings);
    }

    /**
     * Running a general statement
     *
     * @param $query
     * @param array $bindings
     * @return mixed
     */
    public function statement($query, $bindings = array()) {
        return DB::connection($this->conName)->statement($query, $bindings);
    }

    /**
     * Delete database
     * @param $query
     * @param array $bindings
     * @return mixed
     */
    public function delete($query, $bindings = array()) {
        return DB::connection($this->conName)->delete($query, $bindings);
    }

    /**
     * Raw Expressions sql query
     * @param mixed $value
     * @return mixed
     */
    public function raw($query) {
        return DB::connection($this->conName)->raw($query);
    }

    /**
     * Exec sql query
     * (非推奨)
     * ※新規機能には絶対に使わないで下さい。
     * @param $query
     * @return int
     */
    public function exec($query) {
        return DB::connection($this->conName)->getpdo()->exec($query);
    }

    /**
     * 接続コンフィグ名を取得する
     * @return mixed
     */
    public function getName() {
        return DB::connection($this->conName)->getName();
    }

    /**
     * 現在接続中のDB名を取得する
     * @return mixed
     */
    public function getDatabaseName() {
        return DB::connection($this->conName)->getDatabaseName();
    }

    /**
     * 接続情報を取得する
     * @param $configName
     * @return mixed
     */
    public function getConfig($configName) {
        return DB::connection($this->conName)->getConfig($configName);
    }

    /**
     * Pdoにおけるフェッチモードを取得します
     * @return mixed
     */
    public function getFetchMode() {
        return DB::connection($this->conName)->getFetchMode();
    }

    /**
     * Pdoにおけるフェッチモードをセットします
     * @param $mode
     */
    public function setFetchMode($mode) {
        DB::connection($this->conName)->setFetchMode($mode);
    }

    /**
     * クエリーログを返却します。
     * @return mixed
     */
    public function getQueryLog() {
        return DB::connection($this->conName)->getQueryLog();
    }

    /**
     * クエリログをリセットします
     */
    public function flushQueryLog() {
        DB::connection($this->conName)->flushQueryLog();
    }

    /**
     * クエリログを有効にします
     */
    public function enableQueryLog() {
        DB::connection($this->conName)->enableQueryLog();
    }

    /**
     * クエリログを無効にします
     */
    public function disableQueryLog() {
        DB::connection($this->conName)->disableQueryLog();
    }
}