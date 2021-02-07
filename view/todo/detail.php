<?php

require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

$action = new TodoController;
$todo_id = $action->detail();
pr($todo_id);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>詳細画面</title>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
            <!-- <a href="./detail.php?id=<?php echo $todo['id']; ?>"> -->

                <td scope="row"><?php echo $todo_id['title']; ?></td>
                <td><?php echo $todo_id['detail']; ?></td>
            </tr>
        </tbody>
    </table>
    <div>
        <button><a href="./edit.php?id=<?php echo $todo_id['id']; ?>">編集</a></button>
        </div>
</body>
</html>


<?php
// function pr($var) {
//     echo '<pre style="white-space:pre; font-family: monospace; font-size:12px; border:3px double #BED8E0;" margin:8px;&gt;<code>';
//     print_r($var);
//     echo '</code></pre>';
//     echo '<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css"/>';
//     echo '<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>';
//     echo '<script>hljs.initHighlightingOnLoad();</script>';
// }