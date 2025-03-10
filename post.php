<?php
require_once('config.php');

$post_id = $_GET['id'] ?? 0;
$post = getPostById($post_id);

if (!$post) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - LART</title>
    <link id="favicon" rel="icon" type="image/png" href="https://i.imgur.com/mk9hcIR.png">
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
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 24px;
            color: #B0B0B0;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: #FFFFFF;
        }
        
        .post-header {
            margin-bottom: 32px;
        }
        
        .post-title {
            font-size: 2.5rem;
            color: #FFFFFF;
            margin-bottom: 16px;
        }
        
        .post-meta {
            font-size: 0.9rem;
            color: #808080;
        }
        
        .post-content {
            color: #D0D0D0;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .post-content p {
            margin-bottom: 1.5rem;
        }
        
        .post-content a {
            color: #4e7dff;
            text-decoration: none;
        }
        
        .post-content a:hover {
            text-decoration: underline;
        }
        
        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Назад на главную</a>
        
        <article class="post">
            <header class="post-header">
                <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="post-meta">
                    Опубликовано: <?php echo date('d.m.Y H:i', strtotime($post['created_at'])); ?>
                    <?php if ($post['updated_at']): ?>
                        | Обновлено: <?php echo date('d.m.Y H:i', strtotime($post['updated_at'])); ?>
                    <?php endif; ?>
                </div>
            </header>
            
            <div class="post-content">
                <?php echo $post['content']; ?>
            </div>
        </article>
    </div>
</body>
</html>