<?php
session_start();
require "../../config/db_connection.php";

$email = $_POST['emailalias'];
$pass = $_POST['passwd'];
$enc_pass = md5($pass);

$query = "SELECT * FROM users WHERE email = '$email' AND password = '$enc_pass'";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
}

$row = pg_fetch_assoc($result);

if ($row) {
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['first_name'] = $row['first_name'];
    $_SESSION['last_name'] = $row['last_name'];
    $_SESSION['email'] = $row['email'];
    header('Location: ../index.html');
    exit();
} else {
    echo "<script>alert('¡Email o contraseña incorrectos!')</script>";
    header('refresh:0; url=../login.html');
    exit();
}

pg_close($conn);
?>
