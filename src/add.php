<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
</head>
<body>
    <?php
        require 'db.php';

        $pdo = new PDO($connect, USER, PASS);
        $categories = $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <a href="index.php">戻る</a>
    <form action="index.php" method="post">
        <label for="title">タイトル：</label>
        <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">

        <label for="row">内容：</label>
        <input type="text" id="row" name="row" ">

        <label for="due_date">期限日：</label>
        <input type="date" id="due_date" name="due_date" required>

        <select name="category" >
        <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category['category_id'] . '">' .$category['category_name']. '</option>';
            }
        ?>
        </select>
        <a href="category.php">カテゴリーの編集</a>
        <button type="submit" name="button">追加</button>
    </form>
</body>
</html>