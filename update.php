<?php
require_once __DIR__ . "/vendor/autoload.php";
session_start();

use App\Auth;
use App\Category;
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
                $sale = Sale::get_one($_GET["id"]);
                
                if(!Sale::check_user($_GET["id"], $_SESSION["id"]))
                {
                    die("У вас недостаточно прав");
                }

                if(!Sale::check($sale["id"]))
                {
                    die("Такого объявления нет");
                }

                if($_SESSION["error_message"])
                {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$_SESSION["error_message"]?>
                    </div>
                <?php
                    unset($_SESSION["error_message"]);
                }
            ?>

            <h3>Обновить: <?=$sale["title"]?></h3>
            <form class="mt-5" method="POST" action="/update.php?id=<?=$sale["id"]?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$sale["id"]?>">
                <input type="hidden" name="old_image" value="<?=$sale["image"]?>">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" name="title" placeholder="Видеокарта GTX 1060" value="<?=$sale["title"]?>">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" rows="10" name="description" placeholder="Исправная карта, почищена от пыли"><?=$sale["description"]?></textarea>
                </div>

                <label for="category_id">Категория</label>
                <div class="form-group">
                    <select class="form-control" name="category_id">
                        <?php
                            $sale_category = Category::get_one($sale["category_id"]);
                        ?>
                        <option value="<?=$sale["category_id"]?>"><?=$sale_category?></option>
                        <?php
                            $categories = Category::get();

                            while($category = mysqli_fetch_assoc($categories))
                            {
                                if($category["title"] !== $sale_category)
                                {
                                ?>
                                    <option value="<?=$category["id"]?>"><?=$category["title"]?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Цена в рублях</label>
                    <input type="number" class="form-control" name="price" placeholder="10000" value="<?=$sale["price"]?>">
                </div>

                <div class="form-group">
                    <label class="mb-2" for="image">Изображение</label>
                    <br>
                    <img class="mb-3" src="<?=$sale["image"]?>" width="250">
                    <input type="file" class="form-control-file" name="image">
                </div>

                <button type="submit" class="btn btn-success mb-5" name="submit">Обновить</button>
                
                <?php
                    if(!is_null($_POST["submit"]))
                    {
                        Sale::update($_POST["id"], $_POST["title"], $_POST["description"], $_POST["category_id"],
                                    $_POST["price"], $_FILES["image"], $_POST["old_image"]);
                    }
                ?>
            </form>
        </div>
    </main>
</body>

</html>