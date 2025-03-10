<?php
// login.php
require_once('config.php');

session_start();
$error = '';

// Если пользователь уже авторизован, перенаправляем в админку
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $conn = connectDB();
        $username = $conn->real_escape_string($username);
        
        $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Проверяем пароль (предполагается, что пароли хранятся хэшированными)
            if (password_verify($password, $user['password']) && $user['role'] == 'admin') {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                
                header("Location: admin.php");
                exit;
            } else {
                $error = 'Неверный пароль или недостаточно прав';
            }
        } else {
            $error = 'Пользователь не найден';
        }
        
        $conn->close();
    } else {
        $error = 'Пожалуйста, заполните все поля';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель - LART</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
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
        
        .btn {
            width: 100%;
            background: #4e7dff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #3e6de0;
        }
        
        .error {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>LART Админ</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn">Войти</button>
        </form>
    </div>
</body>
</html>