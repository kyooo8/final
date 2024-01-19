<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="title">タイトル：</label>
        <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">

        <label for="row">行：</label>
        <input type="text" id="row" name="row" value="<?php echo isset($_POST['row']) ? htmlspecialchars($_POST['row']) : ''; ?>">

        <label for="due_date">期限日：</label>
        <input type="date" id="due_date" name="due_date" value="<?php echo isset($_POST['due_date']) ? $_POST['due_date'] : ''; ?>">

        <label for="category">カテゴリー：</label>
        <input type="text" id="category" name="category" value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>">

        <button type="submit" name="button">追加</button>
    </form>
</body>
</html>