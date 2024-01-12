<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoリスト</title>
</head>
<body>
    ToDoリスト
    <?php
    if($_POST['button'] == 1){
        require 'db.php';
        $pdo = new PDO($connect, USER, PASS);
        $category_sql = $pdo->prepare('insert into Category (category_name) values (?)');
        $category_sql->execute([$_POST['category']]);
        $category_id = $pdo->prepare('select category_id from Category where Category_name = ?');
        $category_id->execute([$_POST['category']]);
        $task_sql = $pdo->prepare('insert into Task(title`row`,state,due_date,create_date,category_id)
                                values(?,?,false,?,current_date(),?)');
        $task_sql->execute([$_POST['title'],$_POST['row'],$_POST['due_date'],$category_id]);
    }
    echo '正常に追加しました';
    ?>
    <div class="container">
        <form action="add.php" method="post">
            <input type="text" name="title">
            <button type="submit">登録</button>
        </form>
        <button type="submit">カレンダー表示</button>
        <button type="button">
            <a href="list.php">一覧</a>
        </button>
    </div>
</body>
</html>                                                                                                                                                                 