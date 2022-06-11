<?php include("../layout.php"); ?>  

<?php



$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido ORDER BY 'Published Date' DESC limit 5");
$sentenciaSQL->execute();
$todofechacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<div>
    <div class="jumbotron">
        <h1 class="display-3">Bienvenido a nuestra página Web</h1>
        <hr class="my-2">
		<p>Esta página te ofrece todo lo necesario para convertirse en un escritor <strong>Web</strong></p>
    </div>

    <h4>Recientemente Añadidos</h4>
    <div class="container-fluid">
        <div class="row">
			<div class="card-group">
				<?php foreach($todofechacontenido as $fechacontenido) { ?>   
				<div class="card">
                    <img width="200" src="<?php echo $url;?>/img/contenido/<?php echo $fechacontenido['Image']; ?>" >
					<div class="card-body">
						<h4 class="card-title"><?php echo $fechacontenido['Title']; ?></h4>
                        <a href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $fechacontenido['ID']; ?>"><button  class="btn btn-primary">Ver</button></a>
					</div>
				</div>
				<?php } ?> 
			</div>
        </div>
    </div>
			<br/><br/><br/>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Todo el Contenido de la web</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>Nombre</th>
                							<th>Fechas</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
											<th>Nombre</th>
                							<th>Fechas</th>
                                        </tr>
                                    </tfoot>
									<?php

										$sentenciaSQL= $conexion->prepare("SELECT * FROM contenido");
										$sentenciaSQL->execute();
										$todolistacontenido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

									?>
                                    <tbody>
										<?php foreach($todolistacontenido as $todocontenido) { ?>   
                                        <tr>
										<td>          
                    						<img src="../../img/contenido/<?php echo $todocontenido['Image']; ?>" width="50" alt="">            
											<a href="<?php echo $url;?>/administrador/seccion/informacion_chapter.php?txtid=<?php echo $todocontenido['ID']; ?>"><?php echo $todocontenido['Title'] ?></a>
                						</td>
                							<td><?php echo $todocontenido['Published Date']; ?></td>
                                        </tr>
										<?php } ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
<?php include("../footer.php"); ?>            