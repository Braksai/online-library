<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GiftBox</title>
    <link rel="stylesheet" type="text/css" href="css.css"/>
</head>
<body>
<?php
session_start();
if(empty($_SESSION['id_utilizator'])){
    echo "<div class='autentificare'>
    <table border='0' style='width:99%'>
        <tr><th style='width:20%'><span style='color:white'>Sunati-ne acum la: Nr de telefon</span></th>
            <th style='width:50%;'></th>
            <th><a href='autentificare.php' style='color:white;float:right;text-decoration: none'>Autentificare  | </a></th>
            <th><a href='inregistrare.php' style='color:white;float:left;margin-left:3%;text-decoration: none'>Inregistrare</a></th>
        </tr>
    </table>
</div>";
}else{
    if($_SESSION['acces'] == 1){
        echo "<div class='autentificare'>
    <table border='0' style='width:99%'>
        <tr><th style='width:20%'><span style='color:white'>Sunati-ne acum la: Nr de telefon</span></th>
            <th style='width:50%;'></th>
            <th style='width:10%;'><a href='administrator.php?cod=0' style='color:white;float:right;text-decoration: none'>Administrare  | </a></th>
            <th style='width:10%;'><a href='cos_cumparaturi.php' style='color:white;float:right;text-decoration: none'>Cos cumparaturi  | </a></th>
            <th style='width:10%;'><a href='deconectare.php' style='color:white;float:left;margin-left:3%;text-decoration: none'>Deconectare</a></th>
        </tr>
    </table>
</div>";
    }else{
    echo "<div class='autentificare'>
    <table border='0' style='width:99%'>
        <tr><th style='width:20%'><span style='color:white'>Sunati-ne acum la: Nr de telefon</span></th>
            <th style='width:50%;'></th>
            <th><a href='cos_cumparaturi.php' style='color:white;float:right;text-decoration: none'>Cos cumparaturi  | </a></th>
            <th><a href='deconectare.php' style='color:white;float:left;margin-left:3%;text-decoration: none'>Deconectare</a></th>
        </tr>
    </table>
</div>";
}
}
echo "<center>
<form action='cauta.php' method='POST'>
<table border='0' style='width:70%;'>
<tr><th style='width:40%;'><a href='index.php'><img src='images/logo.png' class='logo' ></a></th>
<th><center>
<table border='0' style='width:80%;'>
<tr>
<th><img src='images/cauta.png' class='cauta'></th>
<th><input type='text' name='text_cauta' style='width:100%;' placeholder='Cauta ...'/> </th>
<th><button name='cauta' class='buton' style='margin-left:20%;'/>Cauta</button></th></tr>
</table></center>
</th></tr>
</table>
</form>
</center>";
