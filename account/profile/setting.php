<?php include ("../../template/layout.php"); 

include ("../../administrador/config/bd.php");

class Password {
  const SALT = 'EstoEsUnSalt';
  public static function hash($password) {
      return hash('sha512', self::SALT . $password);
  }
  public static function verify($password, $hash) {
      return ($hash == self::hash($password));
  }
}

$usuario = $_SESSION['Usuario'];
$sentenciaSQL= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario = :usuario ");
$sentenciaSQL->bindParam(':usuario',$usuario);
$sentenciaSQL->execute();
$listaperfil=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
$txtID = $listaperfil['ID'];
$txtName = $listaperfil['Name'];
$txtSurname = $listaperfil['Surname'];
$txtEmail = $listaperfil['Emails'];
$img_portada = $listaperfil['Image'];
$txtcomment = $listaperfil['Comments'];
$txtpassword = $listaperfil['Password'];


if (isset($_POST['accion'])) {
    if (isset($_POST['nombre']) && $_POST['nombre']!=""){$txtName =$_POST['nombre'];}
    //$txtName = (isset($_POST['nombre']))?$_POST['nombre']:"";
    if (isset($_POST['apellido']) && $_POST['apellido']!=""){$txtSurname =$_POST['apellido'];}

    if (isset($_POST['email']) && $_POST['email']!=""){$txtEmail =$_POST['email'];}

    if (isset($_POST['img_portada']) && $_POST['img_portada']!=""){$img_portada =$_POST['img_portada'];}

    if (isset($_POST['comments']) && $_POST['comments']!=""){$txtcomment =$_POST['comments'];}

    if (isset($_POST['contrasenia1']) && $_POST['contrasenia1']!=""){$txtpassword =$_POST['contrasenia1'];}

    $hash = Password::hash($txtpassword);
    $sentenciaSQL= $conexion->prepare("UPDATE privatemembersdata SET Name = :name, Surname = :surname, Password = :password, Comments = :comment, Emails = :email WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtID);
    $sentenciaSQL->bindParam(':name',$txtName);
    $sentenciaSQL->bindParam(':surname',$txtSurname);
    $sentenciaSQL->bindParam(':email',$txtEmail);
    $sentenciaSQL->bindParam(':comment',$txtcomment);
    $sentenciaSQL->bindParam(':password',$hash);
    $sentenciaSQL->execute();


    if($img_portada!=""){
        $fecha= new Datetime();
        $nombreArchivo =($img_portada!="")?$fecha->getTimestamp()."_".$_FILES["img_portada"]["name"]:"portada.png";      
        $tmpImagen=$_FILES["img_portada"]["tmp_name"];

        move_uploaded_file($tmpImagen,"../../img/contenido/".$nombreArchivo);
        
        $sentenciaSQL= $conexion->prepare("SELECT Picture FROM privatemembersdata WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $contenido=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if( isset($contenido["Picture"]) &&($contenido["Picture"]!="imagen.jpg")){
            if(file_exists("../../img/contenido/".$contenido["Picture"])){
                unlink("../../img/contenido/".$contenido["Picture"]);
            }

        }
        
        $sentenciaSQL= $conexion->prepare("UPDATE privatemembersdata SET Picture=:imagen WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
    }
}
?>
<br/>

<form method="POST" enctype="multipart/form-data">
<br/><br/>
  <fieldset>
    <legend>¡Bievenido <?php echo $usuario; ?>! Modifica tus datos de usuario facilmente:</legend>
    <br/><br/>
    <div class="col-12">
      <div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-5">
            <input type="text" readonly="" class="form-control-plaintext" name="category" value="<?php echo $txtEmail;?>">
          </div>
          <div class="col-sm-5">
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
        </div>   
      </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
          <label for="exampleInputPassword1" class="form-label mt-4">Contraseña</label>
          <input type="password" class="form-control" name="contrasenia1" id="contrasenia1" placeholder="Contraseña">
        </div>
        <div class="col-sm-6">
          <label class="form-label mt-4">Infomación de usuario</label>
          <input type="text" class="form-control" name="nombre" placeholder="Nombre">
          <input type="text" class="form-control" name="apellido" placeholder="Apellido">
        </div>
    </div>
    <div class="form-group">
      <label class="form-label mt-4">Comentario de autor (Opcional):</label>
      <textarea class="form-control" name="comments" rows="3"></textarea>
    </div>
    <div class = "form-group">
          <label for="img_portada">Imagen:</label>
          <br/>
          <?php echo $img_portada; ?>
          <?php if($img_portada!=""){ ?>
                        <img class="img-thumbnail rounded" src="<?php echo $url;?>/img/contenido/<?php echo $img_portada; ?>" width="50" alt="">            
                
          <?php    } ?>
          <input type="file" class="form-control" name="img_portada" id="img_portada" placeholder="Imagen">
        </div>
    <br/>
    <button type="submit" name="accion" value="Guardar" class="btn btn-primary">Guardar</button>
  </fieldset>
</form>

<?php include ("../../template/footer.php"); ?>