<?php

require_once("conn_db.php");

// 安全クラス
class QueryAnzen extends ConnDB {
    public function __construct() {
        parent::__construct();
        // var_dump('comp');
    }

    // 安全言葉の参照
    public function getAnzen() {
        $sql = "SELECT 開始日, 終了日, 部署名, 氏名, 安全言葉 
                FROM general.dbo.T_Anzen
                WHERE 開始日 >= GETDATE();";
        return $this->pdo->query($sql);
    }

    // 安全言葉の登録
    public function addAnzen($startDay, $endDay, $division, $fullName, $anzenWord, $addIP) {
        // SQL作成
        $sql = 'INSERT INTO general.dbo.T_Anzen(
                    開始日,
                    終了日,
                    部署名,
                    氏名,
                    安全言葉,
                    登録IP
                )VALUES(
                    CONVERT(DATETIME, :startDay),
                    CONVERT(DATETIME, :endDay),
                    :division,
                    :fullName,
                    :anzenWord,
                    :addIP
                );';
        try {
            $this->pdo->beginTransaction(); // トランザクション開始
            $stmt = $this->pdo->prepare($sql); // SQLセット
            $stmt->bindParam(":startDay",   $startDay);
            $stmt->bindParam(":endDay",     $endDay);
            $stmt->bindParam(":division",   $division,  PDO::PARAM_STR);
            $stmt->bindParam(":fullName",   $fullName,  PDO::PARAM_STR);
            $stmt->bindParam(":anzenWord",  $anzenWord, PDO::PARAM_STR);
            $stmt->bindParam(":addIP",      $addIP,     PDO::PARAM_STR);
            $stmt->execute(); // SQLバインド
            $this->pdo->commit(); // 完了処理
        }catch(Exception $e) { // 例外処理
            $this->pdo->rollBack();
            return $e;
        }
    }
}