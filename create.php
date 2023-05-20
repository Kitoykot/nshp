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
            <h3>Создать объявление</h3>

            <form class="mt-5" method="POST" action="/create.php" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" name="title" placeholder="Видеокарта GTX 1060" value="<?=$_COOKIE["title"]?>">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" rows="10" name="description" placeholder="Исправная карта, почищена от пыли"><?=$_COOKIE["description"]?></textarea>
                </div>

                <label for="category_id">Категория</label>
                <div class="form-group">
                    <select class="form-control" name="category_id">
                        <?php
                            $categories = Category::get();

                            while($category = mysqli_fetch_assoc($categories))
                            {
                            ?>
                                <option value="<?=$category["id"]?>"><?=$category["title"]?></option>
                            <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Цена в рублях</label>
                    <input type="number" class="form-control" name="price" placeholder="10000" value="<?=$_COOKIE["price"]?>">
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" class="form-control-file" name="image">
                </div>

                <button type="submit" class="btn btn-success" name="submit">Создать объявление</button>
                <?php
                    if(!is_null($_POST["submit"]))
                    {
                        $create = Sale::create($_POST, $_POST["title"], $_POST["description"], $_POST["category_id"],
                                                $_POST["price"], $_FILES["image"], $_SESSION["id"]);

                        if($create)
                        {
                            header("Location: /my-sales.php");
                            die();

                        } else {
                        ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Ошибка при создании объявления, попробуйте ещё раз
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