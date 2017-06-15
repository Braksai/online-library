<!DOCTYPE html>
 
    <html>
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
        <!-- Navigation -->
       
<?php
include_once 'connect.php';
if(empty($_SESSION['id'])){
    echo '<nav class="navbar navbar-inverse" role="navigation" style="background: #232a34;">
            <div style="background: #fff; height: 80px; padding-top: 15px;">
                <div class="container">
                    <div class="navbar-header">
                        <a href="index.php" title="Home page">
                            <img class="site-logo-img pull-left" src="images/logo.png" alt="EBiblioUTCN">
                            <span class="navbar-brand site-logo-text">EBiblioUTCN</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div>
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="login.php">Autentificare</a>
                        </li>
                        <li>
                            <a href="register.php">Inregistrare</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>';
}else{
    if($_SESSION['acces'] == 1){
        echo ' <nav class="navbar navbar-inverse" role="navigation" style="background: #232a34;">
            <div style="background: #fff; height: 80px; padding-top: 15px;">
                <div class="container">
                    <div class="navbar-header">
                        <a href="index.php" title="Home page">
                            <img class="site-logo-img pull-left" src="images/logo.png" alt="EBiblioUTCN">
                            <span class="navbar-brand site-logo-text">EBiblioUTCN</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div>
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="administrare.php"><i class="fa fa-cogs" aria-hidden="true"></i> Administrare</a>
                        </li>
                        <li>
                            <a href="rezervare.php"><i class="fa fa-address-book-o" aria-hidden="true"></i> Rezervare</a>
                        </li>
                        <li>
                            <a href="deconectare.php"><i class="fa fa-power-off" aria-hidden="true"></i> Deconectare</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>';
    }else{
    echo ' <nav class="navbar navbar-inverse" role="navigation" style="background: #232a34;">
            <div style="background: #fff; height: 80px; padding-top: 15px;">
                <div class="container">
                    <div class="navbar-header">
                        <a href="index.php" title="Home page">
                            <img class="site-logo-img pull-left" src="images/logo.png" alt="EBiblioUTCN">
                            <span class="navbar-brand site-logo-text">EBiblioUTCN</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div>
                    <ul class="nav navbar-nav pull-right">
                           <li>
                            <a href="rezervare.php"><i class="fa fa-address-book-o" aria-hidden="true"></i> Rezervare</a>
                        </li>
                        <li>
                            <a href="deconectare.php"><i class="fa fa-power-off" aria-hidden="true"></i> Deconectare</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>';
}
}
