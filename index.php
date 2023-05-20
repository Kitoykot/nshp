<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Sale;
use App\Category;

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "includes/head.php" ?>
<body>
<?php require_once "includes/nav.php" ?>
    <main>
        <div class="container mt-5">
            <h3>Поиск</h3>

            <form method="GET" action="/">
                <div class="searchClass form-group mt-5">
                    <label for="exampleInputEmail1">Что будем искать?</label>
                    <input type="search" class="searchInput form-control" name="q"  placeholder="ЖК телевизор">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </form>

            <div class="content mt-5 mb-4">
                <?php

                    if($_GET["q"])
                    {
                        $sales_search = Sale::search($_GET["q"]);

                        if(mysqli_num_rows($sales_search) < 1)
                        {
                            die("Ничего не нашлось");
                        }

                        while($sale_search = mysqli_fetch_assoc($sales_search))
                        {
                        ?>
                            <div class="sale">
                                <img src="<?=$sale_search["image"]?>" width="200">
                                <h6 class="title mt-2"><?=$sale_search["title"]?></h6>
                                <p class="category">Категория: <?=Category::get_one($sale_search["category_id"])?></p>
                                <p class="price">Цена: <?=$sale_search["price"]?> рублей</p>
                                <a class="mt-5" href="one.php?id=<?=$sale_search["id"]?>">Открыть</a>
                            </div>
                        <?php
                        }
                        die();               
                    }

                    $sales = Sale::get();
                    $sale = [];

                    foreach ($sales as $row)
                    {
                        $sale[] = $row;
                    }
                    
                    $page = $_GET["page"];
                    $count = 12;
                    $page_count = ceil(count($sale)) / $count;

                    for($i = $page*$count; $i < ($page+1)*$count; $i++)
                    {   
                        if(!is_null($sale[$i]["id"]))
                        {
                        ?>
                            <div class="sale">
                                <img src="<?=$sale[$i]["image"]?>" width="200">
                                <h6 class="title mt-2"><?=$sale[$i]["title"]?></h6>
                                <p class="category">Категория: <?=Category::get_one($sale[$i]["category_id"])?></p>
                                <p class="price">Цена: <?=$sale[$i]["price"]?> рублей</p>
                                <a class="mt-5" href="one.php?id=<?=$sale[$i]["id"]?>">Открыть</a>
                            </div>
                        <?php
                        }
                    }
                ?>
            </div>

            <?php
                if(mysqli_num_rows($sales) > 12)
                {
                ?>
                    <div class="page-list">
                        <?php
                            for($p = 0; $p < $page_count; $p++)
                            {
                            ?>
                                <a class="btn btn-outline-primary mb-5" href="/?page=<?=$p?>" role="button"><?=$p+1?></a>
                            <?php
                            }
                        ?>
                    </div>
                <?php
                }
            ?>
        </div>
    </main>
</body>

</html>