<?php
$sentenciaSQL2= $conexion->prepare("SELECT * FROM categorias");
$sentenciaSQL2->execute();
$listacategorias=$sentenciaSQL2->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <form method="POST" enctype="multipart/form-data">    
      <div class="modal-header">
        <h5 class="modal-title">Contenido</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class = "form-group">
          <input type="hidden" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
        </div>
        <div class = "form-group">
          <label for="txtTitulo">Título:</label>
          <input type="text" required class="form-control" value="<?php echo $txtTitulo; ?>" name="txtTitulo" id="txtTitulo" placeholder="Título">
        </div>
        <div class = "form-group">
          <label for="txtSubType">Contenido:</label>
          <select required class="form-select" id="tiposelect" name="txtSubType" value="<?php echo $txtSubType; ?>">
            <option>Original</option>
            <option>Fan-Fic</option>
          </select>
        </div>
        <div class = "form-group">
          <label for="lenguage">Idioma:</label>
          <input type="text" required class="form-control" value="<?php echo $lenguage; ?>" name="lenguage" id="lenguage" placeholder="Lenguage">
        </div>
        <div class = "form-group">
          <label for="txtTitulo">Sinopsis:</label>
          <textarea type="text" required class="form-control" rows="3" value="<?php echo $sinopsis; ?>" name="sinopsis" id="sinopsis" placeholder="Sinopsis"></textarea>
        </div>
        <div class = "form-group">
          <fieldset class="form-group">
            <legend class="mt-4">Categorias:</legend>
            <select required class="form-select" id="tiposelect" name="txtcategory" value="<?php echo $categorya; ?>">
            <?php foreach($listacategorias as $categoria) { ?>   
              <option><?php echo $categoria['Name']; ?></option>
            <?php } ?>
            </select>
          </fieldset>
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
      </div>
      <div class="modal-footer">
        <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>  
    </div>
  </div>
</div>
