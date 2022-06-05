<?php include ("../layout.php"); ?>
<?php



$sentenciaSQL= $conexion->prepare("SELECT * FROM categorias");
$sentenciaSQL->execute();
$listacategorias=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);



if(isset($_GET['txtcategory'])){
  $txtcategory=$_GET['txtcategory'];
  $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE Categoria=:category");
  $sentenciaSQL->bindParam(':category',$txtcategory);
  $sentenciaSQL->execute();
  $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
 } else {

  $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido");
  $sentenciaSQL->execute();
  $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

 }

?>

<div class="col-10">
<br/><br/>
<div class="col-12">    
    <div>
        <form>
            <div class="align-center">
                <fieldset class="Categoría">
                  <form method="POST">    
                  <?php foreach($listacategorias as $listacategoria) { ?>

                    <button type="submit" name="txtcategory" value="<?php echo $listacategoria['Name'] ?>" class="btn btn-light"><?php echo $listacategoria['Name'] ?></button>
                  <?php } ?>
                  </form>
                </fieldset>
            </div>
        </form>
    </div>

<table>
  <?php foreach($listacontenido as $contenido) { ?>
    <tr>
      <th>
        <img class="card-img-top" src="<?php echo $url;?>/img/contenido/<?php echo $contenido['Image'] ?>">
      </th>
      <th>  
        <div class="card-body">
            <h4 class="card-title"><?php echo $contenido['Title'] ?></h4>
            <h6><small class="badge rounded-pill bg-danger text-light"><?php echo $contenido['SubTipo'] ?></small>   <small class="badge rounded-pill bg-success text-light"><?php echo $contenido['Status'] ?></small></h6>
            <?php
              $txtidcontent = $contenido['ID'];
              $sentenciaSQL= $conexion->prepare("SELECT * FROM relacional_tag WHERE ID_Content=:id ");
              $sentenciaSQL->bindParam(':id',$txtidcontent);
              $sentenciaSQL->execute();
              $labels=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

              ?>
            <div>
              <?php foreach($labels as $label) { ?>
                <span class="badge rounded-pill bg-light"><?php echo $label['Tag'] ?></span>
              <?php } ?>
            </div>

            <div>
              <p class="lead"><small><?php echo $contenido['Sinopsis'] ?></small></p>
              <a href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $contenido['ID']; ?>"><button  class="btn btn-primary">Más informacíon</button></a>
            </div>
            
        </div>
      </th>
    </tr>

    </div>
  <?php } ?>  
</table> 
</div>
</div>

<?php include ("../footer.php"); ?>


