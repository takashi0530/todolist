<?php

require_once '../../model/Todo.php';
require_once '../../validation/TodoValidation.php';


class TodoController {

    public function index() {

        return Todo::findAll();

    }

    public function detail() {

        $todo_id = $_GET['id'];
        $todo = Todo::findById($todo_id);

        return $todo;
    }




    public function new() {

        $data = [              //POSTされたタイトルと詳細を、配列$dataに連想配列として格納
            'title' => $_POST['title'],
            'detail' => $_POST['detail'],
        ];

        $validation = new TodoValidation;       //TodoValidationクラスをインスタンス化
        $validation->setData($data);            //TodoValidationクラスのsetData()メソッドにアクセスする。POSTされたデータ$dataを引数に渡し、クラス内の$dataプロパティに値をセットする

        if ($validation->check() === false) {   //TodoValidationクラスのcheck()メソッドにアクセスし、
            $error_msgs = $validation->getErrorMessages();  //TodoValidationクラスのgetErrorMessages()メソッドにアクセスし返り値を$error_msgsに代入

            session_start();                         //セッションをスタートさせる
            $_SESSION['error_msgs'] = $error_msgs;   //セッションにエラーメッセージを格納

            $params = sprintf("?title=%s&detail=%s", $data['title'], $data['detail']);  //バリデーションに引っ掛かったときに、GETのパラメーターを$paramsに代入
            header("Location: ./new.php" . $params);                    //GETパラメーターを付与したURLに飛ばして、登録した内容が消えないようにinputとtextareaに保持させる
            return;
        }

        $validation_data = $validation->getData();  //バリデーションを通過したデータの配列を取得し代入
        $title = $validation_data['title'];         //$titleにバリデーション通過したタイトルを代入
        $detail = $validation_data['detail'];       //$detailにバリデーション通過した詳細を代入

        $todo = new Todo;   //Todoクラスをインスタンス化
        $todo->setTitle($title);      //TodoクラスのsetTitle()メソッドにタイトルを引数として渡し、値をセットする
        $todo->setDetail($detail);    //TodoクラスのsetDetail()メソッドにタイトルを引数として渡し、値をセットする
        $result = $todo->save();      //Todoクラスのsave()メソッドを呼び出し、結果を代入する

       if ($result === false) {                                         //登録に失敗したとき
            $params = sprintf("?title=%s&detail=%s", $title, $detail);  //登録に失敗したときに、GETのパラメーターを$paramsに代入
            header("Location: ./new.php" . $params);                    //GETパラメーターを付与したURLに飛ばして、登録した内容が消えないようにinputとtextareaに保持させる
            return;                                                     //失敗したのでreturnで処理を中断させる
        }

        header("Location: ./index.php");                                //成功したとき、index.phpにリダイレクトさせる

    }


    public function edit() {
        $todo_id = $_GET['id'];
        $todo = Todo::findById($todo_id);
        if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
            return $todo;
        }
        pr($todo);

        // $todo_id = $_GET['id'];
        $todo_id = $_POST['id'];

        $title = $_POST['title'];
        $detail = $_POST['detail'];

        pr($_POST);

        $todo = new Todo;
        $todo->setTitle($title);
        $todo->setDetail($detail);
        // $todo->update();
        $result = $todo->update();

    }



}










function var_dump2($var) {
    echo '<pre style="white-space:pre; font-family: monospace; font-size:12px; border:3px double #BED8E0;" margin:8px;&gt;<code>';
    var_dump($var);
    echo '</code></pre>';
    echo '<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css"/>';
    echo '<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>';
    echo '<script>hljs.initHighlightingOnLoad();</script>';
}

function pr($var) {
    echo '<pre style="white-space:pre; font-family: monospace; font-size:12px; border:3px double #BED8E0;" margin:8px;&gt;<code>';
    print_r($var);
    echo '</code></pre>';
    echo '<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css"/>';
    echo '<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>';
    echo '<script>hljs.initHighlightingOnLoad();</script>';
}