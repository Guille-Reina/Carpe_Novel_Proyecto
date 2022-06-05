
    <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>

    <nav class="navbar navbar-expand navbar-light bg-light shadow-sm">
        <div class="container px-5">
            <div>
                <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/index.php"> <i class="fas fa-chevron-left"></i> Atras</a>
            </div>
            <div>
                <a class="btn btn-outline-info" href="#" data-toggle="modal" data-target="#miModal">Crear contenido</a>
            </div>
        </div>
    </nav>
    <?php include("modal.php"); ?>

</br>
    

