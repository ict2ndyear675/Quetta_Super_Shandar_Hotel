<?php

session_start();

require_once "../../config/db.php";

/* =========================================
   CHECK ADMIN LOGIN
========================================= */

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}


/* =========================================
   CHECK ITEM ID
========================================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];


/* =========================================
   GET ITEM INFORMATION
   We need the image path before deleting
========================================= */

$sql = "SELECT image FROM menu_items WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$item = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =========================================
   ITEM NOT FOUND
========================================= */

if (!$item) {
    header("Location: index.php");
    exit();
}


/* =========================================
   DELETE DATABASE RECORD
========================================= */

$sql = "DELETE FROM menu_items WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    /* =====================================
       DELETE IMAGE FROM SERVER
    ===================================== */

    if (!empty($item['image'])) {

        $image_path = "../../" . $item['image'];

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    header("Location: index.php?deleted=1");
    exit();

} else {

    mysqli_stmt_close($stmt);

    header("Location: index.php?error=delete");
    exit();
}

?>