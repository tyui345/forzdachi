<?php include("includes/header.php"); 
session_start();

if (isset($_SESSION["session_user"])) {
    // вывод "Session is set"; // в целях проверки
    header("Location: show.php");
}

if (isset($_POST["user"])) {

    if (!empty($_POST['user']) && !empty($_POST['password'])) {
        $user = htmlspecialchars($_POST['user']);
        $password = htmlspecialchars($_POST['password']);
        $query = mysqli_query($con, "SELECT * FROM client WHERE user='" . $user . "' AND password='" . $password . "'");
        $numrows = mysqli_num_rows($query);
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $dbuser = $row['user'];
                $dbpassword = $row['password'];
            }
            if ($user == $dbuser && $password == $dbpassword) {
                // старое место расположения
                //  session_start();
                $_SESSION['session_user'] = $user;
                /* Перенаправление браузера */
                header("Location: show.php");
            }
        } else {
            //  $message = "Invalid user or password!";

            echo "Invalid user or password!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<?php include("includes/footer.php"); ?>
<div class="container mlogin">
    <div id="login">
        <h1>Вхід</h1>
        <form action="" id="loginform" method="post" name="loginform">
            <p><label for="user_login">Ім'я користувача <input class="input" name="user" type="text" value="<?php
            if (isset($user) && preg_match($user, "#^[aA-zZ0-9\-_]+$#")) {
                echo $user;
            } else {
                echo "";
            } ?>"></label></p>
            <p><label for="user_pass">Пароль<input class="input" name="password" type="password" value="<?php   
            if (isset($password) && filter_var($password, FILTER_VALIDATE_INT)) {
                    echo $password;
                } else {
                    echo "";
                } ?>"></label></p>
            <p class="submit"><input class="button" name="login" type="submit" value="Увійти"></p>
            <p class="regtext">Ще не зареєстровані?<a href="register.php">Реєстрація</a>!</p>
        </form>
    </div>
</div>

