<?php

require "../../config/db_connection.php";


$query = "SELECT id, first_name, last_name, email, status, created_at FROM users";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
}

$users = [];
while ($row = pg_fetch_assoc($result)) {
    $users[] = $row;
}

header('Content-Type: application/json');
echo json_encode($users);

pg_close($conn);
?>
