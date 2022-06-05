<?php 
session_start();
include("config/bd.php");

$usuario = $_SESSION['Usuario'];


$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido WHERE Author=:usuario");
$sentenciaSQL->bindParam(':usuario',$usuario);
$sentenciaSQL->execute();
$listacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>


<?php include("template/dashboard.php"); ?>
    <div class="col-9">
        <div class="form-group">
            <table>
                <tr>
                    <th>
                        <label  >Seleccionar</label>
                        <select class="form-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option> --- </option>
                            <?php foreach($listacontenido as $contenido) { ?>   
                            <option  value="<?php echo $url;?>/administrador/index.php?txtid=<?php echo $contenido['ID']; ?>">                    
                                 <?php echo $contenido['Title']; ?>
                            </option>
                             <?php } ?>
                        </select>
                </tr>
                <tr>
                    <?php 
                    if(isset($_GET['txtid'])){
                        $txtidcontenido = $_GET['txtid'];
                        $sentenciaSQL= $conexion->prepare("SELECT COUNT(*) FROM chapter WHERE ID_Content=:id AND Tipo='Comic'");
                        $sentenciaSQL->bindParam(':id',$txtidcontenido);
                        $sentenciaSQL->execute();
                        $numcomic=$sentenciaSQL->fetch(PDO::FETCH_BOTH);

                        $sentenciaSQL= $conexion->prepare("SELECT COUNT(*) FROM chapter WHERE ID_Content=:id AND Tipo='Novela'");
                        $sentenciaSQL->bindParam(':id',$txtidcontenido);
                        $sentenciaSQL->execute();
                        $numnovela=$sentenciaSQL->fetch(PDO::FETCH_BOTH);

                    }
                    ?>
                    <th>
                    </br>
                        <p> Nº Capítulos </p>
                        <p> Novela: <?php 
                        if(isset($_GET['txtid'])){ 
                            echo $numnovela[0];}
                            ?></p>
                        <p> Comic: <?php if(isset($_GET['txtid'])){ echo $numcomic[0]; }?></p>
                    </th>
                </tr>
            </table>
        </div>
    <div class="card">
        <div>
            <div>
                <br/>
                <h1>Preguntas frecuentes:</h1>
                <br/>
                <br/>
                <h5>¿Como crear una novela?</h5>

                <p>Es simple, unicamente se debe presionar el botón “Crear” del menú principal, loguearte o 
                registrate si aun no lo has hecho y en la sección contenido, especificar el tipo de novela o 
                cómic. Para después subir el documentos del capitulo.</p>

                <h5>¿Que son los puntos de éxito?</h5>

                <p>Este sistema de puntos sirve como otra medida para medir el grado de popularidad de una novela. 
                Haciendo que esta aparezca en el Ranking dependiendo de numero que tenga.</p>

                <h5>¿Como obtener puntos de éxito?</h5>

                <p>Estos puntos solo pueden ser obtenido una vez al día.</p>

                <h5>¿Como encuentro un dibujante para mi cómic?</h5>

                <p>Para hacerlo lo único que tienes que hacer es publicar un aviso en el foro, en a sección se búsqueda.</p>
            </div>        
        </div>
    </div>
</div>

<?php include("template/footer.php"); ?>            