<?php
require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';


session_start();                        //セッションをスタートしエラーメッセージを取得する
$error_msgs = $_SESSION['error_msgs'];  //セッション情報のエラーメッセージを取得し、代入。 エラーメッセージがあれば内容が入る。なければなし。
unset($_SESSION['error_msgs']);         //すでにエラーメッセージは取得済みとなり、セッション情報は不要なので削除   unset()関数でリセット


if ($_SERVER['REQUEST_METHOD'] === "POST") {  //todoを登録したとき、リクエストメソッドがPOSTの場合の処理
    $action = new TodoController;
    $action->new();
}

$title = '';
$detail = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {  //GETされたとき
    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    }
    if (isset($_GET['detail'])) {
        $detail = $_GET['detail'];
    }
}

pr($data);
pr($_POST);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規作成</title>
</head>
<body>
    <div>新規作成</div>
    <form action="./new.php" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="<?php echo $title; ?>">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail"><?php echo $detail; ?></textarea>
            </div>
        </div>
        <button type="submit">登録</button>
    </form>

    <!-- セッション情報で取得したerror_msgsに値があるとき（バリデーションに引っ掛かった場合） エラーメッセージを表示する。エラーがなければ表示しない -->
    <?php if ($error_msgs): ?>
        <div>
            <ul>
                <?php foreach ($error_msgs as $error_msg): ?>
                    <li><?php echo $error_msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</body>
</html>