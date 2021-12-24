<?php include("includes/header.php"); ?>
<div class="container mregister">
    <div id="login">
        <h1>Реєстрація</h1>
        <form action="register.php" id="registerform" method="post" name="registerform">
            <p><label for="name">Имя<br>
                    <input class="input" id="name" name="name" size="32" type="text" value=""></label></p>
            <p><label for="email">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
            <p><label for="user">Логин<br>
                    <input class="input" id="user" name="user" size="20" type="text" value=""></label></p>
            <p><label for="password">Пароль<br>
                    <input class="input" id="password" name="password" size="32" type="password" value=""></label></p>
            <p class="submit"><input class="button" id="register" name="register" type="submit" value="Готово"></p>
            <p class="regtext">Вже зареєстровані? <a href="index.php">Увійти</a>!</p>
        </form>
    </div>
</div>

<?php

if (isset($_POST["register"])) {

    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['user']) && !empty($_POST['password'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $user = htmlspecialchars($_POST['user']);
        $password = htmlspecialchars($_POST['password']);
        $query = mysqli_query($con, "SELECT * FROM client WHERE user='" . $user . "'");
        $numrows = mysqli_num_rows($query);
        if ($numrows == 0) {
            //INSERT INTO `gym`.`client`(`surname`, `name`, `adress`, `email`, `user`, `telephone`) VALUES ('q', 'q', 'q', 'q@q', 'q', 1)
            $sql = "INSERT INTO client (name, email, user,password) VALUES('" . $name . "','" . $email . "', '" . $user . "', '" . $password . "')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $message = "Акаунт успішно створено";
            } else {
                $message = "Не вдалось вставити інформацію про дані";
            }
        } else {
            $message = "Це ім’я користувача вже існує! Будь ласка, спробуйте інший!";
        }
    } else {
        $message = "Всі поля обов'язкові для заповнення!";
    }
}
?>

<?php if (!empty($message)) {
    echo "<p class='error'>" . "ПОВІДОМЛЕННЯ: " . $message . "</p>";
} ?>

