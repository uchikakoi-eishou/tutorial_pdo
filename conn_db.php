<?php

// DB接続クラス
class ConnDB {
    // 接続プロパティ
    private $dsn = 'sqlsrv:server=minawww3;database=general';
    private $user = 'general';
    private $password = '2017sysmina';
    protected $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password); // DB接続
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラー設定
        }catch(Exception $e){
            print_r('エラーが発生しました。システム管理者へ連絡ください。');
            die(print_r($e->getMessage()));
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }

}
