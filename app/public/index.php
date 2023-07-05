<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');
    $errors = isValid($_POST, $conn);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $phone = password_hash($phone, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)");
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $dbinfo = $stmt->fetch();

        print_r('id - ' . $dbinfo['id']);
        echo '<br>';
        print_r('name - ' . $dbinfo['name']);
        echo '<br>';
        print_r('email - ' . $dbinfo['email']);
        echo '<br>';
        print_r('phone - ' . $dbinfo['phone']);
        }

}

function isValid(array $data, PDO $conn): array
{
    $errors = [];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

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
    elseif (!isset($phone)){
        $errors['psw'] = 'password is required';
    } elseif (empty($phone)){
        $errors['phone'] = 'phone не может быть пустым';
    } elseif (strlen($phone) < 2){
        $errors['phone'] = 'phone должен содержать больше 2-х символов';
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
    <label for="phone">Phone Number:</label>
    <label style="color:red"><?php
        if (isset ($errors['phone'])) {
            echo $errors['phone'];
        }
        ?></label>
    <input type="tel" id="phone" name="phone" required>
    <label for="position">Position Applied:</label>
    <select id="position" name="position" required>
        <option value="">Select Position</option>
        <option value="frontend-developer">Frontend Developer</option>
        <option value="backend-developer">Backend Developer</option>
        <option value="graphic-designer">Graphic Designer</option>
    </select>
    <input type="submit" value="Submit Application">
</form>
</body>
</html>



