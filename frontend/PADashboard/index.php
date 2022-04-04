<?php

require 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(getcwd() . '\templates');

$twig = new \Twig\Environment($loader);




try {
    $index = $twig->load('index.twig');
    echo $index->render(['pageTitle' => 'Hans Burger']);
} catch (\Twig\Error\LoaderError $e) {
    var_dump($e);
} catch (\Twig\Error\RuntimeError $e) {
    var_dump($e);
} catch (\Twig\Error\SyntaxError $e) {
    var_dump($e);
}