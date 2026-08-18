<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";


if ($_SESSION['role'] !== 'customer') {

    header(
        "Location: ../staff/dashboard.php"
    );

    exit();

}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header(
        "Location: my_books.php"
    );

    exit();

}


$book_id =
    (int)($_POST['book_id'] ?? 0);


$seller_id =
    $_SESSION['user_id'];


$stmt =
    mysqli_prepare(
        $conn,

        "DELETE FROM books
         WHERE book_id=?
         AND seller_id=?"
    );


mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $book_id,
    $seller_id
);


mysqli_stmt_execute($stmt);


header(
    "Location: my_books.php?success=deleted"
);


exit();
?>