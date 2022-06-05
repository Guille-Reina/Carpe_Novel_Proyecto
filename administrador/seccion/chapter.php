<?php

include("../config/bd.php");

include ("../../template/layout.php");

$txtid = $_GET['txtid'];

$usuario = $_SESSION['Usuario'];

$sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Chapter=:id");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();
$listacapitulo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

$tipo = $listacapitulo['Tipo'];
$idcontenido = $listacapitulo['ID_Content'];

$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE ID=:id");
$sentenciaSQL->bindParam(':id',$idcontenido);
$sentenciaSQL->execute();
$contenido=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

$titlecontent = $contenido['Title'];

$sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Content=:id AND Tipo=:tipo ORDER BY Orden ASC");
$sentenciaSQL->bindParam(':id',$idcontenido);
$sentenciaSQL->bindParam(':tipo',$tipo);
$sentenciaSQL->execute();
$listacapitulos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$txtusuario=(isset($_POST['txtusuario']))?$_POST['txtusuario']:"";
$text=(isset($_POST['contenido']))?$_POST['contenido']:"";

if($accion == "Enviar"){
    $sentenciaSQL= $conexion->prepare("INSERT INTO content_error (ID_Content, Chapter, Contenido, Usuario, Fecha) VALUES (:id, :txtitulo, :txt, :usuario, NOW() );");
    $sentenciaSQL->bindParam(':id',$idcontenido);
    $sentenciaSQL->bindParam(':txt',$text);
    $sentenciaSQL->bindParam(':txtitulo',$txtusuario);
    $sentenciaSQL->bindParam(':usuario',$usuario);
    $sentenciaSQL->execute();
    $mensaje ='Error enviado';  
}

?>
<div class="col-12">
<br/>  
    <nav class="navbar navbar-expand ">
        <ul class="container px-5" style="list-style: none;">
            <div>
                <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $idcontenido; ?>"> <i class="fas fa-chevron-left"></i>  <?php echo $titlecontent; ?></a>
            </div>
            <div>
                <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#miModal">Modo Editor</a>
            </div>
        </div>
    </nav>
</div>
<div class="col-9">
<br/>  
    <nav class="navbar navbar-expand ">
        <ul class="container px-5" style="list-style: none;">
            <div>
                <p><?php echo $listacapitulo['Title']; ?></p>            
            </div>
        </div>
    </nav>
</div>
<div class ="row justify-content-center">

<div class="col-8">
    <table class="table table">
    <tbody>
            <tr  rowspan="2">
                <p class="text-justify"><?php echo $listacapitulo['Contenido']; ?></p>
                <br/><br/><br/>
            </tr>
            <?php 

                $sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Content=:id AND Tipo=:tipo order by orden");
                $sentenciaSQL->bindParam(':id',$idcontenido);
                $sentenciaSQL->bindParam(':tipo',$tipo);
                $sentenciaSQL->execute();
                $listamovida=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                //$txtidchapter = $listamovida['ID_Chapter'];
                $x=0;
                $capitulo=0;
                foreach($listamovida as $contenido) { 
                    if ($contenido['ID_Chapter']==$txtid){ $capitulo=$x;}
                    $x=$x+1;
                }

            ?>
            <tr>
                <div class ="row justify-content-center">
                <form method="POST">
                    <div class="col-4">
                        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/chapter.php?txtid=<?php echo $listamovida[$capitulo-1]["ID_Chapter"];?>"> <i class="fas fa-chevron-left"></i> Capítulo Anterior</a>
                    </div>
                    <div class="col-4">
                        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $idcontenido; ?>"> <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Indice</a>
                    </div>
                    <div class="col-4">
                        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/chapter.php?txtid=<?php echo $listamovida[$capitulo+1]["ID_Chapter"]; ?>"> Capítulo Siguiente  <i class="fas fa-chevron-right"></i></a>
                    </div>
                </form>
                </div>
            </tr>
            <tr>
            <br/><br/>
                <div class="row justify-content-center">
                    <label for="txtSubType">Saltar:</label>
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option> --- </option>
                        <?php foreach($listacapitulos as $todochapter) { ?>   
                        <option value="<?php echo $url;?>/administrador/seccion/chapter.php?txtid=<?php echo $todochapter['ID_Chapter']; ?>"><?php echo $todochapter['Title']; ?>">
                            <div class="row">
                                <div class="col-6">
                                    <a </a>
                                <div>
                                <div class="col-6">
                                    <?php echo $todochapter['Fecha']; ?>
                                <div>
                            </div>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            <br/><br/>
            </tr>
        </tbody>
    </table> 
</div>
</div>
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <form method="POST" enctype="multipart/form-data">    
    <div class="modal-header">
        <h5 class="modal-title">Envia el error encontrado</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class = "form-group">
          <input type="hidden" required readonly class="form-control" value="<?php echo $txtid; ?>" name="txtID" id="txtID" placeholder="ID">
        </div>
        <?php if(isset($mensaje)) { ?>
        <div class="alert alert-success" role="alert">
            <a href="#" class="alert-link"><?php echo $mensaje; ?></a>.
        </div>
        <?php } ?>
        <div class = "form-group">
          <label for="txtTitulo">Localizado:</label>
          <input type="disable" required class="form-control" value="<?php echo $listacapitulo['Title']; ?>" name="txtusuario">
        </div>
        <div class = "form-group">
          <label for="txtTitulo">Detalles del error:</label>
          <textarea type="text" required class="form-control" rows="3" name="contenido" placeholder="Error encontrado"></textarea>
        </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
        <button type="submit" name="accion" value="Enviar" class="btn btn-success">Enviar</button>
      </div>
    </form>  
    </div>
  </div>
</div>



<?php include("../template/footer.php"); ?>
