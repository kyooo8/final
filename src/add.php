<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        <input type="text" name="row" value="<?php echo isset($_POST['row']) ? htmlspecialchars($_POST['row']) : ''; ?>">
        <input type="date" name="due_date" value="<?php echo isset($_POST['due_date']) ? $_POST['due_date'] : ''; ?>">
        <input type="text" name="category" value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>">
        <button type="submit" name="button">追加</button>
    </form>
</body>
</html>
