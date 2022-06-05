<?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>
<?php

$usuario = $_SESSION['Usuario'];
if(!isset($usuario)){
    header("Location:$url/account/login.php");
    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>/img/favicon1.ico" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo $url;?>/administrador/css/sb-admin-2.min.css" rel="stylesheet">

    <title>CarpeNovel -- Administrador</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $url;?>/administrador/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Administra<sup>2</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $url;?>/administrador/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url;?>/administrador/seccion/contenido.php" >
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Contenido</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            </br></br></br></br>
            </br></br>
            </br></br></br></br>
            <hr class="sidebar-divider">
            <div class="footer">
                <div>    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url;?>/account/profile/profile.php?txtuser=<?php echo $usuario;?>">
                            <img class="fas fa-fw fa-table"></i>
                            <span><?php echo $usuario; ?></span></a>
                    </li>
                </div>
                <div>    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url;?>/template/inicio/index.php">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Volver al sitio web</span></a>
                    </li>
                </div>
            </div>        
        </ul>
