<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');
    $errors = isValid($_POST, $conn);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_pwd = $_POST['repeat_pwd'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $dbinfo = $stmt->fetch();

        print_r('id - ' . $dbinfo['id']);
        echo '<br>';
        print_r('name - ' . $dbinfo['name']);
        echo '<br>';
        print_r('email - ' . $dbinfo['email']);
        echo '<br>';
        print_r('password - ' . $dbinfo['password']);
        }

}

function isValid(array $data, PDO $conn): array
{
    $errors = [];
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $repeat_pwd = $data['repeat_pwd'];

    if (!isset($name)) {
        $errors[$name] = 'name is required';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'name должен содержать больше 2-х символов';
    }
    elseif (!isset($email)){
        $errors[$email] = 'email is required';
    } elseif (empty($email)){
        $errors[$email] = 'email не может быть пустым';
    } elseif (strlen($email) < 2){
        $errors['email'] = 'email должен содержать больше 2-х символов';
    }
    elseif (!isset($password)){
        $errors['password'] = 'password is required';
    } elseif (empty($password)){
        $errors['password'] = 'password не может быть пустым';
    } elseif (strlen($password) < 2){
        $errors['password'] = 'password должен содержать больше 2-х символов';
    }
    elseif ($password !== $repeat_pwd){
        $errors['repeat_pwd'] = 'пароли не совадают';
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
    $stmt->execute(['email' => $email]);
    $userData = $stmt->fetch();
    if (!empty($userData)) {
        $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
    }
    return $errors;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Application Registration Form</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            background-color: #72b7f4;
        }
        h2 {
            color: #232729;
            text-align: center; /* Center align the title */
        }
        form {
            background-color: #bfddf7;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333333;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
            background-color: #ffffff; /* Set background color to white */
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #1a73e8;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0059b3;
        }
    </style>
</head>
<body>
<h2>Job Application Registration</h2>
<form action="" method="POST">
    <label for="name">Full Name:</label>
    <label style="color:red"><?php
        if (isset ($errors['name'])) {
            echo $errors['name'];
        }
        ?></label>
    <input type="text" id="name" name="name" required>
    <label for="email">Email Address:</label>
    <label style="color:red"><?php
        if (isset ($errors['email'])) {
            echo $errors['email'];
        }
        ?></label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password:</label>
    <label style="color:red"><?php
        if (isset ($errors['password'])) {
            echo $errors['password'];
        }
        ?></label>
    <input type="password" id="userPassword" name="password" required>
    <label for="userPassword">Repeat Password:</label>
    <label style="color:red"><?php
        if (isset ($errors['repeat_pwd'])) {
            echo $errors['repeat_pwd'];
        }
        ?></label>
    <input type="password" id="userPassword" name="repeat_pwd" required>
    <label><?php echo '<br>'; ?></label>
    <input type="submit" value="Submit Application">
</form>
</body>
</html>



