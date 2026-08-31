```php
<?php

session_start();

require_once "../../config/db.php";

/* =========================================
   ADMIN LOGIN CHECK
========================================= */

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}


/* =========================================
   GET GALLERY ID
========================================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];


/* =========================================
   FETCH GALLERY ITEM
========================================= */

$sql = "SELECT * FROM gallery WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$item) {
    header("Location: index.php");
    exit();
}


/* =========================================
   UPDATE GALLERY ITEM
========================================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    /* Keep old image */
    $image = $item['image'];


    /* =====================================
       VALIDATION
    ===================================== */

    if ($title === "" || $category === "") {

        $error = "Please fill in all required fields.";

    } else {


        /* =====================================
           IMAGE UPLOAD
        ===================================== */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === 0
        ) {

            $uploaded_image = $_FILES['image'];

            $allowed_extensions = [
                "jpg",
                "jpeg",
                "png",
                "webp"
            ];

            $extension = strtolower(
                pathinfo(
                    $uploaded_image['name'],
                    PATHINFO_EXTENSION
                )
            );


            if (!in_array($extension, $allowed_extensions)) {

                $error =
                    "Only JPG, JPEG, PNG and WEBP images are allowed.";

            } elseif ($uploaded_image['size'] > 5 * 1024 * 1024) {

                $error =
                    "Image size must be less than 5MB.";

            } else {

                /* Create upload folder */

                $upload_folder = "../../images/gallery/";

                if (!is_dir($upload_folder)) {
                    mkdir($upload_folder, 0777, true);
                }


                /* Unique filename */

                $new_name =
                    time() . "_" .
                    uniqid() . "." .
                    $extension;


                $upload_path =
                    $upload_folder . $new_name;


                /* Upload image */

                if (
                    move_uploaded_file(
                        $uploaded_image['tmp_name'],
                        $upload_path
                    )
                ) {

                    /* Delete old image */

                    if (!empty($item['image'])) {

                        $old_image =
                            "../../" . $item['image'];

                        if (file_exists($old_image)) {
                            unlink($old_image);
                        }
                    }


                    /* Database image path */

                    $image =
                        "images/gallery/" . $new_name;

                } else {

                    $error =
                        "Failed to upload image.";

                }
            }
        }


        /* =====================================
           UPDATE DATABASE
        ===================================== */

        if (!isset($error)) {

            $sql = "UPDATE gallery
                    SET title = ?,
                        category = ?,
                        image = ?,
                        description = ?,
                        status = ?
                    WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssii",
                $title,
                $category,
                $image,
                $description,
                $status,
                $id
            );


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: index.php?updated=1");
                exit();

            } else {

                $error =
                    "Failed to update gallery item.";

            }

            mysqli_stmt_close($stmt);
        }
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Edit Gallery | Quetta Super Shandar Hotel
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >


    <style>

        body {
            background: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .edit-wrapper {
            max-width: 850px;
            margin: 50px auto;
            padding: 0 15px;
        }

        .edit-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .edit-header {
            background: linear-gradient(
                135deg,
                #970019,
                #d20b32
            );
            color: white;
            padding: 25px 30px;
        }

        .edit-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .edit-header p {
            margin: 5px 0 0;
            opacity: .9;
        }

        .edit-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control,
        .form-select {
            padding: 11px 13px;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #c8102e;
            box-shadow:
                0 0 0 3px rgba(200,16,46,.10);
        }

        .current-image {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f5b400;
            margin-top: 8px;
        }

        .btn-update {
            background: #f5b400;
            color: #111;
            border: none;
            padding: 11px 24px;
            border-radius: 8px;
            font-weight: 700;
        }

        .btn-update:hover {
            background: #d99d00;
            color: white;
        }

        .btn-back {
            background: #eee;
            color: #333;
            padding: 11px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #ddd;
            color: #222;
        }

    </style>

</head>


<body>


<div class="edit-wrapper">

    <div class="edit-card">


        <!-- HEADER -->

        <div class="edit-header">

            <h2>
                <i class="bi bi-pencil-square"></i>
                Edit Gallery Item
            </h2>

            <p>
                Update gallery image and information.
            </p>

        </div>


        <!-- BODY -->

        <div class="edit-body">


            <?php if (isset($error)): ?>

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle"></i>

                    <?php
                    echo htmlspecialchars($error);
                    ?>

                </div>

            <?php endif; ?>


            <form
                method="POST"
                enctype="multipart/form-data"
            >


                <!-- TITLE -->

                <div class="mb-3">

                    <label class="form-label">
                        Gallery Title *
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?php
                        echo htmlspecialchars($item['title']);
                        ?>"
                        required
                    >

                </div>


                <!-- CATEGORY -->

                <div class="mb-3">

                    <label class="form-label">
                        Category *
                    </label>

                    <select
                        name="category"
                        class="form-select"
                        required
                    >

                        <option value="Hotel"
                            <?php
                            if ($item['category'] === 'Hotel')
                                echo 'selected';
                            ?>>
                            Hotel
                        </option>

                        <option value="Restaurant"
                            <?php
                            if ($item['category'] === 'Restaurant')
                                echo 'selected';
                            ?>>
                            Restaurant
                        </option>

                        <option value="Food"
                            <?php
                            if ($item['category'] === 'Food')
                                echo 'selected';
                            ?>>
                            Food
                        </option>

                        <option value="Rooms"
                            <?php
                            if ($item['category'] === 'Rooms')
                                echo 'selected';
                            ?>>
                            Rooms
                        </option>

                        <option value="Events"
                            <?php
                            if ($item['category'] === 'Events')
                                echo 'selected';
                            ?>>
                            Events
                        </option>

                        <option value="Other"
                            <?php
                            if ($item['category'] === 'Other')
                                echo 'selected';
                            ?>>
                            Other
                        </option>

                    </select>

                </div>


                <!-- DESCRIPTION -->

                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    ><?php
                    echo htmlspecialchars(
                        $item['description']
                    );
                    ?></textarea>

                </div>


                <!-- CURRENT IMAGE -->

                <div class="mb-3">

                    <label class="form-label">
                        Current Image
                    </label>

                    <br>

                    <?php if (!empty($item['image'])): ?>

                        <img
                            src="../../<?php
                            echo htmlspecialchars($item['image']);
                            ?>"
                            class="current-image"
                            alt="Gallery Image"
                        >

                    <?php else: ?>

                        <p class="text-muted">
                            No image uploaded.
                        </p>

                    <?php endif; ?>

                </div>


                <!-- NEW IMAGE -->

                <div class="mb-3">

                    <label class="form-label">
                        Change Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted">
                        Leave empty to keep the current image.
                        Maximum size: 5MB.
                    </small>

                </div>


                <!-- STATUS -->

                <div class="mb-4">

                    <label class="form-label">
                        Status
                    </label>

                    <div class="form-check form-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="status"
                            <?php
                            if ($item['status'] == 1)
                                echo 'checked';
                            ?>
                        >

                        <label
                            class="form-check-label"
                            for="status"
                        >
                            Show this image on the public gallery
                        </label>

                    </div>

                </div>


                <!-- BUTTONS -->

                <div class="d-flex gap-2">

                    <a
                        href="index.php"
                        class="btn-back"
                    >

                        <i class="bi bi-arrow-left"></i>
                        Back

                    </a>


                    <button
                        type="submit"
                        class="btn-update"
                    >

                        <i class="bi bi-check-circle"></i>
                        Update Gallery

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


</body>

</html>
```
