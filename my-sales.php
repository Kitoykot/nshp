<?php
require_once __DIR__ . "/vendor/autoload.php";
session_start();

use App\Auth;
use App\Sale;

if(!Auth::check($_SESSION["id"]))
{
    header("Location: /auth/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "includes/head.php" ?>
<body>
<?php require_once "includes/nav.php" ?>
    <main>
        <div class="container mt-5">
            <?php

                if($_SESSION["error_message"])
                {
                ?>
                    <div class="alert alert-warning" role="alert">
                        <?= $_SESSION["error_message"] ?>
                    </div>               
                <?php
                    unset($_SESSION["error_message"]);
                }


                $sales = Sale::get_userid($_SESSION["id"]);

                if(mysqli_num_rows($sales) > 0)
                {   
                    while($sale = mysqli_fetch_assoc($sales))
                    {
                    ?>
                        <ul class="list-group mb-3">
                            <a href="/one.php?id=<?=$sale["id"]?>" class="list-group-item list-group-item-action">
                                <b><?=$sale["title"]?></b>

                                <form method="POST" action="/my-sales.php" style="float: right;" >
                                    <input type="hidden" name="product_id" value="<?=$sale["id"]?>">
                                    <button class="btn btn-danger" type="submit" name="delete_<?=$sale["id"]?>">Удалить</button>
                                    <?php
                                        if(!is_null($_POST["delete_".$sale["id"]]))
                                        {
                                            Sale::delete($_POST["product_id"]);
                                        }
                                    ?>
                                </form>

                                <form style="float: right; padding-right: 10px;" method="POST" action="/update.php?id=<?=$sale["id"]?>">
                                    <input type="hidden" name="id" value="<?=$sale["id"]?>">
                                    <button class="btn btn-success">Изменить</button>
                                </form>
                                
                                <form method="POST" action="/my-sales.php" style="float: right; padding-right: 10px;">
                                    <input type="hidden" name="product_id" value="<?=$sale["id"]?>">
                                    <button class="btn btn-<?=(int)$sale["public"] === 1 ? "warning" : "primary" ?>" type="submit" name="public_<?=$sale["id"]?>">
                                    <?=(int)$sale["public"] === 1 ? "Снять с публикации" : "Опубликовать" ?>
                                    </button>                                    
                                    <?php
                                        if(!is_null($_POST["public_".$sale["id"]]))
                                        {
                                            Sale::public($_POST["product_id"]);
                                            header("Location: /my-sales.php");
                                            die();
                                        }
                                    ?>
                                </form>
                            </a>
                        </ul>
                    <?php
                    }
                } else {
                    echo "Вы ещё не создали ни одного объявления";
                }
            ?>
        </div>
    </main>
</body>

</html>