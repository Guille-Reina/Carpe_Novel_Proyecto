<?php include ("../layout.php"); ?>


<?php




$txtid = $_GET['txtid'];


$searchErr = '';
if(isset($_POST['save']))
{
    if(!empty($_POST['search']))
    {
      
        $etiqueta = $_POST['search'];
        $sentenciaSQL = $conexion->prepare("INSERT INTO `relacional_tag` (`Tag`, `ID_Content`) VALUES (:etiqueta, :id);");
        $sentenciaSQL->bindParam(':id',$txtid);
        $sentenciaSQL->bindParam(':etiqueta',$etiqueta);
        $sentenciaSQL->execute();
        
        //header("Location:tag.php?txtid=$txtid");
         
    }
    
}

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


if($accion == "eliminar"){
  $txtid_label =(isset($_POST['txtid_label']))?$_POST['txtid_label']:"";
  $sentenciaSQL= $conexion->prepare("DELETE FROM relacional_tag WHERE ID=:id");
  $sentenciaSQL->bindParam(':id',$txtid_label);
  $sentenciaSQL->execute();
  
}

$stmt= $conexion->prepare("SELECT * FROM relacional_tag WHERE ID_Content=:id ");
$stmt->bindParam(':id',$txtid);
$stmt->execute();
$employee_details=$stmt->fetchAll(PDO::FETCH_ASSOC);


$url="http://".$_SERVER['HTTP_HOST']."/sitioweb";



 
?>

    <br/><br/>
  <form class="form-horizontal" action="#" method="post">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
              <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $txtid ?>"> <i class="fas fa-chevron-left"></i> Atras</a>
            </div>
            <br/><br/><br/><br/>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="search" placeholder="search here">
            </div>
            <div class="col-sm-2">
              <button type="submit" name="save" class="btn btn-success btn-sm">Añadir</button>
            </div>
        </div>
         
    </div>
    </form>
    <div class="table-responsive">
    <br/><br/>          
      <table class="table">
        <thead>
          <tr>
            <th>Posicion</th>
            <th>Employee Name</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody>
                <?php
                 if(!$employee_details)
                 {
                 }
                 else{
                    foreach($employee_details as $key=>$value)
                    {
                        ?>
                    <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo $value['Tag'];?></td>
                        <td>              
                          <form method="POST" >
                              <input type="hidden" name="txtid_label" id="txtid_label" value="<?php echo $value['ID']; ?>" />
                              <button type="submit" name="accion" id="accion" value="eliminar">Eliminar</button>
                          </form>
                        </td>
                    </tr>
                         
                        <?php
                    }
                     
                 }
                ?>
             
         </tbody>
      </table>
<?php include("../footer.php"); ?>            