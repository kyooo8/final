<?php
require 'db.php'; 
$pdo = new PDO($connect, USER, PASS);

$categories = $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["update_button"])) {
    try {
        $update_task = $pdo->prepare('UPDATE Task 
                                      SET title = ?, `row` = ?, due_date = ?, category_id = ?
                                      WHERE task_id = ?');
        $update_task->execute([
            htmlspecialchars($_POST["edit_title"]),
            htmlspecialchars($_POST["edit_row"]),
            $_POST["edit_due_date"],
            $_POST["edit_category"],
            $_POST["id"]
        ]);
        echo 'タスクが更新されました';
    } catch (PDOException $e) {
        echo 'データベースエラー: ' . $e->getMessage();
    }
}

if (isset($_POST["delete"])) {
    $delete = $pdo->prepare("DELETE FROM Task WHERE task_id = ?");
    $delete->execute([$_POST['delete']]);
}


$sql = $pdo->query('SELECT * FROM Task');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo一覧</title>
</head>
<body>
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
                foreach ($sql as $row) {
                    $category = $pdo->prepare('SELECT category_name FROM Category WHERE category_id = ?');
                    $category->execute([$row['category_id']]);
                    $category = $category->fetchColumn();
                    echo '<tr>';
                    echo '<td>', htmlspecialchars($row['title']), '</td>';
                    echo '<td>', htmlspecialchars($row['row']), '</td>';
                    echo '<td>', htmlspecialchars($row['state']), '</td>';
                    echo '<td>', htmlspecialchars($row['due_date']), '</td>';
                    echo '<td>', htmlspecialchars($row['create_date']), '</td>';
                    echo '<td>', htmlspecialchars($category), '</td>';
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
                if (isset($_POST["edit"])) {
                    echo '<tr>
                            <td colspan="6">編集中...</td>
                        </tr>';
                }
            ?>
        </table>

        <?php
            if (isset($_POST["edit"])) {
                $edit_task = $pdo->prepare('SELECT * FROM Task WHERE task_id = ?');
                $edit_task->execute([$_POST["edit"]]);
                $task = $edit_task->fetch();

                echo '<form action="" method="post">';
                echo '<input type="hidden" name="id" value="' . $task['task_id'] . '">';
                echo '<input type="text" name="edit_title" value="' . htmlspecialchars($task['title']) . '" required>';
                echo '<input type="text" name="edit_row" value="' . htmlspecialchars($task['row']) . '" required>';
                echo '<input type="date" name="edit_due_date" value="' . $task['due_date'] . '" required>';

                echo '<select name="edit_category" required>';
                foreach ($categories as $category) {
                    $selected = ($task['category_id'] == $category['category_id']) ? 'selected' : '';
                    echo '<option value="' . $category['category_id'] . '" ' . $selected . '>' . htmlspecialchars($category['category_name']) . '</option>';
                }
                echo '</select>';

                echo '<button type="submit" name="update_button">更新</button>';
                echo '</form>';
            }
        ?>
    </div>
</body>
</html>
