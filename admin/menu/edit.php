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
   GET MENU ITEM ID
========================================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];


/* =========================================
   FETCH MENU ITEM
========================================= */

$sql = "SELECT * FROM menu_items WHERE id = ?";

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
   UPDATE MENU ITEM
========================================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
  $status = isset($_POST['status']) ? (int) $_POST['status'] : 0;

    /* Keep old image by default */
    $image = $item['image'];


    /* =====================================
       IMAGE UPLOAD
    ===================================== */

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $upload_dir = "../../images/menu/";

        /* Create folder if it doesn't exist */
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $extension = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );

        $allowed_extensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];

        if (in_array($extension, $allowed_extensions)) {

            $new_name = time() . "_" . uniqid() . "." . $extension;

            $upload_path = $upload_dir . $new_name;

            if (move_uploaded_file($tmp_name, $upload_path)) {

                /* Delete old image if it exists */
                if (!empty($item['image'])) {

                    $old_image = "../../" . $item['image'];

                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }

                $image = "images/menu/" . $new_name;
            }
        }
    }


    /* =====================================
       UPDATE DATABASE
    ===================================== */

    $sql = "UPDATE menu_items
            SET name = ?,
                category = ?,
                description = ?,
                price = ?,
                image = ?,
                status = ?,
                updated_at = NOW()
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $name,
        $category,
        $description,
        $price,
        $image,
        $status,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: index.php?updated=1");
        exit();

    } else {

        $error = "Failed to update menu item.";
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Menu Item | Quetta Super Shandar Hotel</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
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
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .edit-header {
            background: #c8102e;
            color: #ffffff;
            padding: 25px 30px;
        }

        .edit-header h2 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
        }

        .edit-header p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.9;
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
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #c8102e;
            box-shadow: 0 0 0 0.15rem rgba(200, 16, 46, 0.15);
        }

        .current-image {
            width: 140px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ffc107;
            margin-top: 8px;
        }

        .btn-update {
            background: #c8102e;
            color: #ffffff;
            border: none;
            padding: 11px 24px;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-update:hover {
            background: #a9001f;
            color: #ffffff;
        }

        .btn-back {
            background: #eeeeee;
            color: #333;
            padding: 11px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #dddddd;
            color: #222;
        }

        @media (max-width: 576px) {

            .edit-wrapper {
                margin: 25px auto;
            }

            .edit-header,
            .edit-body {
                padding: 20px;
            }

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
                Edit Menu Item
            </h2>

            <p>
                Update the information of this menu item.
            </p>

        </div>


        <!-- FORM -->

        <div class="edit-body">

            <?php if (isset($error)): ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form
                method="POST"
                enctype="multipart/form-data"
            >

                <!-- NAME -->

                <div class="mb-3">

                    <label class="form-label">
                        Menu Item Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($item['name']); ?>"
                        required
                    >

                </div>


                <!-- CATEGORY -->

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select
                        name="category"
                        class="form-select"
                        required
                    >

                        <option value="Breakfast"
                            <?php if ($item['category'] === 'Breakfast') echo 'selected'; ?>>
                            Breakfast
                        </option>

                        <option value="Chai & Kahwa"
                            <?php if ($item['category'] === 'Chai & Kahwa') echo 'selected'; ?>>
                            Chai & Kahwa
                        </option>

                        <option value="Paratha"
                            <?php if ($item['category'] === 'Paratha') echo 'selected'; ?>>
                            Paratha
                        </option>

                        <option value="Traditional Food"
                            <?php if ($item['category'] === 'Traditional Food') echo 'selected'; ?>>
                            Traditional Food
                        </option>

                        <option value="Karahi"
                            <?php if ($item['category'] === 'Karahi') echo 'selected'; ?>>
                            Karahi
                        </option>

                        <option value="Rice"
                            <?php if ($item['category'] === 'Rice') echo 'selected'; ?>>
                            Rice
                        </option>

                        <option value="Other"
                            <?php if ($item['category'] === 'Other') echo 'selected'; ?>>
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
                        required
                    ><?php echo htmlspecialchars($item['description']); ?></textarea>

                </div>


                <!-- PRICE -->

                <div class="mb-3">

                    <label class="form-label">
                        Price (Rs.)
                    </label>

                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        value="<?php echo htmlspecialchars($item['price']); ?>"
                        min="0"
                        required
                    >

                </div>


                <!-- CURRENT IMAGE -->

                <div class="mb-3">

                    <label class="form-label">
                        Current Image
                    </label>

                    <?php if (!empty($item['image'])): ?>

                        <br>

                        <img
                            src="../../<?php echo htmlspecialchars($item['image']); ?>"
                            class="current-image"
                            alt="Current Menu Image"
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
                        Leave empty if you want to keep the current image.
                    </small>

                </div>


                <!-- STATUS -->

                <div class="mb-4">

                    <label class="form-label">
                        Status
                    </label>

              <select 
    name="status" 
    class="form-select" 
    required
>

    <option value="1" 
        <?php if ((int)$item['status'] === 1) echo 'selected'; ?>>
        Active
    </option>

    <option value="0" 
        <?php if ((int)$item['status'] === 0) echo 'selected'; ?>>
        Inactive
    </option>

</select>

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
                        Update Item
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


</body>

</html>