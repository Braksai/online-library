<?php
include_once 'header.php';
include_once 'connect.php';
?>
<center><table border="0" style="width:60%;">
        <tr><td>Nr. Crt</td><td>Titlu</td><td>Autor</td><td>Data rezervarii</td><td>Data expirare</td><td>Stare</td></tr>
<?php
$utilizator = $_SESSION['id'];
 $sql = "SELECT c.titlu, c.autor, r.data_rez, r.data_exp,c.status FROM carte c 
        INNER JOIN rezervare r ON r.id_c = c.id_c 
        INNER JOIN utilizatori u ON r.id_u = u.id_u
        WHERE r.id_u = '$utilizator'";
 $res = mysqli_query($connect, $sql) or die(mysqli_error());
 $crt = 1;
 while($row= mysqli_fetch_assoc ($res)){
     
     if($row['stare'] == 'nereturnat'){
         echo " <tr style='background-color:red;'><td>'$crt'</td>"
                 . "<td>".$row['titlu']."</td>"
                 . "<td>".$row['autor']."</td>"
                 . "<td>".$row['data_rez']."</td>"
                 . "<td>".$row['data_exp']."</td>"
                 . "<td>".$row['status']."</td>"
                 . "</tr>";
     }else{
          echo " <tr'><td>$crt</td>"
                 . "<td>".$row['titlu']."</td>"
                 . "<td>".$row['autor']."</td>"
                 . "<td>".$row['data_rez']."</td>"
                 . "<td>".$row['data_exp']."</td>"
                  . "<td>".$row['status']."</td>"
                 . "</tr>";
     }
     $crt = $crt + 1;
 }
?>
    
    
    
    </table></center>

