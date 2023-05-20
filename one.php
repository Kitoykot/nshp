<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Sale;
use App\Category;
use App\Auth;

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "includes/head.php" ?>
<body>
<?php require_once "includes/nav.php" ?>

    <main>
        <div class="container mt-5">
        <?php
            $sale = Sale::get_one($_GET["id"]);

            if(!Sale::check($sale["id"]))
            {
                die("Такого объявления нет");
            }
        ?>

        <?php
            if(!Sale::check_public($sale["id"]))
            {
                die("Объявление сейчас недоступно");
            }
        ?>

            <h3><?=$sale["title"]?></h3>
            <div class="saleOne mt-5">
                <img src="<?=$sale["image"]?>" width="500">
                <div class="infoOne mt-3 pl-3">
                    <p class="descriptionOne"><?=$sale["description"]?></p>
                    <h6>Категория: <?=Category::get_one($sale["category_id"])?></h6>
                    <h3 class="priceOne">Цена: <?=$sale["price"]?> рублей</h3>
                    <h4 class="contactsOne">Контакты:</h4>
                    <h6>Телефон: <?=Auth::get($sale["user_id"])["phone"]?> | E-mail: <?=Auth::get($sale["user_id"])["email"]?></h6>
                </div>
            </div>
        </div>
    </main>
</body>

</html>