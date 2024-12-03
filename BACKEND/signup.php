<?php 
function save_data_supabase($emailalias, $passwd) {
    $SUPABASE_URL = 'https://anbfscwxhcpoyizceyxs.supabase.co';
    $SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmZzZSIsInJlZiI6ImFuYmZzY3d4aGNwb3lpemNleXhzIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAzODg2ODYsImV4cCI6MjA0NTk2NDY4Nn0.33xy3Ou5xh4k_HlCO9ZTgdWWFfcL0_ddEUH9D6Wt-g4';

    $url = "$SUPABASE_URL/rest/v1/users";
    $data = [
        'email' => $emailalias,
        'password' => $passwd,
    ];

    $options = [
        'http' => [
            'header' => [
                "Content-Type: application/json",
                "Authorization: Bearer $SUPABASE_KEY",
                "apikey: $SUPABASE_KEY"
            ],
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        echo "Error al conectar con Supabase";
    } else {
        echo "Respuesta de Supabase: " . $response;
    }
}

require "../../config/db_connection.php";

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['emailalias'];
$pass = $_POST['passwd'];
$repeatPass = $_POST['repeatPassword'];


if ($pass !== $repeatPass) {
    echo "<script>alert('¡Las contraseñas no coinciden!')</script>";
    header('refresh:0; url=../register_form.html');
    exit();
}

$enc_pass = md5($pass);

$query = "SELECT * FROM users WHERE email = '$email'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);

if ($row) {
    echo "<script>alert('¡El email ya existe!')</script>";
    header('refresh:0; url=../register_form.html');
    exit();
}

$query = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$enc_pass')";
$result = pg_query($conn, $query);

if ($result) {
    save_data_supabase($email, $enc_pass);
    echo "<script>alert('¡Registro exitoso!')</script>";
    header('Location: view_users.php');
    exit();
} else {
    echo "Error en el registro!";
}

pg_close($conn);
?>
