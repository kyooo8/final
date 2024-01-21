<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリー</title>
</head>
<body>
    <a href="index.php">戻る</a>
    <?php
    require 'db.php';
    $pdo = new PDO($connect, USER, PASS);
    $categories = $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['new'])) {
        foreach ($_POST['category'] as $categoryId => $categoryName) {
            $updateCategory = $pdo->prepare('UPDATE Category SET category_name = ? WHERE category_id = ?');
            $updateCategory->execute([$categoryName, $categoryId]);
        }

        echo 'カテゴリーが更新されました';
        $categories = $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC);
    }?>
    <form action="" method="post">
        <?php
    foreach ($categories as $category) {
        echo '<input type="text" name="category[' . $category['category_id'] . ']" value="' . $category['category_name'] . '">';
    }
    ?>
    <input type="hidden" name="new">
    <input type="submit" value="更新">
    </form>
</body>
</html>
