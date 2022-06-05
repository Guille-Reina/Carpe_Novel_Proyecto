<?php 
session_start();
include("../../administrador/config/bd.php");
if(!empty($_SESSION['Usuario'])){
$usuario = $_SESSION['Usuario'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>/img/favicon.ico" />
    <link href="<?php echo $url;?>/administrador/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1.7.3/glider.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $url;?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>CarpeNovel</title>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>

</head>
<body>
    <div class="header">
    <nav class="navbar navbar-expand navbar-light bg-light shadow-sm ">
        <ul class="container px-5" style="list-style: none;">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/template/inicio/index.php">
                <img class="nav-link" src="<?php echo $url;?>/img/favicon.ico"  width="90px"/>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/template/category/categorias.php">Categorías</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/template/ranking/ranking.php">Ranking</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/contenido.php">Crear</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/template/inicio/search.php">Buscador</a>
            </li>
            <?php

                if(!empty($_SESSION['signed_in'])){

                    include("profile_layout.php");

                }else{
                    echo '<a href="../../account/login.php">Login</a> or <a href="../../account/register.php">Registrarse</a>.';
                }
            ?>
        </ul>
    </nav>
    <div>



    <div class="container">


        <div class="row">