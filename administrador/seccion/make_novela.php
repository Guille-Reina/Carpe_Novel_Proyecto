<?php 
session_start();

$url="http://".$_SERVER['HTTP_HOST']."/sitioweb";

include ("../config/bd.php");

$txtid = $_GET['txtid'];

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

if(isset($_GET['txtidchapter'])){

    $txtidchapter = $_GET['txtidchapter'];
    $sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Chapter=:id");
    $sentenciaSQL->bindParam(':id',$txtidchapter);
    $sentenciaSQL->execute();
    $informacion=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
}


switch($accion){

    case "Crear":
        $txtTitle =(isset($_POST['txtTitle']))?$_POST['txtTitle']:"";
        $posicion =(isset($_POST['posicion']))?$_POST['posicion']:"";
        $text=(isset($_POST['text']))?$_POST['text']:"";
        $tipo="Novela";
        $sentenciaSQL= $conexion->prepare("INSERT INTO chapter (Title, ID_Content, Tipo, Contenido, Fecha, Orden) VALUES (:titulo, :id_Content, :tipo, :txt, NOW(), :orden);");
        $sentenciaSQL->bindParam(':id_Content',$txtid);
        $sentenciaSQL->bindParam(':titulo',$txtTitle);
        $sentenciaSQL->bindParam(':tipo',$tipo);
        $sentenciaSQL->bindParam(':txt',$text);
        $sentenciaSQL->bindParam(':orden',$posicion);
        $sentenciaSQL->execute();

        header("Location:information.php?txtid=$txtid");
        break;
}

?>
<html lang="en">
<head>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>/img/favicon1.ico" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo $url;?>/administrador/css/sb-admin-2.min.css" rel="stylesheet">
    <title>CarpeNovel -- Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    

<form method="POST" enctype="multipart/form-data">

<nav class="navbar navbar-expand navbar-light bg-light shadow-sm">
    <div class="container px-5">
        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/information.php?txtid=<?php echo $txtid ?>"> <i class="fas fa-chevron-left"></i> Atras</a>
        <div class="btn-group" role="group">
            <a><button type="submit" name= "accion" class="btn btn-info" value="Crear">Guardar</button></a>
        </div>
    </div>
</nav>

</br>
</br>
<div class="container">
    <div width="100%">
        <div class="form-group">
            <input type="text" required class="form-control" name="txtTitle" placeholder="Título">
            <input type="text" required class="form-control" name="posicion" placeholder="Posicion del capítulo">

        </div>
        <div class="form-group">
            <textarea type="text" required class="form-control" rows="3" name="text"></textarea>
        </div>
    </div>
</div>
</form>

    <script src="<?php echo $url;?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo $url;?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $url;?>/js/sb-admin-2.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.3/glider.min.js"></script>
</body>
</html>
