<?php

include ("../config/bd.php");

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


?>


<div>
<form action=" " name="form1" method="post">
   <div>
      <textarea class="form-field" id="textarea" name="comentario" rows="4"></textarea>   
   </div>
   <div class="row">
      <input type="submit" <?php echo (isset($_POST['Responder']))?"hidden":""; ?> name="comentar" value="Comentar" />
      <input type="submit" <?php echo (!isset($_POST['Responder']))?"hidden":""; ?> name="reply" value="Reply" />
      <input type="hidden" name="coment" value=" <?php echo (isset($_POST['Responder']))?$_POST['Responder']:""; ?> " />
    </div>
  </form>
</div>
<?php 

    if(isset($_POST['comentar'])){


        $comentario = (isset($_POST['comentario']))?$_POST['comentario']:"";
        $result= $conexion->prepare("INSERT INTO `comments` (`Post ID`, `Usuario`, `Plain Content`, `Creation`) VALUES (:id_Content, :usuario, :content, NOW() );");
        $result->bindParam(':id_Content',$txtid);
        $result->bindParam(':usuario',$usuario);
        $result->bindParam(':content',$comentario);
        $result->execute();

        if(!empty($result)){
        }
    }

?>

<?php 

    if(isset($_POST['reply'])){

        $idcomment = (isset($_POST['coment']))?$_POST['coment']:"";
        $comentario = (isset($_POST['comentario']))?$_POST['comentario']:"";
        $sentenciaSQL= $conexion->prepare("INSERT INTO `comments` (`Post ID`, `Usuario`, `Plain Content`, `Reply Count`, `Creation`) VALUES (:id_Content, :usuario, :content, :idcomment, NOW() );");
        $sentenciaSQL->bindParam(':id_Content',$txtid);
        $sentenciaSQL->bindParam(':usuario',$usuario);
        $sentenciaSQL->bindParam(':content',$comentario);
        $sentenciaSQL->bindParam(':idcomment',$idcomment);
        $sentenciaSQL->execute();

        if($sentenciaSQL){
        }
    }

?>

<div class="container" >
    <ul id="comments" style="list-style: none;">

    <?php 
    $sentenciaSQL= $conexion->prepare("SELECT * FROM comments WHERE `Post ID`=:id_Content AND `Reply Count` is null ORDER BY ID DESC");
    $sentenciaSQL->bindParam(':id_Content',$txtid);
    $sentenciaSQL->execute();
    $comentarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    foreach($comentarios as $contenido) { 

        $usercomments = $contenido['Usuario'];
        $fecha = $contenido['Creation'];
        $txtusers= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario=:usuario");
        $txtusers->bindParam(':usuario',$usercomments);
        $txtusers->execute();
        $users=$txtusers->fetch(PDO::FETCH_LAZY);

        $img = $users['Picture'];
        $comentario = $contenido['Plain Content'];
        $idcontent= $contenido['ID'];


    ?>

        <li class="cmmnt">
            <div class="avatar">
                <img class="img-profile rounded-circle" width="30" src="<?php echo $url;?>/img/contenido/<?php echo $img; ?>">
            </div>
            <div class="cmmnt-content">
                <header>
                    <a class="card-link" href="<?php echo $url;?>/account/profile/profile.php?txtuser=<?php echo $usercomments;?>"><?php echo $usercomments ?></a> - <span><?php echo $fecha ?></span>
                </header>
                <p>
                <?php echo $comentario; ?>
                </p>
                <form method ="POST">
                    <button name="Responder" value="<?php echo $idcontent;?>">
                    <a class="card-link" >Responder</a>
                    </button>
                </form>
            </div>        

        
        <?php 
        $contar= $conexion->prepare("SELECT COUNT(*) FROM comments WHERE `Reply Count` = :id ORDER BY ID DESC");
        $contar->bindParam(':id',$idcontent);
        $contar->execute();
        $numContar=$contar->fetchAll(PDO::FETCH_ASSOC);

        if($numContar != '0'){
            $reply= $conexion->prepare("SELECT * FROM comments WHERE `Reply Count` = :id ORDER BY ID DESC");
            $reply->bindParam(':id',$idcontent);
            $reply->execute();
            $subcomentarios=$reply->fetchAll(PDO::FETCH_ASSOC);

            foreach($subcomentarios as $contenido2) { 

                $usercomments2 = $contenido2['Usuario'];
                $fecha2 = $contenido2['Creation'];
                $txtusers2= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario=:usuario");
                $txtusers2->bindParam(':usuario',$usercomments2);
                $txtusers2->execute();
                $users2=$txtusers2->fetch(PDO::FETCH_LAZY);

                $img2 = $users2['Picture'];
                $comentario2 = $contenido2['Plain Content'];
                $iduser2= $contenido2['ID'];
            

        
        ?>
            <ul class="replies" style="list-style: none;">
                <div class="avatar">
                    <img class="img-profile rounded-circle" width="30" src="<?php echo $url;?>/img/contenido/<?php echo $img2; ?>">
                </div>
                <li class="cmmnt">
                    <header>
                        <a class="card-link" href="<?php echo $url;?>/account/profile/profile.php?txtuser=<?php echo $usercomments2;?>"><?php echo $usercomments2 ?></a> - <span><?php echo $fecha2 ?></span>
                    </header>
                    <p>
                    <?php echo $comentario2; ?>
                    </p>
                </li>
            </ul>

        <?php } } } ?>
        </li>    
    </ul>
</div>