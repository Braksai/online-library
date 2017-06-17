<?php
include_once 'connect.php';
include_once 'header.php';
?>
<body style="background-color: silver">
<center><h3 style='margin-top:2%;'>Bun venit in pagina de administrare!</h3></center>

<div class='butoane_stanga'>
    <form action='' method='POST'>
        <center>
        <table border='0' style='width:80%;'>
            <tr><td style='padding:5px;'><button name='adauga' style='width:100%;'>Adauga carte</button></td></tr>
            <tr><td style='padding:5px;'><button name='sterge' style='width:100%;'>Sterge carte</button></td></tr>
            <tr><td style='padding:5px;'><button name='utilizatori' style='width:100%;'>Utilizatori</button></td></tr>
            <tr><td style='padding:5px;'><button name='rezervari' style='width:100%;'>Rezervari</button></td></tr>
        </table></center>
    </form>
</div>
<?php
if(isset($_POST['adauga'])){
    
    echo "<form action='' method='POST' enctype='multipart/form-data'>"
    . "<div class='adauga'><center>"
            . "<h3>Formular adaugare carte</h3>"
            
            . "<table border='0' style='width:60%;'>"
            . "<tr><th style='padding:1%;'>Titlu</th><td><input type='text' name='titlu' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Descriere </th><td><textarea name='descriere' cols='10' rows='10' style='width:100%;'></textarea></td></tr>"
            . "<tr><th style='padding:1%;'>Editura</th><td><input type='text' name='editura' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Autor</th><td><input type='text' name='autor' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Poza</th><td><input type='file' name='poza' id='poza' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Data publicarii</th><td><input type='text' name='data_publicarii' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Nr. carti</th><td><input type='text' name='carti' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'></th><td><input type='submit' name='adauga2' value='Adauga carte' style='width:40%;'/></td></tr>"
            . "</table></center><br><br>"
            . "</div><br><br>"
    . "</form>";
}

if(isset($_POST['adauga2'])){
    $titlu = mysqli_real_escape_string($connect, $_POST['titlu']);
    $descriere = mysqli_real_escape_string($connect, $_POST['descriere']);
    $editura = mysqli_real_escape_string($connect, $_POST['editura']);
    $autor = mysqli_real_escape_string($connect, $_POST['autor']);
    $data_publicarii = mysqli_real_escape_string($connect, $_POST['data_publicarii']);
    $carti = mysqli_real_escape_string($connect, $_POST['carti']);
    
    //upload image
    $errorMessageUpload = '';
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["poza"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $poza = mysqli_real_escape_string($connect, $_FILES["poza"]["name"]);
    
    $check = mysqli_real_escape_string($connect, basename($_FILES["poza"]["name"]));
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $errorMessageUpload .= "File is not an image. ";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $errorMessageUpload .= "Sorry, file already exists. ";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["poza"]["size"] > 500000) {
        $errorMessageUpload .= "Sorry, your file is too large. ";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" 
            && $imageFileType != "gif" ) {
        $errorMessageUpload .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }
    
    if($uploadOk == 0) {?>
        <script>
            var message = "<?php echo $errorMessageUpload;?>";
            alert(message);
        </script>
    <?php }
    
    if((empty($titlu)) OR (empty($descriere)) OR (empty($editura)) OR (empty($autor))
            OR (empty($data_publicarii)) OR (empty($carti)) OR $uploadOk == 0 ){
        ?>
            <script>
                window.location = 'administrare.php';
                alert('Toate campurile trebuie completate!');
            </script>
<?php
    }else{
        $sql = "INSERT INTO carte(titlu, descriere, editura, autor, poza, data_publicarii, nr_carti, data_ad) "
                . "VALUES('$titlu', '$descriere','$editura','$autor','$poza','$data_publicarii', '$carti', NOW())";
        $res = mysqli_query($connect, $sql)or die(mysqli_error());
        $resUpload = 0;
        $errorMessageUpload2 = '';
        
        if (move_uploaded_file($_FILES["poza"]["tmp_name"], $target_file)) {
            $resUpload = 1;
        } else {
            $resUpload = 0;
            $errorMessageUpload2 .= "Sorry, there was an error uploading your file.";
        }
        
        if($res && $resUpload == 1){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Adaugarea a fost realizata cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                var message2 = "<?php echo $errorMessageUpload2;?>";
                alert('Eroare la adaugarea unei noi carti! ' + message2);
            </script>
<?php
        }
    }
}


if(isset($_POST['sterge'])){
    
    $sql = "SELECT * FROM carte WHERE sters <> 1 ORDER BY data_ad ASC ";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    
    echo "<div class='adauga'><center>"
            . "<h3>Formular stergere carte</h3>";
    echo "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Autor</th><th>Editura</th><th>Data publicarii</th><th></th></tr>";
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $id_c = $row['id_c'];
        $titlu = $row['titlu'];
        $autor = $row['autor'];
        $editura = $row['editura'];
        $data_publicarii = $row['data_publicarii'];
        
        echo "<tr style='margin-top:2%;'>"
        . "<td>$crt</td>"
                . "<td>$titlu</td>"
                . "<td>$autor</td>"
                . "<td>$editura</td>"
                . "<td>$data_publicarii</td>"
                . "<td><form action='' method='POST'>"
                . "<input type='text' name='id_c' value='$id_c' hidden/>"
                . "<button name='sterge2' >Sterge</button>"
                . "</form></td></tr>";
        
        $crt = $crt + 1;
    }
    echo "</table><br><br></div><br><br>";
}

if(isset($_POST['sterge2'])){
    $id_c = mysqli_real_escape_string($connect, $_POST['id_c']);
    
    $sql = "UPDATE carte SET sters = '1' WHERE id_c = '$id_c'";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    
    if($res){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Stergerea a fost realizata cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Eroare la stergerea unei carti!');
            </script>
<?php
        }
}

if(isset($_POST['utilizatori'])){
      echo "<div class='adauga'><center>"
            . "<h3>Utilizatori</h3>";
      
      $sql = "SELECT * FROM utilizatori WHERE sters = '0' ORDER BY nume, prenume ASC";
      $res = mysqli_query($connect, $sql)or die(mysqli_error());
      
      echo "<form action='' method='POST'><table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Nume Prenume</th><th>Email</th><th>Utilizator</th><th>Telefon</th><th></th></tr>";
    $crt = 1;
    
    while($row = mysqli_fetch_array($res)){
        $nume = $row['nume'].' '.$row['prenume'];
        $email = $row['email'];
        $utilizator = $row['utilizator'];
        $telefon = $row['telefon'];
        $id_u = $row['id_u'];
        
        echo "<tr><td>$crt</td>"
                . "<td>$nume</td>"
                . "<td>$email</td>"
                . "<td>$utilizator</td>"
                . "<td>$telefon</td>"
                . "<td><form action='' method='POST'>"
                . "<input type='text' name='id_u' value='$id_u' hidden/>"
                . "<button name='sterge3' >Sterge</button>"
                . "</form></td></tr>";
        echo "";
        $crt = $crt + 1;
    }
    echo "</form><table><br><br></div><br><br>";
}

if(isset($_POST['sterge3'])){
    $id_u = mysqli_real_escape_string($connect, $_POST['id_u']);
    
    $sql = "UPDATE utilizatori SET sters = '1' WHERE id_u = '$id_u'";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    
    if($res){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Stergerea a fost realizata cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Eroare la stergerea unui utilizator!');
            </script>
<?php
        }
}


if(isset($_POST['rezervari'])){
    echo "<div class='adauga' style='width:75%;'><center>"
            . "<h3>Gestionare rezervari</h3>";
    echo "<div class='in_curs'>"
    . "<p>Carti in curs de rezervare</p>"
            . "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Editura</th><th>Autor</th><th>Data rezervare</th><th>Utilizator</th><th>Aproba</th></tr>";
    
    $sql = "SELECT c.titlu, c.editura, c.autor, r.data_rez, u.nume, u.prenume, c.id_c, u.id_u, r.id_r FROM rezervare r "
            . "INNER JOIN carte c ON r.id_c = c.id_c "
            . "INNER JOIN utilizatori u ON u.id_u = r.id_u"
            . " WHERE r.status = 'rezervat' AND r.sters = 0";

    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $titlu = $row['titlu'];
        $editura = $row['editura'];
        $autor = $row['autor'];
        $data_rez = $row['data_rez'];
        $utilizator = $row['nume'].' '.$row['prenume'];
        $id_c = $row['id_c'];
        $id_u = $row['id_u'];
        $id_r = $row['id_r'];
         
        
       echo "<tr><td>$crt</td>"
        . "<td>$titlu</td>"
               . "<td>$editura</td>"
               . "<td>$autor</td>"
               . "<td>$data_rez</td>"
               . "<td>$utilizator</td>"
               . "<form action='' method='POST'>"
               . "<input type='text' name='id_r' value='$id_r' hidden/>"
               . "<td><button name='aproba'>Aproba</button></td></form></tr>" ;
       $crt = $crt + 1;
    }
    
            echo "</table><br></div><br><br>";
            
            
           
    echo "<div class='nereturnat'>"
    . "<p>Carti nereturnate</p>"
            . "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Editura</th><th>Autor</th><th>Data rezervare</th><th>Utilizator</th><th>Aproba</th></tr>";
    
    $sql = "SELECT c.titlu, c.editura, c.autor, r.data_rez, u.nume, u.prenume, c.id_c, u.id_u, r.id_r FROM rezervare r "
            . "INNER JOIN carte c ON r.id_c = c.id_c "
            . "INNER JOIN utilizatori u ON u.id_u = r.id_u"
            . " WHERE r.data_exp <= DATE(NOW()) AND r.status = 'imprumutat'";

    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $titlu = $row['titlu'];
        $editura = $row['editura'];
        $autor = $row['autor'];
        $data_rez = $row['data_rez'];
        $utilizator = $row['nume'].' '.$row['prenume'];
        $id_c = $row['id_c'];
        $id_u = $row['id_u'];
        $id_r = $row['id_r'];
         
        
       echo "<tr><td>$crt</td>"
        . "<td>$titlu</td>"
               . "<td>$editura</td>"
               . "<td>$autor</td>"
               . "<td>$data_rez</td>"
               . "<td>$utilizator</td>"
               . "<form action='' method='POST'>"
               . "<input type='text' name='id_r' value='$id_r' hidden/>"
               . "<td><button name='nereturnat'>Nereturnat</button></td></form></tr>" ;
       $crt = $crt + 1;
    }
    
            echo "</table><br></div><br><br>";
    
      echo "<div class='rezervate'>"
    . "<p>Carti imprumutate</p>"
            . "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Editura</th><th>Autor</th><th>Data rezervare</th><th>Utilizator</th><th>Aproba</th></tr>";
    
    $sql = "SELECT c.titlu, c.editura,c.nr_carti,  c.autor, r.data_rez, u.nume, u.prenume, c.id_c, u.id_u, r.id_r FROM rezervare r "
            . "INNER JOIN carte c ON r.id_c = c.id_c "
            . "INNER JOIN utilizatori u ON u.id_u = r.id_u"
            . " WHERE r.data_exp >=  DATE(NOW()) AND r.status = 'imprumutat'";

    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $titlu = $row['titlu'];
        $editura = $row['editura'];
        $autor = $row['autor'];
        $data_rez = $row['data_rez'];
        $utilizator = $row['nume'].' '.$row['prenume'];
        $id_c = $row['id_c'];
        $carti = $row['nr_carti'];
        $id_u = $row['id_u'];
        $id_r = $row['id_r'];
         
        
       echo "<tr><td>$crt</td>"
        . "<td>$titlu</td>"
               . "<td>$editura</td>"
               . "<td>$autor</td>"
               . "<td>$data_rez</td>"
               . "<td>$utilizator</td>"
               . "<form action='' method='POST'>"
               . "<input type='text' name='id_r' value='$id_r' hidden/>"
               . "<input type='text' name='id_c' value='$id_c' hidden/>"
               . "<input type='text' name='carti' value='$carti' hidden/>"
               . "<td><button name='returnat'>Returnare</button></td></form></tr>" ;
       $crt = $crt + 1;
    }
    
            echo "</table><br></div><br><br>";    
            
     echo "<div class='expirate'>"
    . "<p>Carti expirate</p>"
            . "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Editura</th><th>Autor</th><th>Data rezervare</th><th>Utilizator</th><th>Aproba</th></tr>";
    
    $sql = "SELECT c.titlu, c.editura,c.nr_carti,  c.autor, r.data_rez, u.nume, u.prenume, c.id_c, u.id_u, r.id_r FROM rezervare r "
            . "INNER JOIN carte c ON r.id_c = c.id_c "
            . "INNER JOIN utilizatori u ON u.id_u = r.id_u"
            . " WHERE r.data_exp <= DATE(NOW()) AND r.status = 'nereturnat'";

    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $titlu = $row['titlu'];
        $editura = $row['editura'];
        $autor = $row['autor'];
        $data_rez = $row['data_rez'];
        $utilizator = $row['nume'].' '.$row['prenume'];
        $id_c = $row['id_c'];
        $carti = $row['nr_carti'];
        $id_u = $row['id_u'];
        $id_r = $row['id_r'];
         
        
       echo "<tr><td>$crt</td>"
        . "<td>$titlu</td>"
               . "<td>$editura</td>"
               . "<td>$autor</td>"
               . "<td>$data_rez</td>"
               . "<td>$utilizator</td>"
               . "<td><form action='' method='POST'>"
                . "<input type='text' name='id_r' value='$id_r' hidden/>"
               . "<input type='text' name='id_c' value='$id_c' hidden/>"
               . "<input type='text' name='carti' value='$carti' hidden/>"
                . "<button name='returnat' >Returnare</button>"
                . "</form></td></tr>" ;
       $crt = $crt + 1;
    }
    
            echo "</table><br></div><br><br>";         
          
            
              echo "<div class='returnate'>"
    . "<p>Carti returnate</p>"
            . "<table border='0' style='width:90%;'>"
    . "<tr><th>Nr. Crt</th><th>Titlu</th><th>Editura</th><th>Autor</th><th>Data rezervare</th><th>Utilizator</th></tr>";
    
    $sql = "SELECT c.titlu, c.editura,c.nr_carti,  c.autor, r.data_rez, u.nume, u.prenume, c.id_c, u.id_u, r.id_r FROM rezervare r "
            . "INNER JOIN carte c ON r.id_c = c.id_c "
            . "INNER JOIN utilizatori u ON u.id_u = r.id_u"
            . " WHERE  r.status = 'returnat'";

    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $crt = 1;
    while($row = mysqli_fetch_array($res)){
        $titlu = $row['titlu'];
        $editura = $row['editura'];
        $autor = $row['autor'];
        $data_rez = $row['data_rez'];
        $utilizator = $row['nume'].' '.$row['prenume'];
        $id_c = $row['id_c'];
        $carti = $row['nr_carti'];
        $id_u = $row['id_u'];
        $id_r = $row['id_r'];
         
        
       echo "<tr><td>$crt</td>"
        . "<td>$titlu</td>"
               . "<td>$editura</td>"
               . "<td>$autor</td>"
               . "<td>$data_rez</td>"
               . "<td>$utilizator</td>"
               ."</tr>" ;
       
       $crt = $crt + 1;
    }
    
            echo "</table><br></div><br><br>";  
    echo "</div><br><br></center><br>";
}

if(isset($_POST['aproba'])){
    $id_r = mysqli_real_escape_string($connect, $_POST['id_r']);
    
    
    $sql = "UPDATE rezervare SET data_exp = DATE(adddate(NOW(), INTERVAL 3 week)), status = 'imprumutat' WHERE id_r = '$id_r'";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    
    if($res){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Cartea a fost aprobata cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Eroare la imprumutarea carti!');
            </script>
<?php
        }
}

if(isset($_POST['nereturnat'])){
    $id_r = mysqli_real_escape_string($connect, $_POST['id_r']);
    
    
    $sql = "UPDATE rezervare SET  status = 'nereturnat' WHERE id_r = '$id_r'";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    
    if($res){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Statusul a fost schimbat cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Eroare la schimbarea statusului!');
            </script>
<?php
        }
}

if(isset($_POST['returnat'])){
    $id_r = mysqli_real_escape_string($connect, $_POST['id_r']);
    $id_c = mysqli_real_escape_string($connect, $_POST['id_c']);
    $carti = mysqli_real_escape_string($connect, $_POST['carti']);
    
    $carti_nou = $carti + 1;
    $sql = "UPDATE rezervare SET  status = 'returnat' WHERE id_r = '$id_r'";
    $sql2 = "UPDATE carte SET nr_carti = '$carti_nou' WHERE id_c = '$id_c'";
    $res = mysqli_query($connect, $sql)or die(mysqli_error());
    $res2 = mysqli_query($connect, $sql2)or die(mysqli_error());
    
    if($res AND $res2){
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Statusul a fost schimbat cu succes!');
            </script>
<?php
        }else{
            ?>
            <script>
                window.location = 'administrare.php';
                alert('Eroare la schimbarea statusului!');
            </script>
<?php
        }
}
?>








</body>

