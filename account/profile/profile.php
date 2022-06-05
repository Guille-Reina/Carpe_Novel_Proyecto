<?php include ("../../template/layout.php"); 

include ("../../administrador/config/bd.php");

$user = $_GET['txtuser'];;
$sentenciaSQL= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario = :usuario ");
$sentenciaSQL->bindParam(':usuario',$user);
$sentenciaSQL->execute();
$listaperfil=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
$txtidunique = $listaperfil['ID'];
$name = $listaperfil['Name'];
$surname = $listaperfil['Surname'];
$comentario = $listaperfil['Comments'];

?>


<div class="container px-5">
<br/>
    <div>
        <table class="row">
            <tr>
                <th>
                    <div class="img_profile">
                        <img class="rounded-circle" width="300" src="<?php echo $url;?>/img/contenido/<?php echo $img ?>">
                    </div>
                </th>
                <th>
                    <div class="card" width="100%">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $user;?></h4>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $name;?> <?php echo $surname;?></h6>
                            <p class="card-text"><?php echo $comentario;?> .</p>
                        </div>
                    </div>
                </th>
            </tr>
        </table>
    </div>
<br/>
<br/>

    <div class="nav">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home">Trabajos Originales</a>
            </li>
        </ul>
    </div>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="home">
            <?php include ("original_works.php"); ?>        
        </div>
    </div>
</div>

<?php include ("../../template/footer.php"); ?>