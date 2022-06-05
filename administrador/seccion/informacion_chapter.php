<?php 


include ("../config/bd.php");

$txtid = $_GET['txtid'];


include ("../../template/layout.php");

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

if($accion == "favorito"){
  $usuario = $_SESSION['Usuario'];
  $txtid = $_GET['txtid'];
  $sentenciaSQL= $conexion->prepare("INSERT INTO `fav` (`ID_content`, `Usuario`) VALUES (:id_Content, :usuario);");
  $sentenciaSQL->bindParam(':id_Content',$txtid);
  $sentenciaSQL->bindParam(':usuario',$usuario);
  $sentenciaSQL->execute();
  
}

if(isset($_POST['score'])){
  $usuario = $_SESSION['Usuario'];
  $score = (isset($_POST['score']))?$_POST['score']:"";

  $contar= $conexion->prepare("SELECT COUNT(*) FROM score WHERE Usuario=:usuario");
  $contar->bindParam(':usuario',$usuario);
  $contar->execute();
  $numContar=$contar->fetchAll(PDO::FETCH_ASSOC);


  if($numContar != '0'){
    if($score == "up"){
      $numscore = '10';
      $sentenciaSQL= $conexion->prepare("UPDATE score SET Score=:score WHERE ID_Content=:id and Usuario=:usuario");
      $sentenciaSQL->bindParam(':usuario',$usuario);
      $sentenciaSQL->bindParam(':score',$numscore);
      $sentenciaSQL->bindParam(':id',$txtid);
      $sentenciaSQL->execute();
    }
    if($score == "down"){
      $numscore = '0';
      $sentenciaSQL= $conexion->prepare("UPDATE score SET Score=:score WHERE ID_Content=:id and Usuario=:usuario");
      $sentenciaSQL->bindParam(':usuario',$usuario);
      $sentenciaSQL->bindParam(':id',$txtid);
      $sentenciaSQL->bindParam(':score',$numscore);
      $sentenciaSQL->execute();
    }
    
  } else {
    if($score == "up"){
      $numscore = '10';
      $sentenciaSQL= $conexion->prepare("INSERT INTO `score` (`Score`, `Usuario`, `ID_content`) VALUES (:score, :usuario, :id_Content);");
      $sentenciaSQL->bindParam(':id_Content',$txtid);
      $sentenciaSQL->bindParam(':usuario',$usuario);
      $sentenciaSQL->bindParam(':score',$numscore);
      $sentenciaSQL->execute();
    }
    if($score == "down"){
      $numscore = '0';
      $sentenciaSQL= $conexion->prepare("INSERT INTO `score` (`Score`, `Usuario`, `ID_content`) VALUES (:score, :usuario, :id_Content);");
      $sentenciaSQL->bindParam(':id_Content',$txtid);
      $sentenciaSQL->bindParam(':usuario',$usuario);
      $sentenciaSQL->bindParam(':score',$numscore);
      $sentenciaSQL->execute();
    }

  }
}

$contar= $conexion->prepare("SELECT COUNT(*) FROM score");
$contar->execute();
$numscore=$contar->fetchAll(PDO::FETCH_BOTH);

$contar= $conexion->prepare("SELECT SUM('Score') FROM score");
$contar->execute();
$totalparticular=$contar->fetchAll(PDO::FETCH_BOTH);

$total=$numscore[0][0]*10;

$porcentaje= $totalparticular[0][0]/$total*100;

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






?>

<div class="col-12">
  <br/><br/>
  <div class="container">
    <div>
      <table class="row">
        <tr>
          <th class="col-3">
            <div>
              <img class="img-thumbnail" width="100%" src="<?php echo $url;?>/img/contenido/<?php echo $img ?>">
            </div>
            <br/><br/>
            <div>
              <form method="POST">
              <button type="submit" name="accion" class="btn btn-danger" value="favorito">
                <i class="fas fa-fw fa-bookmark"></i>
              </button>
              </form>
            </div>
          </th>
          <th class="col-12">
            <div >
              <div class="card-body">
                <h4 class="card-title"><?php echo $txtTitle;?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $user;?></h6>
                <p class="lead"><?php echo $sinopsis;?> .</p>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $porcentaje;?>%</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentaje;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col">
                    <form method="POST">
                      <div class="col">
                        <div>
                          <button type="submit" class="btn btn-outline-primary" name="score" value="up">LIKE</button>
                        </div>
                        <div>
                          <button type="submit" class="btn btn-outline-primary" name="score" value="down">DISLIKE</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
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
    <div class="container">
      <div classs="col-2">
        <div class="body">
            <label>Etiquetas</label>
            <a href="<?php echo $url;?>/template/category/tag.php?txtid=<?php echo $txtid; ?>"  data-target="tag"><span class="text-danger">Editar</span></a>
          </div>
        <div class="footer">
        <?php foreach($etiquetas as $etiqueta) { ?>
          <span class="badge rounded-pill bg-light"><?php echo $etiqueta['Tag'] ?></span>
        <?php } ?>
        </div>
      </div>
    </div>
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
                <th scope="col">
                  <a href="<?php echo $url;?>/administrador/seccion/chapter.php?txtid=<?php echo $novelas['ID_Chapter']; ?>"><?php echo $novelas['Title'] ?></a>
                </th>
                <th>
                  <a><?php echo $novelas['Fecha'] ?></a>
                </th>
              </tr>
              <?php } ?>
            </table>
          </th>
          <th>
            <table class="col-12">
            <?php foreach($comic as $comics) { ?>   
              <tr >
              <form method="POST" >
                <th scope="col">
                  <a href="<?php echo $url;?>/administrador/seccion/chapter.php?txtid=<?php echo $comics['ID_Chapter']; ?>"><?php echo $comics['Title'] ?></a>
                </th>
                <th>
                  <a><?php echo $comics['Fecha'] ?></a>
                </th>
              </form>
              </tr>
              <?php } ?>
            </table>
          </th>
        </tr>
      </tbody>
    </table>
    <br/><br/>
    <br/><br/>
    <h4>Comentarios</h4>
    <br/><br/>

  </div>
</div>
<?php include("comments.php"); ?>
 
</div>

<?php include ("../../template/footer.php"); ?>
