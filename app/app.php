<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";

    $server= "mysql:host=localhost:8889;dbname=library";
    $username="root";
    $password="root";
    $DB= new PDO($server, $username, $password);

    $app= new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(                          'twig.path'=>__DIR__."/../views"
    ));




    return $app;
?>
