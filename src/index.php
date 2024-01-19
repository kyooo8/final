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

                $category_sql = $pdo->prepare('INSERT INTO Category (category_name) VALUES (?)');
                $category_sql->execute([$_POST['category']]);
                
                $category_id_sql = $pdo->prepare('SELECT category_id FROM Category WHERE category_name = ?');
                $category_id_sql->execute([$_POST['category']]);
                $category_id = $category_id_sql->fetchColumn();

                $task_sql = $pdo->prepare('INSERT INTO Task(title, `row`, state, due_date, create_date, category_id)
                                            VALUES (?, ?, false, ?, CURRENT_DATE(), ?)');
                $task_sql->execute([htmlspecialchars($_POST['title']), htmlspecialchars($_POST['row']), $_POST['due_date'], $category_id]);

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

    <label>
        <input type="radio" name="category" value="existing" checked>
        既存のカテゴリーを選択：
    </label>
    <select name="category" >
        <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</option>';
            }
        ?>
    </select>

    <label>
        <input type="radio" name="category_type" value="new">
        新しいカテゴリーを作成：
    </label>
    <input type="text" name="category" placeholder="新しいカテゴリーを入力">

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

        <button type="submit">カレンダー表示</button>
        <button type="button">
            <a href="list.php">一覧</a>
        </button>
    </div>
</body>
</html>
