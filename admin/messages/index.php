```php
<?php

session_start();

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN PROTECTION
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

require_once "../../config/db.php";


/*
|--------------------------------------------------------------------------
| DELETE MESSAGE
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {

    $delete_id = filter_var($_POST["delete_id"], FILTER_VALIDATE_INT);

    if ($delete_id !== false && $delete_id > 0) {

        $sql = "DELETE FROM contact_messages WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    header("Location: index.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| FETCH CONTACT MESSAGES
|--------------------------------------------------------------------------
*/

$sql = "SELECT id, name, email, phone, subject, message, created_at
        FROM contact_messages
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Messages | Admin Panel</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: 'Poppins', sans-serif;

            background: #f6f6f6;

            color: #222;

        }


        /* ================= HEADER ================= */

        .admin-header {

            background: #b5121b;

            color: white;

            padding: 18px 30px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border-bottom: 5px solid #f5c400;

        }


        .admin-header h1 {

            font-family: 'Playfair Display', serif;

            font-size: 25px;

            margin: 0;

        }


        .admin-header p {

            margin: 3px 0 0;

            font-size: 12px;

            opacity: .9;

        }


        .admin-header-right {

            display: flex;

            align-items: center;

            gap: 15px;

        }


        .admin-name {

            font-size: 14px;

        }


        .logout-btn {

            background: #f5c400;

            color: #222;

            text-decoration: none;

            padding: 9px 15px;

            border-radius: 5px;

            font-size: 13px;

            font-weight: 600;

        }


        .logout-btn:hover {

            background: #ffffff;

            color: #b5121b;

        }


        /* ================= MAIN ================= */

        .page-container {

            max-width: 1400px;

            margin: 35px auto;

            padding: 0 20px;

        }


        .page-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            gap: 15px;

        }


        .page-title h2 {

            font-family: 'Playfair Display', serif;

            font-size: 30px;

            color: #222;

            margin-bottom: 5px;

        }


        .page-title p {

            color: #777;

            font-size: 13px;

            margin: 0;

        }


        .back-btn {

            background: #b5121b;

            color: white;

            text-decoration: none;

            padding: 10px 17px;

            border-radius: 5px;

            font-size: 13px;

            font-weight: 500;

        }


        .back-btn:hover {

            background: #8f0e15;

            color: white;

        }


        /* ================= CARD ================= */

        .messages-card {

            background: #fff;

            border-radius: 10px;

            box-shadow: 0 5px 25px rgba(0, 0, 0, .08);

            overflow: hidden;

        }


        .card-header-custom {

            background: #b5121b;

            color: white;

            padding: 16px 20px;

            border-bottom: 4px solid #f5c400;

        }


        .card-header-custom h3 {

            font-size: 17px;

            margin: 0;

            font-weight: 600;

        }


        /* ================= TABLE ================= */

        .table-responsive {

            width: 100%;

            overflow-x: auto;

        }


        .messages-table {

            margin: 0;

            min-width: 1050px;

        }


        .messages-table thead th {

            background: #f8f8f8;

            color: #333;

            font-size: 12px;

            font-weight: 600;

            padding: 15px 12px;

            white-space: nowrap;

            border-bottom: 2px solid #f5c400;

        }


        .messages-table tbody td {

            padding: 14px 12px;

            font-size: 13px;

            vertical-align: middle;

            border-bottom: 1px solid #eeeeee;

        }


        .messages-table tbody tr:hover {

            background: #fffdf0;

        }


        .message-name {

            font-weight: 600;

            color: #b5121b;

        }


        .message-email {

            color: #555;

            font-size: 12px;

        }


        .message-subject {

            font-weight: 600;

            color: #333;

        }


        .message-text {

            max-width: 300px;

            min-width: 250px;

            line-height: 1.6;

            color: #555;

        }


        .message-date {

            white-space: nowrap;

            color: #777;

            font-size: 11px;

        }


        /* ================= DELETE BUTTON ================= */

        .delete-btn {

            border: none;

            background: #dc3545;

            color: white;

            padding: 7px 11px;

            border-radius: 4px;

            font-size: 12px;

            cursor: pointer;

        }


        .delete-btn:hover {

            background: #b02a37;

        }


        /* ================= EMPTY ================= */

        .empty-box {

            text-align: center;

            padding: 60px 20px;

        }


        .empty-box i {

            font-size: 50px;

            color: #f5c400;

            display: block;

            margin-bottom: 15px;

        }


        .empty-box h3 {

            font-family: 'Playfair Display', serif;

            font-size: 24px;

            margin-bottom: 8px;

        }


        .empty-box p {

            color: #777;

            font-size: 13px;

        }


        /* ================= RESPONSIVE ================= */

        @media (max-width: 768px) {

            .admin-header {

                padding: 15px;

                flex-direction: column;

                align-items: flex-start;

                gap: 12px;

            }


            .admin-header-right {

                width: 100%;

                justify-content: space-between;

            }


            .page-container {

                margin: 25px auto;

                padding: 0 12px;

            }


            .page-top {

                flex-direction: column;

                align-items: flex-start;

            }


            .page-title h2 {

                font-size: 25px;

            }

        }


    </style>

</head>


<body>


<!-- ================= ADMIN HEADER ================= -->

<header class="admin-header">

    <div>

        <h1>
            Quetta Super Shandar Hotel
        </h1>

        <p>
            Hotel Management System
        </p>

    </div>


    <div class="admin-header-right">

        <span class="admin-name">

            <i class="bi bi-person-circle"></i>

            <?php
            echo htmlspecialchars($_SESSION["admin_username"]);
            ?>

        </span>


        <a href="../logout.php" class="logout-btn">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</header>


<!-- ================= MAIN ================= -->

<main class="page-container">


    <!-- PAGE TOP -->

    <div class="page-top">

        <div class="page-title">

            <h2>
                Contact Messages
            </h2>

            <p>
                View messages submitted through your hotel website.
            </p>

        </div>


        <a href="../dashboard.php" class="back-btn">

            <i class="bi bi-arrow-left"></i>

            Back to Dashboard

        </a>

    </div>


    <!-- ================= MESSAGES CARD ================= -->

    <div class="messages-card">


        <div class="card-header-custom">

            <h3>

                <i class="bi bi-envelope-fill me-2"></i>

                Guest Messages

            </h3>

        </div>


        <?php if ($result && mysqli_num_rows($result) > 0): ?>


            <div class="table-responsive">

                <table class="table messages-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Guest</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Subject</th>

                            <th>Message</th>

                            <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    $counter = 1;

                    while ($row = mysqli_fetch_assoc($result)):

                    ?>


                        <tr>


                            <!-- NUMBER -->

                            <td>

                                <?php echo $counter++; ?>

                            </td>


                            <!-- NAME -->

                            <td>

                                <div class="message-name">

                                    <?php
                                    echo htmlspecialchars($row["name"]);
                                    ?>

                                </div>

                            </td>


                            <!-- EMAIL -->

                            <td>

                                <div class="message-email">

                                    <?php
                                    echo htmlspecialchars($row["email"]);
                                    ?>

                                </div>

                            </td>


                            <!-- PHONE -->

                            <td>

                                <?php

                                echo !empty($row["phone"])

                                    ? htmlspecialchars($row["phone"])

                                    : "—";

                                ?>

                            </td>


                            <!-- SUBJECT -->

                            <td>

                                <div class="message-subject">

                                    <?php
                                    echo htmlspecialchars($row["subject"]);
                                    ?>

                                </div>

                            </td>


                            <!-- MESSAGE -->

                            <td>

                                <div class="message-text">

                                    <?php
                                    echo nl2br(
                                        htmlspecialchars($row["message"])
                                    );
                                    ?>

                                </div>

                            </td>


                            <!-- DATE -->

                            <td>

                                <div class="message-date">

                                    <?php

                                    echo date(
                                        "d M Y, h:i A",
                                        strtotime($row["created_at"])
                                    );

                                    ?>

                                </div>

                            </td>


                            <!-- DELETE -->

                            <td>

                                <form
                                    method="POST"
                                    action=""
                                    onsubmit="return confirm('Are you sure you want to delete this message?');"
                                >

                                    <input
                                        type="hidden"
                                        name="delete_id"
                                        value="<?php echo (int)$row["id"]; ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="delete-btn"
                                    >

                                        <i class="bi bi-trash"></i>

                                        Delete

                                    </button>

                                </form>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                    </tbody>

                </table>

            </div>


        <?php else: ?>


            <!-- NO MESSAGES -->

            <div class="empty-box">

                <i class="bi bi-envelope-open"></i>

                <h3>
                    No Messages Yet
                </h3>

                <p>
                    Contact form messages will appear here when guests
                    submit the form.
                </p>

            </div>


        <?php endif; ?>


    </div>


</main>


</body>

</html>

<?php

if ($result) {
    mysqli_free_result($result);
}

mysqli_close($conn);

?>
```
