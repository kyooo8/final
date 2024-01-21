<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoリスト</title>
</head>
<body>
    <?php
        require 'db.php';

        $pdo = new PDO($connect, USER, PASS);
        $categories = $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC);
        
        try {
            if(isset($_POST['title'], $_POST['row'], $_POST['due_date'], $_POST['category'])){

                $task_sql = $pdo->prepare('INSERT INTO Task(title, `row`, state, due_date, create_date, category_id)
                                            VALUES (?, ?, false, ?, CURRENT_DATE(), ?)');
                $task_sql->execute([$_POST['title'],$_POST['row'], $_POST['due_date'], $_POST['category']]);

                echo '正常に追加しました';
            }
        } catch (PDOException $e) {
            echo 'データベースエラー: ' . $e->getMessage();
        }
    ?>
    <div class="container">
        <form action="add.php" method="post">
    <input type="text" name="title" required>
    <input type="text" name="row" required>
    <input type="date" name="due_date" required>
    
    <button type="submit" name="button">登録</button>
</form>

        <div class="nextTask">
            <h2>次のタスク</h2>
            <?php
                $tasks = $pdo->query('SELECT * FROM Task ORDER BY create_date DESC LIMIT 1');
                foreach($tasks as $task){
                    echo '<p>', $task['title'], ' - ', $task['due_date'], '</p>';
                }
            ?>
        </div>

        <button type="button">
            <a href="list.php">一覧</a>
        </button>
    </div>
</body>
</html>
