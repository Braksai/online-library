<?php
include_once 'connect.php';
include_once 'header.php';
?>

<?php

$whereSearch = '';
$urlParamSearch = '';
$list = '';
$texthelper1 = '';
$texthelper2 = '';
$messageErrorNoBooks = '';
$paginationStructure = '';
if(isset($_GET['search'])){
    $querySearch = $_GET['search']; 
    $min_length = 3;
    if(strlen($querySearch) >= $min_length){
        $querySearch = htmlspecialchars($querySearch); 
        $querySearch = mysql_real_escape_string($querySearch);
        $urlParamSearch = empty($querySearch) ? '': 'search='.$querySearch.'&';
        $whereSearch = "AND titlu LIKE '%".$querySearch."%'";
    }
}
$sql = "SELECT COUNT(id_c) FROM carte WHERE sters=0 ".$whereSearch;
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_row($query);
$rows = $row[0];
if($rows > 0) {
    $page_rows = 2;// numar de carti vizualizate per pagina
    $last = ceil($rows/$page_rows);
    if($last < 1){
        $last = 1;
    }
    $pagenum = 1;
    if(isset($_GET['pageNr'])){
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pageNr']);
    }
    if ($pagenum < 1) {
        $pagenum = 1;
    } else if ($pagenum > $last) {
        $pagenum = $last;
    }
    $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
    $sql = "SELECT id_c, titlu, poza FROM carte WHERE sters=0 ". $whereSearch ."ORDER BY id_c DESC $limit";
    $query = mysqli_query($connect, $sql);
    $texthelper1 = "Numar carti totale: (<b>$rows</b>)";
    $texthelper2 = "Pagina <b>$pagenum</b> din <b>$last</b>";
    $paginationStructure = '<ul class="pagination">';
    if($last != 1){
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParamSearch.'pageNr='.$previous.'">«</a></li>';
            for($i = $pagenum-4; $i < $pagenum; $i++){
                if($i > 0){
                $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParamSearch.'pageNr='.$i.'">'.$i.'</a></li>';
                }
            }
        }
        $paginationStructure .= '<li class="active active-btn-pagination"><a href="">'.$pagenum.'</a></li>';
        for($i = $pagenum+1; $i <= $last; $i++){
                $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParamSearch.'pageNr='.$i.'">'.$i.'</a></li>';
                if($i >= $pagenum+4){
                        break;
                }
        }
        if ($pagenum != $last) {
            $next = $pagenum + 1;
            $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParamSearch.'pageNr='.$next.'">»</a></li> ';
        }
        $paginationStructure .= '</ul>';
    }
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        $id = $row["id_c"];
        $poza = $row["poza"];
        $titlu = $row["titlu"];
        $list.=
        '<div class="col-lg-3 col-md-4 col-xs-6 thumb">
            <a class="thumbnail" href="book.php?id_c='.$id.'">
                <img class="img-responsive book" src="images/'.$poza.'" alt="">
                <p class="title-book truncate">'.$titlu.'</p>
            </a>
        </div>';
    }
} else {
    $messageErrorNoBooks = "Nu exista carti";
    if ($querySearch) {
        $messageErrorNoBooks .= " cu numele ".$querySearch;
    }
    $messageErrorNoBooks .= "!";
}
?>

<!DOCTYPE html>


<!-- Page Content -->
<div class="container">

    <div class="row">
        <form action="" id="search-book" method="GET" accept-charset="UTF-8">
            <div>
                <h2 style="text-align: center;">Cautare carte</h2>
                <div class="input-group col-lg-6 col-lg-offset-3">
                    <label class="input-group-addon" for="edit-search-block-form--2">Cauta </label>
                    <input title="Gaseste orice in librarie. Scrie numele cartii." 
                           autocomplete="off" tabindex="1" 
                           placeholder="Gaseste orice in librarie. Scrie numele cartii." 
                           type="search" 
                           name="search" 
                           value="<?php echo !empty($querySearch) ? $querySearch : '';?>" size="60" 
                           maxlength="128" 
                           class="form-control">
                    <span onclick="document.getElementById('search-book').submit();" class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </div>
        </form>
    </div>
    <?php if ($messageErrorNoBooks) { ?>
        <div class="row" style="margin-top: 30px;">
            <p class="mt15 alert alert-warning text-center" style="width: 300px; margin: 0 auto;"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $messageErrorNoBooks;?></p>
        </div>
    <?php } ?>
    <div class="row" style="margin-top: 30px;">
        <?php echo $list;?>
    </div>
    <div class="row text-center"><?php echo $paginationStructure; ?></div>
    <div class="row text-center"><?php echo $texthelper2.' , '.$texthelper1; ?></div>
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