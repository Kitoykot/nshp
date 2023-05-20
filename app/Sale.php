<?php

namespace App;
session_start();

class Sale extends Connect
{
    public static function create($post, $title, $description, $category_id, $price, $image, $user_id)
    {
        foreach($post as $key => $value)
        {
            $value = htmlspecialchars($value);
            $value = trim($value);
            $value = preg_replace("#\s{2,}#", " ", $value);

            setcookie($key, $value, time()+9999, "/create.php");
        }

        $title = htmlspecialchars($title);
        $title = trim($title);
        $title = preg_replace("#\s{2,}#", " ", $title);

        $description = htmlspecialchars($description);
        $description = trim($description);
        $description = preg_replace("#\s{2,}#", " ", $description);

        $category_id = htmlspecialchars($category_id);

        $price = htmlspecialchars($price);
        $price = trim($price);
        $price = preg_replace("#\s{2,}#", "", $price);

        $user_id = htmlspecialchars($user_id);

        if($title === "" || $description === "" || $price === "")
        {
            $_SESSION["error_message"] = "Пожалуйста, заполните все поля";
            header("Location: /create.php");
            die();
        }

        if($image["name"] === "")
        {
            $_SESSION["error_message"] = "Пожалуйста, прикрепите изображение";
            header("Location: /create.php");
            die();
        }

        if($image["type"] !== "image/png" && $image["type"] !== "image/jpeg" && $image["type"] !== "image/jpg")
        {
            $_SESSION["error_message"] = "Допускаются изображения только формата PNG, JPEG или JPG";
            header("Location: /create.php");
            die();
        }

        $path = "storage/images/" . time() . "_" . $image["name"];

        if(move_uploaded_file($image["tmp_name"],  $path))
        {
            $title = addslashes($title);
            $description = addslashes($description);

            $sql = "INSERT INTO `products` (`title`, `description`, `category_id`, `price`, `image`, `user_id`) 
                    VALUES ('$title', '$description', '$category_id', '$price', '$path', '$user_id')";
            $query = mysqli_query(self::db(), $sql);

        }

        setcookie("title", "", time()-3600, "/create.php");
        setcookie("description", "", time()-3600, "/create.php");
        setcookie("price", "", time()-3600, "/create.php");

        return $query ? true : false;
    }

    public static function get()
    {
        $sql = "SELECT * FROM `products` WHERE `public` = '1' ORDER BY `id`";
        $query = mysqli_query(self::db(), $sql);

        return $query;
    }

    public static function get_one($id)
    {
        $id = htmlspecialchars($id);

        $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_fetch_assoc($query);
    }

    public static function get_userid($user_id)
    {
        $user_id = htmlspecialchars($user_id);

        $sql = "SELECT * FROM `products` WHERE `user_id` = '$user_id'";
        $query = mysqli_query(self::db(), $sql);

        return $query;
    }

    public static function check($id)
    {
        $id = htmlspecialchars($id);

        $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_num_rows($query) > 0;
    }

    public static function check_user($id, $user_id)
    {
        $id = htmlspecialchars($id);
        $user_id = htmlspecialchars($user_id);

        $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);
        $user = mysqli_fetch_assoc($query);

        return $user_id == $user["user_id"];
    }

    public static function public($id)
    {
        $id = htmlspecialchars($id);

        if(!self::check($id))
        {
            $_SESSION["error_message"] = "Ошибка";
            header("Location: /my-sales.php");
            die();
        }

        $sale = self::get_one($id);
        $public = $sale["public"];

        $public = (int)$public === 1 ? 0 : 1;

        $sql = "UPDATE `products` SET `public` = '$public' WHERE `products`.`id` = '$id'";
        $public = mysqli_query(self::db(), $sql);

        return $public ? true : false;
    }

    public static function check_public($id)
    {
        $id = htmlspecialchars($id);

        $sql = "SELECT * FROM `products` WHERE `public` = '1' AND `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_num_rows($query) > 0;
    }

    public static function delete($id)
    {
        $id = htmlspecialchars($id);

        if(!self::check($id))
        {
            $_SESSION["error_message"] = "Ошибка при удалении";
            header("Location: /my-sales.php");
            die();
        }

        $sale = self::get_one($id);
        $image = $sale["image"];

        if(!unlink($image))
        {
            $_SESSION["error_message"] = "Ошибка при удалении";
            header("Location: /my-sales.php");
            die();
        }

        $sql = "DELETE FROM `products` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        if($query)
        {
            header("Location: /my-sales.php");
            die();

        } else {
            
            $_SESSION["error_message"] = "Ошибка при удалении";
            header("Location: /my-sales.php");
            die();
        }
    }

    public static function update($id, $title, $description, $category_id, $price, $image, $old_image)
    {
        $new_image = false;
        $path = "";

        $id = htmlspecialchars($id);
        $id = trim($id);
        $id = preg_replace("#\s{2,}#", " ", $id);

        $title = htmlspecialchars($title);
        $title = trim($title);
        $title = preg_replace("#\s{2,}#", " ", $title);

        $description = htmlspecialchars($description);
        $description = trim($description);
        $description = preg_replace("#\s{2,}#", " ", $description);

        $category_id = htmlspecialchars($category_id);

        $price = htmlspecialchars($price);
        $price = trim($price);
        $price = preg_replace("#\s{2,}#", "", $price);

        $old_image = htmlspecialchars($old_image);
        $old_image = trim($old_image);
        $old_image = preg_replace("#\s{2,}#", "", $old_image);
       
        if($title === "" || $description === "" || $price === "")
        {
            $_SESSION["error_message"] = "Пожалуйста, заполните все поля";
            header("Location: /update.php?id=".$id);
            die();
        }

        $path = "storage/images/" . time() . "_" . $image["name"];

        if(move_uploaded_file($image["tmp_name"], $path))
        {
            $new_image = true;

            if($image["type"] !== "image/png" && $image["type"] !== "image/jpeg" && $image["type"] !== "image/jpg")
            {
                $_SESSION["error_message"] = "Допускаются изображения только формата PNG, JPEG или JPG";
                header("Location: /update.php?id=".$id);
                die();
            }

            $find_image = self::get_one($id);
            
            if(!unlink($find_image["image"]))
            {
                $_SESSION["error_message"] = "Ошибка при обновлении изображения";
                header("Location: /update.php?id=".$id);
                die();
            }
        }

        if(!$new_image)
        {
            $path = $old_image;
        }

        $sql = "UPDATE `products` SET `title` = '$title', `description` = '$description', `category_id` = '$category_id', `price` = '$price', `image` = '$path' WHERE `id` = '$id'";

        $query = mysqli_query(self::db(), $sql);

        if($query)
        {
            header("Location: /my-sales.php");
            die();

        } else {

            $_SESSION["error_message"] = "Ошибка при обновлении, попробуйте ещё раз";
            header("Location: /update.php?id=".$id);
            die();
        }
    }

    public static function search($q)
    {
        $q = htmlspecialchars($q);

        $sql = "SELECT * FROM `products` WHERE `title` LIKE '%$q%' OR `description` LIKE '%$q%' AND `public` = '1' ORDER BY `id` DESC";
        $query = mysqli_query(self::db(), $sql);

        return $query;
    }
}