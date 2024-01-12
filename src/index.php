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
    if(isset($_POST['title'], $_POST['row'], $_POST['due_date'], $_POST['category'])){
        require 'db.php';
        $pdo = new PDO($connect, USER, PASS);

        // カテゴリ追加
        $category_sql = $pdo->prepare('INSERT INTO Category (category_name) VALUES (?)');
        $category_sql->execute([$_POST['category']]);

        // カテゴリID取得
        $category_id_sql = $pdo->prepare('SELECT category_id FROM Category WHERE category_name = ?');
        $category_id_sql->execute([$_POST['category']]);
        $category_id = $category_id_sql->fetchColumn();

        // タスク追加
        $task_sql = $pdo->prepare('INSERT INTO Task(title, `row`, state, due_date, create_date, category_id)
                                    VALUES (?, ?, false, ?, CURRENT_DATE(), ?)');
        $task_sql->execute([$_POST['title'], $_POST['row'], $_POST['due_date'], $category_id]);

        echo '正常に追加しました';
    }
    ?>
    <div class="container">
        <form action="add.php" method="post">
            <input type="text" name="title">
            <button type="submit" name="button">登録</button>
        </form>
        <button type="submit">カレンダー表示</button>
        <button type="button">
            <a href="list.php">一覧</a>
        </button>
    </div>
</body>
</html>
