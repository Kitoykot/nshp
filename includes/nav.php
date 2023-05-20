<?php
require_once __DIR__ . "/../vendor/autoload.php";
session_start();

use App\Auth;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/"><span class="largeN">N</span>aruto`s <span class="largeS">S</span>tore</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Поиск</a>
                    </li>
                    <?php
                        if(Auth::check($_SESSION["id"]))
                        {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/create.php">Создать объявление</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/my-sales.php">Мои объявления</a>
                            </li>
                        <?
                        }
                    ?>
                </ul>
                    
                <?php
                    if(!Auth::check($_SESSION["id"]))
                    {
                    ?>
                        <a class="nav-link" href="/auth/register.php">Регистрация</a>
                        <a class="nav-link" href="/auth/login.php">Войти</a>
                    <?php
                    }

                    if(Auth::check($_SESSION["id"]))
                    {
                    ?>
                        <a class="nav-item"><?=$_SESSION["name"]?></a>
                        <a class="nav-link" href="/actions/logout.php">Выйти</a>
                    <?php
                    }
                ?>
            </div>
        </div>
</nav>