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
    
    echo "<form action='' method='POST'>"
    . "<div class='adauga'><center>"
            . "<h3>Formular adaugare carte</h3>"
            
            . "<table border='0' style='width:60%;'>"
            . "<tr><th style='padding:1%;'>Titlu</th><td><input type='text' name='titlu' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Descriere </th><td><textarea name='descriere' cols='10' rows='10' style='width:100%;'></textarea></td></tr>"
            . "<tr><th style='padding:1%;'>Editura</th><td><input type='text' name='editura' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Autor</th><td><input type='text' name='autor' style='width:100%;'/></td></tr>"
            . "<tr><th style='padding:1%;'>Poza</th><td><input type='file' name='poza' style='width:100%;'/></td></tr>"
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
    $poza = mysqli_real_escape_string($connect, $_POST['poza']);
    $data_publicarii = mysqli_real_escape_string($connect, $_POST['data_publicarii']);
    $carti = mysqli_real_escape_string($connect, $_POST['carti']);
    
    
    if((empty($titlu)) OR (empty($descriere)) OR (empty($editura)) OR (empty($autor))
            OR (empty($data_publicarii)) OR (empty($carti))){
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
        
        if($res){
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
                alert('Eroare la adaugarea unei noi carti!');
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
                . "</form></th></tr>";
        
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
      
      $sql = "SELECT * FROM utilizatori ORDER BY nume, prenume ASC";
      $res = mysqli_query($connect, $sql)or die(mysqli_error());
      
      echo "<table border='0' style='width:90%;'>"
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
                . "<form action='' method='POST'>"
                . "<input type='text' name='id_u' value='$id_u' hidden/>"
                . "<th><button name='sterge3'>Sterge</button></th></tr>";
        $crt = $crt + 1;
    }
    echo "<table><br><br></div><br><br>";
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
?>








</body>

