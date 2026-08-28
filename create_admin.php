<?php

require_once "config/db.php";

$username = "admin";
$email = "admin@quettahotel.com";
$password = "admin123";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (username, email, password)
        VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $email,
    $hashed_password
);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>