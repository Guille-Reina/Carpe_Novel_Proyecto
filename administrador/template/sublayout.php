<?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>
</br>

    <nav class="navbar navbar-expand navbar-light bg-light shadow-sm">
        <div class="container px-5">
        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/contenido.php"> <i class="fas fa-chevron-left"></i> Atras</a>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a href="<?php echo $url;?>/administrador/seccion/mistake.php?txtid=<?php echo $txtid;?>"><button type="button" class="btn btn-outline-danger">Errores</button></a>
            </div>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a href="<?php echo $url;?>/administrador/seccion/make_comic.php?txtid=<?php echo $txtid;?>"><button type="button" class="btn btn-outline-info">Capítulo Comic</button></a>
                <a href="<?php echo $url;?>/administrador/seccion/make_novela.php?txtid=<?php echo $txtid;?>"><button type="button" class="btn btn-outline-info">Capítulo Novela</button></a>
            </div>
        </div>
    </nav>