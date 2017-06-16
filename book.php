<?php
include_once 'connect.php';
include_once 'header.php';
?>

<!DOCTYPE html>


<!-- Page Content -->
<div class="container" style="min-height: 720px;">

    <div class="row book-description" style="margin-top: 30px;">
        <?php
        $id_c = $_GET['id_c'];
        $sql_query = "SELECT * FROM carte WHERE id_c =" . $id_c;
        $result_set = mysqli_query($connect, $sql_query);
        $book = mysqli_fetch_assoc($result_set);
        ?>
        <form action="" method="POST">
            <input type="text" name="id_c" value="<?php echo $book['id_c']; ?>" hidden/>
            <input type="text" name="stoc" value="<?php echo $book['nr_carti']; ?>" hidden/>
        <div class="left-description col-lg-4">
            <img class="book-view" src="images/<?php echo $book['poza']; ?>" alt="">
            <p class="mt15 alert alert-info text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Nr. carti disponibile: <span><?php echo $book['nr_carti']; ?></span></p>
            <?php if ($book['nr_carti'] <= 0 OR (empty($_SESSION['id']))) { ?>
                <button class="btn btn-lg btn-default" style='width: 100%;' disabled>Rezerva</button>
            <?php } else { ?>
               
                    <button class="btn btn-lg btn-default" style='width: 100%;' name="rezerva">Rezerva</button>
                
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
                <a href="index.php" class="btn btn-default pull-left">
                    <i class="fa fa-caret-square-o-left" aria-hidden="true"></i> Inapoi
                </a>
            </div>
        </div>
    </div>
</div>
</form>
<?php include_once 'footer.php';?>
<?php
if(isset($_POST['rezerva'])){
    $id_c = mysqli_real_escape_string($connect, $_POST['id_c']);
    $stoc = mysqli_real_escape_string($connect, $_POST['stoc']);
    $utilizator = $_SESSION['id'];
    
    if($stoc <= 0 ){
           ?>
            <script>
                window.location = 'book.php?id_c=<?php echo $row['id_c']; ?>';
                alert('Din pacate numarul de carti este depasit de cerere!');
            </script>
<?php
    }else{
    $stoc_nou = $stoc - 1;
    
    $sql1 = "UPDATE carte SET nr_carti ='$stoc_nou' WHERE id_c = '$id_c'";
    $res1 = mysqli_query($connect, $sql1) or die(mysqli_error());
    
    $sql2 = "INSERT INTO rezervare (id_u, id_c, data_rez, data_add)"
            . " VALUES('$utilizator','$id_c', DATE(NOW()),NOW())";
    $res2 = mysqli_query($connect, $sql2)or die(mysqli_error());

    if($res1 AND $res2){
        ?>
            <script>
                window.location = 'rezervare.php';
                alert('Cartea a fost rezervata cu succes!');
            </script>
<?php
    }else{
        ?>
            <script>
                window.location = 'rezervare.php';
                alert('Eroare la rezervarea cartii!');
            </script>
<?php
    }
}
}