<?php
include_once 'connect.php';
include_once 'header.php';
?>

<!DOCTYPE html>


<!-- Page Content -->
<div class="container">

    <div class="row book-description" style="margin-top: 30px;">
        <?php
        $id_c = $_GET['id_c'];
        $sql_query = "SELECT * FROM carte WHERE id_c =" . $id_c;
        $result_set = mysqli_query($connect, $sql_query);
        $book = mysqli_fetch_assoc($result_set);
        ?>
        <div class="left-description col-lg-4">
            <img class="book-view" src="images/<?php echo $book['poza']; ?>" alt="">
            <p class="mt15 alert alert-info text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Nr. carti disponibile: <span><?php echo $book['nr_carti']; ?></span></p>
            <?php if ($book['nr_carti'] <= 0) { ?>
                <button class="btn btn-lg btn-default" style='width: 100%;' disabled>Rezerva</button>
            <?php } else { ?>
                <a href="rezerva.php">
                    <button class="btn btn-lg btn-default" style='width: 100%;'>Rezerva</button>
                </a>
            <?php } ?>
        </div>
        <div class="right-description col-lg-8">
            <table>
                <tbody>
                    <tr class="right-description-top">
                        <td class="col-lg-2"><i class="fa fa-book" aria-hidden="true"></i>Titlu carte: </td><td class="col-lg-4"><?php echo $book['titlu']; ?></td>
                    </tr>
                    <tr class="right-description-top">
                        <td class="col-lg-2">Autor: </td><td class="col-lg-4"><?php echo $book['autor']; ?></td>
                    </tr>
                    <tr class="right-description-top">
                        <td class="col-lg-2">Editura: </td><td class="col-lg-4"><?php echo $book['editura']; ?></td>
                    </tr>
                    <tr class="right-description-top">
                        <td class="col-lg-2">Data publicării: </td><td class="col-lg-4"><?php echo $book['data_publicarii']; ?></td>
                    </tr>
                </tbody>
            </table>
            <p style="margin-top: 30px; text-align: justify; font-size: 16px;"><?php echo $book['descriere']; ?></p>
            <div class="row col-lg-12">
                <a href="index.php">
                    <button class="btn btn-default pull-left"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i> Inapoi</button>
                </a>
            </div>
        </div>
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
