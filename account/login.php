<?php
include 'user.php'
?>
<!doctype html>
<html lang="en">
<head>
    <title>Adminitrador -- Login --</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                                <div class="col-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">¡Bienvenido!</h1>
                                        </div>
                                        <?php if(isset($mensaje)) { ?>
                                            <div cass="alert alert-danger" role="alert">
                                                <?php echo $mensaje; ?>
                                            </div>
                                        <?php } ?>
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" required class="form-control form-control-user" name="usuario" aria-describedby="emailHelp" placeholder="Escribe tu nombre de usuario">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" required class="form-control form-control-user" name="pass" placeholder="Escribe tu contraseña">
                                            </div>
                                            <button type="submit" name="accion" class="btn btn-primary btn-user btn-block" value="Login"> Login </button>
                                            <hr>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="register.php">¡Regístrate!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
