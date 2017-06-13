<?php
include_once 'connect.php';
?>

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
        <nav class="navbar navbar-inverse" role="navigation" style="background: #232a34;">
            <div style="background: #fff; height: 80px; padding-top: 15px;">
                <div class="container">
                    <div class="navbar-header">
                        <a href="/" title="Home page">
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
                            <a href="/login.php">Autentificare</a>
                        </li>
                        <li>
                            <a href="/register.php">Inregistrare</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <div class="row">
                <form action="/" method="post" accept-charset="UTF-8">
                    <div>
                        <h2 style="text-align: center;">Cautare carte</h2>
                        <div class="input-group col-lg-6 col-lg-offset-3">
                            <label class="input-group-addon" for="edit-search-block-form--2">Cauta </label>
                            <input title="Enter the terms you wish to search for." 
                                   autocomplete="off" tabindex="1" 
                                   placeholder="Gaseste orice in librarie. Scrie numele cartii." 
                                   type="search" 
                                   name="search_book" 
                                   value="" size="60" 
                                   maxlength="128" 
                                   class="form-control">
                            <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row" style="margin-top: 30px;">
                <?php
                 $sql_query="SELECT titlu, poza FROM carte";
                 $result_set=mysqli_query($connect, $sql_query);
                 while($row= mysqli_fetch_assoc ($result_set))
                 {?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a class="thumbnail" href="#">
                        <img class="img-responsive book" src="images/<?php echo $row['poza']; ?>" alt="">
                        <p class="title-book truncate"><?php echo $row['titlu'];?></p>
                    </a>
                </div>
                 <?php } ?>
            </div>
        </div>

        <footer style="background: #232a34; height: 100px; margin: 0px; color: #fff; text-align: center; ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; EBiblioUTCN</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

    </body>


</html> 