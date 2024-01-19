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
        $sql = $pdo->query('SELECT * FROM Task');
    ?> 
    <div class="container">
        <table>
            <tr>
                <th>Title</th>
                <th>Row</th>
                <th>State</th>
                <th>Due Date</th>
                <th>Create Date</th>
                <th>Category</th>
            </tr>
            <iframe id="iframe" name="iframe" style="display: none;"></iframe>
            <form action="" method="post" target="iframe">
                <?php
                    foreach($sql as $row){
                        $category = $pdo->prepare('SELECT category_name FROM Category WHERE category_id = ?');
                        $category->execute([$row['category_id']]);
                        $category = $category->fetchColumn();
                        echo '<tr>';
                        echo '<td>', $row['title'], '</td>';
                        echo '<td>', $row['row'], '</td>';
                        echo '<td>', $row['state'], '</td>';
                        echo '<td>', $row['due_date'], '</td>';
                        echo '<td>', $row['create_date'], '</td>';
                        echo '<td>', $category, '</td>';
                        echo '<td><input type="submit" name="delete" values="削除"></td>';
                        echo '<td><input type="submit" name="edit" values="編集"></td>';
                        echo '</tr>'; 
                        
                    }
                ?>
            </form>
        </table>
    </div>
</body>
</html>
