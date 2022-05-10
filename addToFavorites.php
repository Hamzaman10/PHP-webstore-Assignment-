<?php
session_start();

if (empty($_SESSION['favorite'])){
    $_SESSION['favorite'] = array();
}

if ( isset($_GET['id']) && isset($_GET['file']) && isset($_GET['title']) ) {
    $id = $_GET['id'];
    $file =$_GET['file'];
    $title =$_GET['title'];
    $favorite =array($_GET['id'], $_GET['file'],$_GET['title']);
    array_push($_SESSION['favorite'], $favorite);
    header("Location: view-favorites.php");
}
