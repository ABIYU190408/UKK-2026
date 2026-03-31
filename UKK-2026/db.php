<?php
 $hostname = 'localhost'    ;
 $localhost= 'root'        ;
 $password = ''           ;
 $dbname   = 'db_aspirasi';

$conn = mysqli_connect ( $hostname,$localhost,$password,$dbname) or die ('koneksi gagal');  
?>