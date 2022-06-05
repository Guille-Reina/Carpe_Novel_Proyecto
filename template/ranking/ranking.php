<?php include ("../layout.php"); ?>
<?php



$sentenciaSQL= $conexion->prepare("SELECT * FROM categorias");
$sentenciaSQL->execute();
$listacategorias=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$accion=(isset($_POST['txteleccion']))?$_POST['txteleccion']:"";


if(isset($_GET['txteleccion'])){
  if($accion == "fav"){
    $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido, fav ORDER BY COUNT(fav.ID_Content)  DESC");
    $sentenciaSQL->execute();
    $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  }
  if($accion == "comment"){
    $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido, comments ORDER BY COUNT('comments.Post ID') DESC");
    $sentenciaSQL->execute();
    $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  }
  if($accion == "chapter"){
    $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido, chapter ORDER BY COUNT(chapter.ID_Content) DESC");
    $sentenciaSQL->execute();
    $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  }
  if($accion == "like"){
    $sentenciaSQL= $conexion->prepare("SELECT * FROM contenido, Score ORDER BY COUNT(Score.ID_Content ) DESC");
    $sentenciaSQL->execute();
    $listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  }
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
            <div class="row justify-content-center">
                <fieldset class="eleccion">
                  <form method="POST">    

                    <button type="submit" name="txteleccion" value="chapter" class="btn btn-light">Con más capítulos</button>
                    <button type="submit" name="txteleccion" value="comment" class="btn btn-light">Con más reseñas</button>
                    <button type="submit" name="txteleccion" value="fav" class="btn btn-light">Con más colecciones</button>
                    <button type="submit" name="txteleccion" value="like" class="btn btn-light">Con más like</button>
                  
                  </form>
                </fieldset>
            </div>
        </form>
    </div>

<table>
  <?php foreach($listacontenido as $key=>$contenido) { ?>
    <tr>
      <th>
      <?php echo $key+1;?>
      </th>
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