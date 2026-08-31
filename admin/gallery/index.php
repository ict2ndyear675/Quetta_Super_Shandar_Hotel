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
| GET GALLERY ITEMS
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM gallery ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Gallery | Quetta Super Shandar Hotel</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .page-header {
            background: linear-gradient(
                135deg,
                #9d001d,
                #d10b32
            );

            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .page-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .page-header p {
            margin: 5px 0 0;
            opacity: .9;
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;

            box-shadow:
                0 5px 25px rgba(0,0,0,.08);
        }

        .btn-add {
            background: #f5b400;
            color: #111;
            font-weight: 600;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
        }

        .btn-add:hover {
            background: #d99d00;
            color: white;
        }

        .table thead {
            background: #9d001d;
            color: white;
        }

        .table thead th {
            padding: 14px 10px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .gallery-image {
            width: 90px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f5b400;
        }

        .badge-active {
            background: #198754;
        }

        .badge-hidden {
            background: #dc3545;
        }

        .btn-edit {
            background: #f5b400;
            color: #111;
            border: none;
        }

        .btn-edit:hover {
            background: #d99d00;
            color: white;
        }

        .btn-delete {
            background: #9d001d;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: #750015;
            color: white;
        }

        .empty-message {
            text-align: center;
            padding: 50px;
            color: #777;
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

                    <i class="bi bi-images"></i>

                    Gallery Management

                </h2>

                <p>

                    Add, edit and manage Quetta Super Shandar Hotel gallery images.

                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-add"
            >

                <i class="bi bi-plus-circle"></i>

                Add Gallery Image

            </a>

        </div>

    </div>


    <!-- GALLERY TABLE -->

    <div class="content-card">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Title</th>

                        <th>Category</th>

                        <th>Description</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                <?php if ($result && mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>

                        <tr>

                            <!-- ID -->

                            <td>

                                <?php echo $row['id']; ?>

                            </td>


                            <!-- IMAGE -->

                            <td>

                                <?php if (!empty($row['image'])): ?>

                                    <img
                                        src="../../<?php echo htmlspecialchars($row['image']); ?>"
                                        alt="<?php echo htmlspecialchars($row['title']); ?>"
                                        class="gallery-image"
                                    >

                                <?php else: ?>

                                    <span class="text-muted">
                                        No Image
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- TITLE -->

                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars($row['title']);
                                    ?>

                                </strong>

                            </td>


                            <!-- CATEGORY -->

                            <td>

                                <span class="badge bg-secondary">

                                    <?php
                                    echo htmlspecialchars($row['category']);
                                    ?>

                                </span>

                            </td>


                            <!-- DESCRIPTION -->

                            <td>

                                <?php

                                $description = $row['description'] ?? '';

                                if (strlen($description) > 60) {

                                    echo htmlspecialchars(
                                        substr($description, 0, 60)
                                    ) . "...";

                                } else {

                                    echo htmlspecialchars($description);

                                }

                                ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php if ((int)$row['status'] === 1): ?>

                                    <span class="badge badge-active">

                                        Active

                                    </span>

                                <?php else: ?>

                                    <span class="badge badge-hidden">

                                        Hidden

                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- ACTIONS -->

                            <td>

                                <div class="d-flex gap-2">

                                    <a
                                        href="edit.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-edit"
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                        Edit

                                    </a>


                                 <a
    href="delete.php?id=<?php echo $row['id']; ?>"
    class="btn btn-sm btn-danger"
    onclick="return confirm('Are you sure you want to delete this gallery image?');"
>
    <i class="bi bi-trash"></i>
    Delete
</a>

                                </div>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7">

                            <div class="empty-message">

                                <i
                                    class="bi bi-images"
                                    style="font-size: 50px;"
                                ></i>

                                <h4 class="mt-3">

                                    No Gallery Images Found

                                </h4>

                                <p>

                                    Start by adding your first gallery image.

                                </p>

                                <a
                                    href="add.php"
                                    class="btn btn-add"
                                >

                                    <i class="bi bi-plus-circle"></i>

                                    Add Gallery Image

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>