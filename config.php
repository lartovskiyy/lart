<?php
// config.php - настройки подключения к БД
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'lart_site');

// Подключение к базе данных
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Ошибка подключения к БД: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Проверка аутентификации
function checkAuth() {
    session_start();
    if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit;
    }
    return $_SESSION['admin_id'];
}

// Получение всех постов
function getAllPosts() {
    $conn = connectDB();
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $posts = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    
    $conn->close();
    return $posts;
}

// Получение поста по ID
function getPostById($id) {
    $conn = connectDB();
    $id = $conn->real_escape_string($id);
    $sql = "SELECT * FROM posts WHERE id = '$id'";
    $result = $conn->query($sql);
    $post = null;
    
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }
    
    $conn->close();
    return $post;
}

// Создание нового поста
function createPost($title, $content, $author_id) {
    $conn = connectDB();
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $author_id = $conn->real_escape_string($author_id);
    
    $sql = "INSERT INTO posts (title, content, author_id, created_at) 
            VALUES ('$title', '$content', '$author_id', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $post_id = $conn->insert_id;
        $conn->close();
        return $post_id;
    } else {
        $conn->close();
        return false;
    }
}

// Обновление поста
function updatePost($id, $title, $content) {
    $conn = connectDB();
    $id = $conn->real_escape_string($id);
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    
    $sql = "UPDATE posts SET title = '$title', content = '$content', updated_at = NOW() 
            WHERE id = '$id'";
    
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Удаление поста
function deletePost($id) {
    $conn = connectDB();
    $id = $conn->real_escape_string($id);
    
    $sql = "DELETE FROM posts WHERE id = '$id'";
    
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
?>