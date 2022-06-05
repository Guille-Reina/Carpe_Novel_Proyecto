<?php include ("../../template/layout.php"); 

include ("../../administrador/config/bd.php");

$usuario = $_SESSION['Usuario'];

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido, fav WHERE contenido.id= fav.ID_content and fav.usuario = :usuario");
$sentenciaSQL->bindParam(':usuario',$usuario);
$sentenciaSQL->execute();
$listalibrary=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if($accion == "eliminar"){
    $txtid_chapter =(isset($_POST['txtid_content']))?$_POST['txtid_content']:"";
    $sentenciaSQL= $conexion->prepare("DELETE FROM fav WHERE ID_content=:id");
    $sentenciaSQL->bindParam(':id',$txtid_chapter);
    $sentenciaSQL->execute();
    
}

?>


    <?php foreach($listalibrary as $library) { ?>
    <div class='col-md-2'>
    <br/><br/>
        <div class="card">
            <img class="card-img-top" src="<?php echo $url;?>/img/contenido/<?php echo $library['Image'] ?>">
            <div class="card-body">
                <p class="card-title"><?php echo $library['Title'] ?></p>
                <div class="row">
                    <div class="col-6">
                        <a href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $library['ID']; ?>"><button  class="btn btn-primary">Ver</button></a>
                    </div>
                    <div class="col-6">
                        <form method="POST">    
                            <input type="hidden" name="txtid_content" value="<?php echo $library['ID']; ?>" />
                            <button type="submit" name="accion" class="btn btn-danger" value="eliminar">
                                <i class="fas fa-fw fa-ban"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


<?php include ("../../template/footer.php"); ?>