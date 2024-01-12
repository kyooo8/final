<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo一覧</title>
</head>
<body>
    <?php 
        require 'db.php'; 
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->query('select * from Task');
        foreach($sql as $row){
            $category = $pdo->prepare('select category_name form Category where id = ?');
            $category->execute([$row['category_id']]);
            echo '<tr>';
            echo '<td>',$row['title'],'</td>';
            echo '<td>',$row['row'],'</td>';
            echo '<td>',$row['state'],'</td>';
            echo '<td>',$row['due_date'],'</td>';
            echo '<td>',$row['create_date'],'</td>';
            echo '<td>',$category,'</td>';
            echo '</tr>'; 
        }
    ?> 
    <div class="container">
    </div>
</body>
</html>