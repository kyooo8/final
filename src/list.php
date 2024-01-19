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
        
        if(isset($_POST["delete"])){
            $delete = $pdo->prepare("DELETE FROM Task WHERE task_id = ?");
            $delete->execute([$_POST['delete']]);
        }
        if(isset($_POST["edit"])){
            $edit = $pdo->prepare("UPDATE Task SET title = ?, `row` = ?, state = ?, due_date = ?, category_id = ? WHERE task_id = ?");
            $edit->execute([$_POST['title'], $_POST['row'], $_POST['state'], $_POST['due_date'], $_POST['edit'], $_POST['id']]);
        }
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
                <th>Actions</th>
            </tr>
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
                    echo '<td>
                            <form action="" method="post">
                                <input type="hidden" name="delete" value="' . $row['task_id'] . '">
                                <input type="submit" value="削除">
                            </form>
                        </td>';
                    echo '<td>
                            <form action="" method="post">
                                <input type="hidden" name="edit" value="' . $row['task_id'] . '">
                                <input type="submit" value="編集">
                            </form>
                        </td>';
                    echo '</tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
