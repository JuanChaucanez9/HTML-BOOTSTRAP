<?php
$host = "localhost";
$port = "5432";
$username = "postgres";
$dbname = "hdoc";
$password = "unicesmag";

$data_connection = "
host=$host
port=$port
dbname=$dbname
user=$username
password=$password
";

$conn = pg_connect($data_connection);
if (!$conn) {
    die("Error en la conexión: " . pg_last_error());
} else {
    echo "Conexión exitosa";
}
?>
