<?php 

session_start();

include ("../config/bd.php");

$usuario = $_SESSION['Usuario'];


include("../template/dashboard.php"); 

$txtid = $_GET['txtid'];

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
if($accion == "actualizar"){
  $txtid_chapter =(isset($_POST['txtid_chapter']))?$_POST['txtid_chapter']:"";
  $orden =(isset($_POST['orden']))?$_POST['orden']:"";
  $sentenciaSQL= $conexion->prepare("UPDATE chapter SET Orden =:orden WHERE ID_Chapter=:id");
  $sentenciaSQL->bindParam(':id',$txtid_chapter);
  $sentenciaSQL->bindParam(':orden',$orden);
  $sentenciaSQL->execute();
  
}

if($accion == "eliminar"){
  $txtid_chapter =(isset($_POST['txtid_chapter']))?$_POST['txtid_chapter']:"";
  $sentenciaSQL= $conexion->prepare("DELETE FROM chapter WHERE ID_Chapter=:id");
  $sentenciaSQL->bindParam(':id',$txtid_chapter);
  $sentenciaSQL->execute();
  
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE id=:id");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();
$informacion=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

$sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Content=:id AND Tipo='Novela' ORDER BY Orden ASC");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();
$novela=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Content=:id AND Tipo='Comic' ORDER BY Orden ASC");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();
$comic=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$txtTitle = $informacion['Title'];
$user = $informacion['Author'];
$sinopsis =  $informacion['Sinopsis'];
$img = $informacion['Image'];
$category = $informacion['Categoria'];






?>

<div class="col-9">
  <?php include "../template/sublayout.php" ?>
  <br/><br/>
  <div class="container">
    <div>
      <table class="row">
        <tr>
          <th class="col-3">
            <div>
              <img class="img-thumbnail" width="100%" src="<?php echo $url;?>/img/contenido/<?php echo $img ?>">
            </div>
          </th>
          <th class="col-10">
            <div >
              <div class="card-body">
                <h4 class="card-title"><?php echo $txtTitle;?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $user;?></h6>
                <p class="lead"><?php echo $sinopsis;?> .</p>
                <span class="badge rounded-pill bg-secondary text-light"><?php echo $category ?></span>
              </div>
            </div>
          </th>
        </tr>
      </table>
    </div>
    </br></br>
    <?php

      $sentenciaSQL= $conexion->prepare("SELECT * FROM relacional_tag WHERE ID_Content=:id ");
      $sentenciaSQL->bindParam(':id',$txtid);
      $sentenciaSQL->execute();
      $etiquetas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div>
      <label>Etiquetas:</label>
      <?php foreach($etiquetas as $etiqueta) { ?>
      <span class="badge rounded-pill bg-light"><?php echo $etiqueta['Tag'] ?></span>
      <?php } ?>
    </div>
    <div>
    </br></br>    
      <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col" width="500"> 
            <a class="text-info">Novela</a>          
          </th>
          <th scope="col"  width="500">
            <a class="text-info">Comic</a>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>
            <table class="col-12">
            <?php foreach($novela as $novelas) { ?>   
              <tr>
              <form method="POST">
              <th scope="col">
                  <input type="text" name="orden" id="orden" value="<?php echo $novelas['Orden']; ?>" />
                  <a ><button type="submit" class="btn btn-outline-primary" name= "accion" value="actualizar">Actualizar</button></a>
              </th>
                <th scope="col">
                  <a href="#"><?php echo $novelas['Title'] ?></a>
                </th>
                <th scope="col">
                  <input type="hidden" name="txtid_chapter" id="txtid_chapter" value="<?php echo $novelas['ID_Chapter']; ?>" />
                  <a ><button type="submit" class="btn btn-outline-danger" name= "accion" value="eliminar">Eliminar</button></a>
                </th>
              </form>
              </tr>
              <?php } ?>
            </table>
          </th>
          <th>
            <table class="col-12">
            <?php foreach($comic as $comics) { ?>   
              <tr >
              <form method="POST">
                <th scope="col">
                  <div class="row">
                    <input type="text" name="orden" id="orden" value="<?php echo $comics['Orden']; ?>" />
                    <a ><button type="submit" class="btn btn-outline-primary" name= "accion" value="actualizar">Actualizar</button></a>
                  </div>
                </th>
                <th scope="col">
                  <a><?php echo $comics['Title'] ?></a>
                </th>
                <th scope="col">
                  <input type="hidden" name="txtid_chapter" id="txtid_chapter" value="<?php echo $comics['ID_Chapter']; ?>" />
                  <a type="submit" name="accion" id="accion" value="eliminar">Eliminar</a>
                </th>
              </form>
              </tr>
              <?php } ?>
            </table>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</div> 

<?php include("../template/footer.php"); ?>