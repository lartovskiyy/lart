<!-- admin.php -->
<?php
require_once('config.php');
$admin_id = checkAuth();
$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LART Admin Panel</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/mk9hcIR.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Google Sans', 'Segoe UI', -apple-system, sans-serif;
        }
        
        body {
            background: #0D0D0D;
            color: #E6E6E6;
            line-height: 1.5;
            padding: 20px;
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn {
            background: rgba(255, 255, 255, 0.1);
            color: #E6E6E6;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .btn-primary {
            background: #4e7dff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #3e6de0;
        }
        
        .btn-danger {
            background: #ff4e4e;
            color: white;
        }
        
        .btn-danger:hover {
            background: #e03e3e;
        }
        
        .posts-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .posts-table th,
        .posts-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .posts-table th {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: #E6E6E6;
            font-size: 16px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        textarea.form-control {
            min-height: 200px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1>LART Админ-панель</h1>
            <div>
                <a href="create_post.php" class="btn btn-primary">Создать пост</a>
                <a href="logout.php" class="btn">Выйти</a>
            </div>
        </div>
        
        <h2>Все посты</h2>
        <table class="posts-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($posts) > 0): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?></td>
                            <td>
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn">Редактировать</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Нет постов</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<!-- create_post.php -->
<?php
require_once('config.php');
$admin_id = checkAuth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if (!empty($title) && !empty($content)) {
        $post_id = createPost($title, $content, $admin_id);
        if ($post_id) {
            header("Location: admin.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать пост - LART Admin</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/mk9hcIR.png">
    <!-- Стили идентичны admin.php -->
    <style>/* Стили скопировать из admin.php */</style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1>Создать новый пост</h1>
            <a href="admin.php" class="btn">Назад</a>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="content">Содержание</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Опубликовать</button>
        </form>
    </div>
</body>
</html>