<?php
include_once 'header.php';
include_once 'connect.php';
?>
<div class="container">
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
                        $sql = "SELECT c.id_c ,c.titlu, c.autor, r.data_rez, r.data_exp, r.status FROM carte c 
        INNER JOIN rezervare r ON r.id_c = c.id_c 
        INNER JOIN utilizatori u ON r.id_u = u.id_u
        WHERE r.id_u = '$utilizator'";
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
                                    echo '<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal' . $row['id_c'] . '"><i class="fa fa-times text-danger" aria-hidden="true"></i></button></td>';
                                    echo '
                                <div class="modal fade" id="myModal' . $row['id_c'] . '" role="dialog">
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
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-trash" aria-hidden="true"></i> Da</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> Nu</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
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
