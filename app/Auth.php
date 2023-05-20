<?php

namespace App;
session_start();

class Auth extends Connect
{
    public static function reg($post, $name, $email, $phone, $login, $password, $password_confirm)
    {
        foreach($post as $key => $value)
        {
            $value = htmlspecialchars($value);
            $value = trim($value);
            $value = preg_replace("#\s{1,}#", "", $value);

            setcookie($key, $value, time()+9999, "/auth/register.php");
        }

        $name = htmlspecialchars($name);
        $name = trim($name);
        $name = preg_replace("#\s{1,}#", "", $name);

        $email = htmlspecialchars($email);
        $email = trim($email);
        $email = preg_replace("#\s{1,}#", "", $email);

        $phone = htmlspecialchars($phone);
        $phone = trim($phone);
        $phone = preg_replace("#\s{1,}#", "", $phone);

        $login = htmlspecialchars($login);
        $login = trim($login);
        $login = preg_replace("#\s{1,}#", "", $login);

        $password = htmlspecialchars($password);
        $password = trim($password);
        $password = preg_replace("#\s{1,}#", "", $password);

        $password_confirm = htmlspecialchars($password_confirm);
        $password_confirm = trim($password_confirm);
        $password_confirm = preg_replace("#\s{1,}#", "", $password_confirm);

        if($name === "" || $email === "" || $phone === "" ||
            $login === "" || $password === "" || $password_confirm === "")
            {
               $_SESSION["error_message"] = "Пожалуйста, заполните все поля";
               header("Location: /auth/register.php");
               die();
            }
        
        $sql_find = "SELECT * FROM `users`";
        $query_find = mysqli_query(self::db(), $sql_find);
        $user = mysqli_fetch_assoc($query_find);

        if($email === $user["email"])
        {
            $_SESSION["error_message"] = "Пользователь с таким email уже существует";
            header("Location: /auth/register.php");
            die();
        }

        if($phone === $user["phone"])
        {
            $_SESSION["error_message"] = "Пользователь с таким телефоном уже существует";
            header("Location: /auth/register.php");
            die();
        }

        if($login === $user["login"])
        {
            $_SESSION["error_message"] = "Пользователь с таким логином уже существует";
            header("Location: /auth/register.php");
            die();
        }
        
        if($password !== $password_confirm)
        {
            $_SESSION["error_message"] = "Пароли не совпадают";
            header("Location: /auth/register.php");
            die();
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`name`, `email`, `phone`, `login`, `password`) 
                VALUES ('$name', '$email', '$phone', '$login', '$hash')";
        $query = mysqli_query(self::db(), $sql);

        return $query ? true : false;
    }

    public static function login($login, $password)
    {
        $login = htmlspecialchars($login);
        $login = trim($login);
        $login = preg_replace("#\s{1,}#", "", $login);

        $password = htmlspecialchars($password);
        $password = trim($password);
        $password = preg_replace("#\s{1,}#", "", $password);

        setcookie("login", $login, time()+9999, "/auth/login.php");

        $sql_find = "SELECT * FROM `users` WHERE `login` = '$login'";
        $query_find = mysqli_query(self::db(), $sql_find);
        $count_user = mysqli_num_rows($query_find);

        if($count_user !== 1)
        {
            $_SESSION["error_message"] = "Неверный логин или пароль";
            header("Location: /auth/login.php");
            die();   
        }

        $user = mysqli_fetch_assoc($query_find);

        $result = password_verify($password, $user["password"]);

        if($result)
        {
            $_SESSION["id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["login"] = $user["login"];

            return true;

        } else {

            $_SESSION["error_message"] = "Неверный логин или пароль";
            header("Location: /auth/login.php");
            die();
        }
    }

    public static function logout()
    {
        unset($_SESSION["id"]);
        unset($_SESSION["name"]);
        unset($_SESSION["login"]);
        session_destroy();
    }

    public static function check($id)
    {
        $id = htmlspecialchars($id);

        $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);
        $count = mysqli_num_rows($query);

        return $count > 0;
    }

    public static function get($id)
    {
        $id = htmlspecialchars($id);

        $sql = "SELECT `email`, `phone` FROM `users` WHERE `id` = '$id'";
        $query = mysqli_query(self::db(), $sql);

        return mysqli_fetch_assoc($query);
    }
}