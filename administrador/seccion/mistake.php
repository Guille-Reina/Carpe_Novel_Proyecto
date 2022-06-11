<?php 

session_start();

include ("../config/bd.php");

$usuario = $_SESSION['Usuario'];


include("../template/dashboard.php"); 

$txtid = $_GET['txtid'];

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


if($accion == "eliminar"){
  $txterror =(isset($_POST['txterror']))?$_POST['txterror']:"";
  $sentenciaSQL= $conexion->prepare("DELETE FROM content_error WHERE id=:id");
  $sentenciaSQL->bindParam(':id',$txterror);
  $sentenciaSQL->execute();
  
}


$sentenciaSQL= $conexion->prepare("SELECT * FROM content_error WHERE ID_Content =:id");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();
$informacionerrores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<br/><br/><br/>
  <div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/information.php?txtid=<?php echo $txtid ?>"> <i class="fas fa-chevron-left"></i> Atras</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
								<th>Nombre del capítulo</th>
                <th>Usuario</th>
                <th>Contenido</th>
                <th>Operaciones</th>
              </tr>
            </thead>
            <tbody>
							<?php foreach($informacionerrores as $informacion) { ?>   
              <tr>
								<td>          
									<a><?php echo $informacion['Chapter']; ?></a>
                </td>
                <td><?php echo $informacion['Usuario']; ?></td>
                <td><?php echo $informacion['Contenido']; ?></td>
              <form method="POST">
                <td scope="col">
                  <input type="hidden" name="txterror" id="txterror" value="<?php echo $informacion['ID']; ?>" />
                  <a ><button type="submit" class="btn btn-outline-danger" name= "accion" value="eliminar">Eliminar</button></a>
              </td>
              </form>              
            </tr>
							<?php } ?> 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("../template/footer.php"); ?>