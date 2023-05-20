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
            <h3>Войти</h3>

            <form class="mt-5" method="POST" action="/auth/login.php">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" name="login" placeholder="Введите логин" value="<?=$_COOKIE["login"]?>">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Войти</button>
                <?php
                    if(!is_null($_POST["submit"]))
                    {
                        $login = Auth::login($_POST["login"], $_POST["password"]);
                        
                        if($login)
                        {
                            setcookie("login", "", time()-3600, "/auth/login.php");
                            header("Location: /");
                            die();

                        } else {
                        ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Ошибка авторизации, попробуйте ещё раз
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