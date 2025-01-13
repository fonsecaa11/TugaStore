<?php
$servername = "sql111.infinityfree.com";
$username = "if0_37902111";
$password = "82eTQw4609BxR";
$dbname = "if0_37902111_tugastore";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    echo "Erro ao aceder à base de dados: $e";
}

mysqli_set_charset($conn, 'utf8');
?>