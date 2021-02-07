<?php



class Todo {

    public $title;
    public $detail;
    public $status;


    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public static function findByQuery($query) {

        $dbh = new PDO(DSN, USERNAME, PASSWORD);            //PDPクラス PDOをnewしたときにコンストラクタが呼ばれ、引数を渡すことでDBに接続する
        $stmh = $dbh->query($query);                        //queryメソッド 引数で渡したSQL文を実行してくれる

        if ($stmh) {
            $result = $stmh->fetchAll(PDO::FETCH_ASSOC);    //全てのデータを取得する場合fetchAllを使う。PDO::FETCH_ASSOC ：SQLの実行結果を連想配列で取得する
        } else {
            $result = [];
        }
        return $result;
    }

    public static function findAll() {                 //todoテーブルの全レコードを取得するメソッド
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = "SELECT * FROM todos";
        $stmh = $dbh->query($query);
        if ($stmh) {
            $result = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }

    public static function findById($todo_id) {     //static...インスタンスを生成しなくてもクラスのメンバにアクセスできる
        $query = sprintf('
            SELECT *
            FROM todos
            WHERE id = %s',
            $todo_id
        );
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $dbh->query($query);
        if($stmh) {
            $result = $stmh->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;

        // return $stmh->fetch(PDO::FETCH_ASSOC);

    }

    public function save() {
        $query = sprintf(
            "INSERT INTO todos
                (title, detail, status, created_at, updated_at)
            VALUES ('%s', '%s', 0, NOW(), NOW());",
            $this->title,
            $this->detail
            );

            // $stmh = $dbh->prepare($query);
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            $dbh->beginTransaction();   //トランザクションを開始するための処理
            // $this->pdo->beginTransaction();

            $stmt = $dbh->prepare($query);
            // $stmt = $this->pdo->prepare($query);
            // $stmt->execute;
            $result = $stmt->execute();

            $dbh->commit();
            // $stmh = $dbh->prepare($query);

        } catch(PDOException $e) {      //もしエラーが発生し、catchされたら、その中でロールバックの処理を書く
            $this->pdo->rollBack();     //ロールバック

            echo $e->getMessage();      //エラーメッセージを出力
            echo '失敗しました';
            $result = false;
        }

        return $result;
    }

    public function update() {
        // $query = sprintf("UPDATE todos SET title = %s, detail = %s;",
        // $this->title,
        // $this->detail
        // );
        $query = sprintf("UPDATE `todos` SET `title` = %s, `detail` = %s WHERE `id` = %s", $this->title, $this->detail, $todo_id['id']);

pr($query);
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            //トランザクション開始
            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();   //コミット
        } catch (PDOException $e) {

            $this->pdo->rollBack(); //ロールバック
            echo $e->getMessage();  //エラーメッセージを出力

        }
        return $result;



    }

    // public function update() {
    //     $query = sprintf("UPDATE `todos` SET `title` = %s AND `detail` = %s WHERE `id` = %s", $this->title, $this->detail, $thid->id);

    //     try {
    //         $dbh = new PDO(DSN, USERNAME, PASSWORD);

    //         // トランザクション開始
    //         $dbh->beginTransaction();

    //         $stmt = $dbh->prepare($query);
    //         $result = $stmt->execute();

    //         $dbh->commit();
    //     } catch (PDOException $e) {
    //         // ロールバック
    //         $dbh->rollBack();

    //         echo $e->getMessage();
    //         $result = false;
    //     }

    //     return $result;
    // }




}