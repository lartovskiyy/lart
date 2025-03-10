<?php
require_once('config.php');
$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Ваши текущие мета-теги и стили -->
    <style>
        /* Добавить стили для отображения постов */
        .posts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        
        .post-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
            height: 100%;
        }
        
        .post-card:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-4px);
        }
        
        .post-title {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 16px;
            color: #FFFFFF;
        }
        
        .post-date {
            font-size: 0.8rem;
            color: #808080;
            margin-bottom: 12px;
        }
        
        .post-excerpt {
            font-size: 0.95rem;
            color: #B0B0B0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 16px;
        }
        
        .post-link {
            display: inline-block;
            color: #4e7dff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .post-link:hover {
            color: #3e6de0;
        }
    </style>
</head>
<body>
    <div class="container" id="main-container">
        <!-- Ваш текущий hero-section -->
        <section id="hero-section">
            <!-- ... существующий код ... -->
        </section>
        
        <!-- Секция с постами -->
        <section id="posts-section" class="bio-section">
            <div class="bio-container visible">
                <h2 style="margin-bottom: 24px; color: #FFFFFF;">Последние посты</h2>
                
                <div class="posts-container">
                    <?php if (count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="post-card">
                                <h3 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <div class="post-date"><?php echo date('d.m.Y', strtotime($post['created_at'])); ?></div>
                                <div class="post-excerpt">
                                    <?php echo substr(strip_tags($post['content']), 0, 150) . '...'; ?>
                                </div>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="post-link">Читать полностью →</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Пока нет постов</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        
        <!-- Ваша существующая bio-section -->
        <section id="bio-section" class="bio-section">
            <!-- ... существующий код ... -->
        </section>
    </div>
    
    <!-- Ваши скрипты -->
</body>
</html>