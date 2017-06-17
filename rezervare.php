<?php
include_once 'header.php';
include_once 'connect.php';
?>
<div class="container" style="min-height: 720px;">
    <div class="row book-description" style="margin-top: 30px;">
        <div class="panel panel-default">
            <div class="panel-heading dark-blue-bg" style="color: #FFF; font-size: 18px;">
                <i class="fa fa-book" aria-hidden="true"></i> Lista carti rezervate
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <tr><th>Nr. Crt</th><th>Titlu</th><th>Autor</th><th>Data rezervarii</th><th>Data expirare</th><th>Stare</th><th>Actiuni</th></tr>
                        <?php
                        $utilizator = $_SESSION['id'];
                        if(isset($_POST['sterge'])){
                           $idRezervare = mysqli_real_escape_string($connect, $_POST['id_r']);
                           $idCarte = mysqli_real_escape_string($connect, $_POST['id_c']);
                           $nrCarti = mysqli_real_escape_string($connect, $_POST['carti']);
                           $carti_nou = $nrCarti + 1;
                           $sql = "UPDATE rezervare SET sters = 1 WHERE id_r = '$idRezervare' AND id_u ='$utilizator'";
                           $sql2 = "UPDATE carte SET nr_carti = '$carti_nou' WHERE id_c = '$idCarte'";
                           $res = mysqli_query($connect, $sql)or die(mysqli_error());
                           $res2 = mysqli_query($connect, $sql2)or die(mysqli_error());
                           if($res && $res2){?>
                            <script>
                                //alert('Rezervarea a fost stearsa cu succes!');
                            </script>
                            <?php }else{ ?>    
                            <script>
                                alert('Eroare la stergerea rezervarii!');
                            </script>
                        <?php }
                        }
                        $sql = "SELECT c.id_c ,c.titlu, c.autor, c.nr_carti, r.id_r, r.data_rez, r.data_exp, r.status FROM carte c 
                                INNER JOIN rezervare r ON r.id_c = c.id_c 
                                INNER JOIN utilizatori u ON r.id_u = u.id_u
                                WHERE r.id_u = '$utilizator' AND r.sters = 0";
                        $res = mysqli_query($connect, $sql) or die(mysqli_error());
                        $crt = 1;
                        while ($row = mysqli_fetch_assoc($res)) {

                            if ($row['status'] == 'nereturnat') {
                                echo " <tr>"
                                . "<td>$crt</td>"
                                . "<td>" . $row['titlu'] . "</td>"
                                . "<td>" . $row['autor'] . "</td>"
                                . "<td>" . $row['data_rez'] . "</td>"
                                . "<td>" . $row['data_exp'] . "</td>"
                                . '<td class="text-danger">' . $row['status'] . ' <i class="fa fa-exclamation-circle" style="font-size: 20px;" aria-hidden="true"></i></td>'
                                . '<td><button type="button" class="btn btn-default" disabled><i class="fa fa-times text-danger" aria-hidden="true"></i></button> ' . '</td>'
                                . "</tr>";
                            } else {
                                echo " <tr'>"
                                . "<td>$crt</td>"
                                . "<td>" . $row['titlu'] . "</td>"
                                . "<td>" . $row['autor'] . "</td>"
                                . "<td>" . $row['data_rez'] . "</td>"
                                . "<td>" . $row['data_exp'] . "</td>"
                                . "<td>" . $row['status'] . "</td>";
                                if ($row['status'] == 'rezervat') {
                                    echo '<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal' . $row['id_r'] . '"><i class="fa fa-times text-danger" aria-hidden="true"></i></button>';
                                    echo '
                                <div class="modal fade" id="myModal' . $row['id_r'] . '" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Anulare Rezervare</h4>
                                      </div>
                                      <div class="modal-body">
                                        <p>Doresti sa anulezi rezervarea pentru cartea ' . $row['titlu'] . '?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form name="sterge'.$row["id_r"].'" action="" method="POST">
                                            <input type="hidden" name="id_r" value="'.$row["id_r"].'" />
                                            <input type="hidden" name="id_c" value="'.$row["id_c"].'" />
                                            <input type="hidden" name="carti" value="'.$row["nr_carti"].'" />
                                            <button type="submit" name="sterge" class="btn btn-default"><i class="fa fa-trash" aria-hidden="true"></i> Da</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> Nu</button>
                                        </form>
                                        </div>
                                    </div>
                                  </div>
                                </div></td>';
                                } else {
                                    echo '<td><button type="button" class="btn btn-default" disabled><i class="fa fa-times text-danger" aria-hidden="true"></i></button></td>';
                                }
                                echo "</tr>";
                                
                            }
                            $crt = $crt + 1;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php';?>