<?php

$sentenciaSQL2= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario=:usuario");
$sentenciaSQL2->bindParam(':usuario',$usuario);
$sentenciaSQL2->execute();
$perfil=$sentenciaSQL2->fetch(PDO::FETCH_LAZY);

$img = $perfil['Picture']


?>


<div class="topbar-divider d-none d-sm-block"></div>

    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" width="30" src="<?php echo $url;?>/img/contenido/<?php echo $img ?>">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $usuario;?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?php echo $url;?>/account/profile/profile.php?txtuser=<?php echo $usuario;?>">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil
            </a>
            <a class="dropdown-item" href="<?php echo $url;?>/account/profile/library.php">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Biblioteca
            </a>
            <a class="dropdown-item" href="<?php echo $url;?>/account/profile/setting.php">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Ajuste
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
            </a>
        </div>
    </li>


    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo $url;?>/template/cerrar.php">Logout</a>
                </div>
            </div>
        </div>
    </div>