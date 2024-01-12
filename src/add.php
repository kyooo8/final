<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="text" name="title" value="<?php echo $_POST['title'];?>">
        <input type="text" name="row">
        <input type="text" name="due_date">
        <input type="text" name="category">
        <button type="submit" name="button" id="1">追加</button>
    </form>
</body>
</html>