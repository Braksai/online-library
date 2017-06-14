<?php ?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>EBiblioUTCN</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/thumbnail-gallery.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="signin-form">

        <div class="container">


            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-signin" method="post" id="login-form">

                <a href="index.php" title="Home page" style="text-decoration:none;">
                    <img class="site-logo-img pull-left" src="images/logo.png" alt="EBiblioUTCN">
                    <span class="site-logo-text" style="line-height: 55px;">EBiblioUTCN</span>
                </a>
                
                <hr />

                <div id="error">
                    <?php
                    if (isset($error)) {
                        ?>
                        <div class="alert alert-danger">
                            <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Utilizator" value="<?php //echo $email; ?>" maxlength="40" required/>
                    </div>
                    <span class="text-danger"><?php //echo $emailError; ?></span>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input type="password" name="pass" class="form-control" placeholder="Parola" maxlength="20" required/>
                    </div>
                    <span class="text-danger"><?php //echo $passError; ?></span>
                </div>
                
                <label>Nu ai un cont? <a href="register.php">Inregistrare</a></label>

                <div class="form-group">
                    <hr />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" name="btn-login"><i class="fa fa-key" aria-hidden="true"></i> Autentificare</button>
                </div>
                <br />
                
            </form>

        </div>

    </div>

</body>
</html>