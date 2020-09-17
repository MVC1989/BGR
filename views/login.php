<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KMB | BGR </title>

        <!-- Bootstrap -->
        <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="../build/css/custom.min.css" rel="stylesheet">
        <link href="../vendors/css/my_style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="login-page">
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>
            <div class="form">
                <div class="animate form login_form">
                    <section class="login_content">
                        <div class="has-feedback-left">
                            <img src="../images/KMB.png" width="120" height="100" alt=""/>
                            <img src="../images/logoBGR.png" width="120" height="100" alt=""/>
                        </div>
                    </section>
                    <section class="login_content">
                        <form action="../ajax/loginC.php" name="login" id="login" method="post">
                            <div class="form-group has-feedback">
                                <input type="text" name="txtUsuario" id="txtUsuario" class="form-control" placeholder="Usuario" required>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="txtPass" id="txtPass" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="has-feedback">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <section class="example2">
            <ul class="cuadrados">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </section>
    </body>
</html>
