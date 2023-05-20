<?php
require_once __DIR__ . "/../vendor/autoload.php";
session_start();

use App\Auth;

if(Auth::check($_SESSION["id"]))
{
    header("Location: /");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "../includes/head.php" ?>
<body>
<?php require_once "../includes/nav.php" ?>

    <main>
        <div class="container mt-5">
            <h3>Создать учётную запись</h3>

            <form method="POST" action="/auth/register.php" class="mt-5">
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" name="name" placeholder="Иван" value="<?=$_COOKIE["name"]?>">
                </div>
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" class="form-control" name="email" placeholder="example@gmail.com" value="<?=$_COOKIE["email"]?>">
                </div>
                <div class="form-group">
                    <label for="phone">Номер телефона</label>
                    <input type="number" class="form-control" name="phone" placeholder="89000000000" value="<?=$_COOKIE["phone"]?>">
                </div>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" name="login" placeholder="Уникальное имя" value="<?=$_COOKIE["login"]?>">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="password-confirm">Подтверждение пароля</label>
                    <input type="password" class="form-control" name="password-confirm">
                </div>
                <button type="submit" class="btn btn-success" name="submit">Создать аккаунт</button>
                <?php
                    if(!is_null($_POST["submit"]))
                    {
                        $reg = Auth::reg($_POST, $_POST["name"], $_POST["email"], $_POST["phone"],
                                $_POST["login"], $_POST["password"], $_POST["password-confirm"]);
                        
                        if($reg)
                        {
                            setcookie("name", "", time()-3600, "/auth/register.php");
                            setcookie("email", "", time()-3600, "/auth/register.php");
                            setcookie("phone", "", time()-3600, "/auth/register.php");
                            setcookie("login", "", time()-3600, "/auth/register.php");
                            setcookie("password", "", time()-3600, "/auth/register.php");
                            setcookie("password-confirm", "", time()-3600, "/auth/register.php");

                            header("Location: /auth/login.php");
                            die();

                        } else {
                        ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Ошибка при регистрации, попробуйте ещё раз
                            </div>
                        <?php
                        }
                    }

                    if($_SESSION["error_message"])
                    {
                    ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <?=$_SESSION["error_message"]?>
                        </div>
                    <?php
                        unset($_SESSION["error_message"]);
                    }
                ?>
            </form>
        </div>
    </main>
</body>

</html>