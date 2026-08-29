<?php

session_start();

require_once "../../config/db.php";

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| ADD MENU ITEM
|--------------------------------------------------------------------------
*/

if (isset($_POST['add_menu'])) {

    // Get form values
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $status = isset($_POST['status']) ? 1 : 0;

    $image_name = NULL;


    /*
    |--------------------------------------------------------------------------
    | VALIDATE REQUIRED FIELDS
    |--------------------------------------------------------------------------
    */

    if ($name == "" || $category == "" || $price == "") {

        $error = "Please fill in all required fields.";

    } elseif (!is_numeric($price)) {

        $error = "Please enter a valid price.";

    } else {


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

            $image = $_FILES['image'];

            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

            $file_extension = strtolower(
                pathinfo($image['name'], PATHINFO_EXTENSION)
            );


            if (!in_array($file_extension, $allowed_extensions)) {

                $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

            } elseif ($image['size'] > 5 * 1024 * 1024) {

                $error = "Image size must be less than 5MB.";

            } else {

                /*
                | Create unique filename
                */

                $image_name =
                    time() . "_" .
                    uniqid() . "." .
                    $file_extension;


                /*
                | Upload destination
                */

                $upload_folder = "../../images/";

                $upload_path = $upload_folder . $image_name;


                if (!move_uploaded_file(
                    $image['tmp_name'],
                    $upload_path
                )) {

                    $error = "Failed to upload image.";

                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INSERT INTO DATABASE
        |--------------------------------------------------------------------------
        */

        if (!isset($error)) {

            $sql = "INSERT INTO menu_items
                    (name, category, description, price, image, status)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssdsi",
                $name,
                $category,
                $description,
                $price,
                $image_name,
                $status
            );


            if (mysqli_stmt_execute($stmt)) {

                header("Location: index.php?success=added");

                exit;

            } else {

                $error = "Database error: " . mysqli_error($conn);

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
        Add Menu Item | Quetta Super Shandar Hotel
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        body {

            background: #f6f6f6;

            font-family: Arial, sans-serif;

        }


        /* PAGE HEADER */

        .page-header {

            background: linear-gradient(
                135deg,
                #970019,
                #d20b32
            );

            color: white;

            padding: 25px 30px;

            border-radius: 14px;

            margin-bottom: 25px;

        }


        .page-header h2 {

            margin: 0;

            font-weight: 700;

        }


        .page-header p {

            margin: 6px 0 0;

            opacity: .9;

        }


        /* FORM CARD */

        .form-card {

            background: white;

            border-radius: 15px;

            padding: 30px;

            box-shadow:
                0 5px 25px rgba(0,0,0,.08);

        }


        /* FORM LABEL */

        .form-label {

            font-weight: 600;

            color: #222;

        }


        .required {

            color: #9d001d;

        }


        /* INPUTS */

        .form-control,
        .form-select {

            border: 1px solid #ddd;

            border-radius: 8px;

            padding: 11px 13px;

        }


        .form-control:focus,
        .form-select:focus {

            border-color: #c50027;

            box-shadow:
                0 0 0 3px rgba(197,0,39,.10);

        }


        /* TEXTAREA */

        textarea.form-control {

            min-height: 120px;

            resize: vertical;

        }


        /* IMAGE UPLOAD */

        .image-upload {

            border: 2px dashed #ddd;

            border-radius: 10px;

            padding: 25px;

            text-align: center;

            background: #fafafa;

            transition: .3s;

        }


        .image-upload:hover {

            border-color: #d20b32;

            background: #fff8f9;

        }


        .image-upload i {

            font-size: 38px;

            color: #d20b32;

        }


        .image-upload p {

            margin: 8px 0 12px;

            color: #777;

        }


        /* BUTTONS */

        .btn-save {

            background: #f5b400;

            color: #111;

            border: none;

            padding: 11px 24px;

            border-radius: 8px;

            font-weight: 700;

        }


        .btn-save:hover {

            background: #d99d00;

            color: white;

        }


        .btn-cancel {

            background: #eee;

            color: #333;

            border: none;

            padding: 11px 24px;

            border-radius: 8px;

            font-weight: 600;

        }


        .btn-cancel:hover {

            background: #ddd;

        }


        /* STATUS */

        .status-box {

            background: #fff8df;

            border: 1px solid #f5d875;

            border-radius: 8px;

            padding: 15px;

        }


    </style>

</head>


<body>


<div class="container-fluid p-4">


    <!-- PAGE HEADER -->

    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h2>

                    <i class="bi bi-plus-circle"></i>

                    Add Menu Item

                </h2>

                <p>

                    Add a new food or beverage item to the hotel menu.

                </p>

            </div>


            <a
                href="index.php"
                class="btn btn-light"
            >

                <i class="bi bi-arrow-left"></i>

                Back to Menu

            </a>

        </div>

    </div>



    <!-- ERROR MESSAGE -->

    <?php if (isset($error)): ?>

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-triangle"></i>

            <?php echo htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>



    <!-- FORM -->

    <div class="form-card">

        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <div class="row g-4">


                <!-- NAME -->

                <div class="col-md-6">

                    <label class="form-label">

                        Menu Item Name

                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="e.g. Mutton Karahi"
                        maxlength="100"
                        required
                    >

                </div>



                <!-- CATEGORY -->

                <div class="col-md-6">

                    <label class="form-label">

                        Category

                        <span class="required">*</span>

                    </label>

                    <select
                        name="category"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>

                        <option value="Traditional Food">
                            Traditional Food
                        </option>

                        <option value="Chai & Kahwa">
                            Chai & Kahwa
                        </option>

                        <option value="Breakfast">
                            Breakfast
                        </option>

                        <option value="Paratha">
                            Paratha
                        </option>

                        <option value="Salan">
                            Salan
                        </option>

                        <option value="Rice">
                            Rice
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>



                <!-- DESCRIPTION -->

                <div class="col-12">

                    <label class="form-label">

                        Description

                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        placeholder="Enter a short description of the menu item..."
                    ></textarea>

                </div>



                <!-- PRICE -->

                <div class="col-md-6">

                    <label class="form-label">

                        Price (Rs.)

                        <span class="required">*</span>

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Rs.
                        </span>

                        <input
                            type="number"
                            name="price"
                            class="form-control"
                            placeholder="850.00"
                            step="0.01"
                            min="0"
                            required
                        >

                    </div>

                </div>



                <!-- STATUS -->

                <div class="col-md-6">

                    <label class="form-label">

                        Status

                    </label>

                    <div class="status-box">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="status"
                                id="status"
                                checked
                            >

                            <label
                                class="form-check-label"
                                for="status"
                            >

                                <strong>Active</strong>

                                <br>

                                <small class="text-muted">

                                    Show this item on the public menu.

                                </small>

                            </label>

                        </div>

                    </div>

                </div>



                <!-- IMAGE -->

                <div class="col-12">

                    <label class="form-label">

                        Menu Item Image

                    </label>

                    <div class="image-upload">

                        <i class="bi bi-cloud-arrow-up"></i>

                        <p>
                            Upload an image for this menu item
                        </p>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">

                            JPG, JPEG, PNG or WEBP — Maximum 5MB

                        </small>

                    </div>

                </div>



                <!-- BUTTONS -->

                <div class="col-12">

                    <hr>

                    <div class="d-flex gap-2 justify-content-end">

                        <a
                            href="index.php"
                            class="btn btn-cancel"
                        >

                            Cancel

                        </a>


                        <button
                            type="submit"
                            name="add_menu"
                            class="btn btn-save"
                        >

                            <i class="bi bi-check-circle"></i>

                            Add Menu Item

                        </button>

                    </div>

                </div>


            </div>

        </form>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>