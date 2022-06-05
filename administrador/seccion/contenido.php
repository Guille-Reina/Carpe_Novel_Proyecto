<?php

session_start();


$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtTitulo=(isset($_POST['txtTitulo']))?$_POST['txtTitulo']:"";
$txtSubType=(isset($_POST['txtSubType']))?$_POST['txtSubType']:"";

$lenguage=(isset($_POST['lenguage']))?$_POST['lenguage']:"";
$sinopsis=(isset($_POST['sinopsis']))?$_POST['sinopsis']:"";

$lenguage=(isset($_POST['lenguage']))?$_POST['lenguage']:"";
$sinopsis=(isset($_POST['sinopsis']))?$_POST['sinopsis']:"";
$categorya=(isset($_POST['txtcategory']))?$_POST['txtcategory']:"";



$usuario = $_SESSION['Usuario'];
$img_portada=(isset($_FILES['img_portada']['name']))?$_FILES['img_portada']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){
    case "Agregar":
        $txtStatus = "Publicándose";
        $sentenciaSQL= $conexion->prepare("INSERT INTO `contenido` (`Title`, `Published Date`, `Image`, `Sinopsis`, `SubTipo`, `Status`, `Language`, `Categoria`, `Author`) VALUES (:titulo, NOW(), :imagen, :sinopsis, :subtipo, :statu, :languaje, :categorya, :author);");
        $sentenciaSQL->bindParam(':titulo',$txtTitulo);
        $sentenciaSQL->bindParam(':subtipo',$txtSubType);
        $sentenciaSQL->bindParam(':statu',$txtStatus);
        $sentenciaSQL->bindParam(':languaje',$lenguage);
        $sentenciaSQL->bindParam(':sinopsis',$sinopsis);
        $sentenciaSQL->bindParam(':categorya',$categorya);
        $sentenciaSQL->bindParam(':author',$usuario);

        $fecha= new Datetime();
        $nombreArchivo =($img_portada!="")?$fecha->getTimestamp()."_".$_FILES["img_portada"]["name"]:"portada.png";
        
        $tmpImagen=$_FILES["img_portada"]["tmp_name"];
        
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/contenido/".$nombreArchivo);
        }else {

        }
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:contenido.php");

        break;

    case "Cancelar":
        header("Location:contenido.php");
        break;    
    case "Borrar":
        $sentenciaSQL= $conexion->prepare("SELECT Image FROM contenido WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $contenido=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if( isset($contenido["Image"]) &&($contenido["Image"]!="imagen.jpg")){
            if(file_exists("../../img/contenido/".$contenido["Image"])){
                unlink("../../img/contenido/".$contenido["Image"]);
            }

        }

        $sentenciaSQL= $conexion->prepare("DELETE FROM contenido WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        header("Location:contenido.php");
        break; 
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE Author=:usuario");
$sentenciaSQL->bindParam(':usuario',$usuario);
$sentenciaSQL->execute();
$listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include("../template/dashboard.php"); ?>



<div class="col-9">
<?php include("../template/layout.php"); ?>
    <table class="table table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fechas</th>
                <th>Colecciones</th>
                <th>Operaciones</th>
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
                <td>
                    <a href="<?php echo $url;?>/administrador/seccion/information.php?txtid=<?php echo $contenido['ID']; ?>"><button class="btn btn-success">Explorar</button></a>
                    <form method="POST">    
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $contenido['ID']; ?>" />
                        <button type="submit" name="accion" class="btn btn-danger" value="Borrar">
                            <i class="fas fa-fw fa-ban"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table> 
</div>



<?php include("../template/footer.php"); ?>
