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
            OR (empty($poza)) OR (empty($data_publicarii)) OR (empty($carti))){
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
?>








</body>

