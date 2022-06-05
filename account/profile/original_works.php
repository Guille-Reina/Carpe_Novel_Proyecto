<?php

include ("../../administrador/config/bd.php");
$user = $_GET['txtuser'];;

$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE Author=:usuario");
$sentenciaSQL->bindParam(':usuario',$user);
$sentenciaSQL->execute();
$listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);




?>

<div class="col-9">
    <table class="table table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Colecciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listacontenido as $contenido) { ?>   
            <tr>
                <td>          
                    <img src="../../img/contenido/<?php echo $contenido['Image']; ?>" width="50" alt="">            
                    <?php echo $contenido['Title']; ?>
                </td>
                <td><?php echo $contenido['Published Date']; ?></td>
                <td><?php 
                        $id = $contenido['ID'];
                        $sentenciaSQL= $conexion->prepare("SELECT COUNT(*) FROM fav WHERE ID_content=:id");
                        $sentenciaSQL->bindParam(':id', $id);
                        $sentenciaSQL->execute();
                        $numfav=$sentenciaSQL->fetch(PDO::FETCH_BOTH);
                        echo $numfav[0]; 
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table> 
</div>

