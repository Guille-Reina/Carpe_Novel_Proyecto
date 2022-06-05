<?php include ("../layout.php"); ?>


<?php

$searchErr = '';
$employee_details='';
if(isset($_POST['save']))
{
    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];
        $stmt = $conexion->prepare("SELECT * from contenido where Title like '%$search%' or Sinopsis like '%$search%'");
        $stmt->execute();
        $employee_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
    }
    else
    {
        $searchErr = "Please enter the information";
    }
    
}
 
?>
            <div class="col-12">
            <br/><br/>
              <form class="form-horizontal" action="#" method="post">
                <div aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit" name="save">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

    <br/><br/>
    <div class="table-responsive">          
      <table class="table">
        <?php
          if(!$employee_details){
                    echo '<tr>No data found</tr>';
          } else{
            foreach($employee_details as $key=>$value){
        ?>            
        <tr>
          <th><?php echo $key+1;?></th>
          <th>
            <img class="card-img-top" src="<?php echo $url;?>/img/contenido/<?php echo $value['Image'] ?>">
          </th>
          <th>  
            <div class="card-body">
              <h4 class="card-title"><?php echo $value['Title'] ?></h4>
              <h6><small class="badge rounded-pill bg-danger text-light"><?php echo $value['SubTipo'] ?></small>   <small class="badge rounded-pill bg-success text-light"><?php echo $value['Status'] ?></small></h6>
              <?php
                $txtidcontent = $value['ID'];
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
                <p class="lead"><small><?php echo $value['Sinopsis'] ?></small></p>
                <a href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $value['ID']; ?>"><button  class="btn btn-primary">Más informacíon</button></a>
              </div>
            </div>
          </th>
        </tr>
      <?php } } ?>
</table>

<?php include("../footer.php"); ?>            