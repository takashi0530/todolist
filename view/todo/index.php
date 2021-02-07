<?php

require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

$action = new TodoController;
$todo_list = $action->index();
pr($todo_list);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODOリスト</title>
</head>
<body>
    <div>
        <a href="./new.php">新規作成</a>
    </div>
    <div>
        <?php if ($todo_list): ?>
            <ul>
                <?php foreach($todo_list as $todo): ?>
                    <li>
                        <a href="./detail.php?id=<?php echo $todo['id']; ?>">
                            <?php echo $todo['title']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div>データなし</div>
        <?php  endif; ?>
    </div>
</body>
</html>
<?php


// $query = "SELECT * FROM todos";
// $todo_list = Todo::findByQuery($query);  //引数に渡した値に当てはまるレコードを取得

// $todo_list = Todo::findAll();  //全レコードを取得

?>





<?php
// var_dump2($stmh);
// var_dump2($todo_list);

