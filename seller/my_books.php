<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header("Location: ../staff/dashboard.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT book_id, title, author, genre, language, price, quantity,
     book_condition, image, created_at
     FROM books
     WHERE seller_id=?
     ORDER BY created_at DESC, book_id DESC"
);

mysqli_stmt_bind_param($stmt, "i", $seller_id);
mysqli_stmt_execute($stmt);

$books = mysqli_stmt_get_result($stmt);

require_once "../includes/header.php";
?>

<link rel="stylesheet" href="../css/seller.css">

<section class="seller-page">

    <div class="seller-container">

        <div class="seller-page-header">

            <div>
                <h1>My Book Listings</h1>
                <p>
                    Manage the second-hand books you have listed for sale.
                </p>
            </div>

            <a class="seller-btn seller-btn-primary"
               href="add_book.php">
                + Sell a Book
            </a>

        </div>


        <?php if (isset($_GET['success'])): ?>

            <div class="seller-message success">

                <?php

                if ($_GET['success'] === 'added') {
                    echo "Book added successfully.";
                }

                elseif ($_GET['success'] === 'updated') {
                    echo "Book updated successfully.";
                }

                elseif ($_GET['success'] === 'deleted') {
                    echo "Book deleted successfully.";
                }

                ?>

            </div>

        <?php endif; ?>


        <?php if (mysqli_num_rows($books) > 0): ?>

            <div class="seller-grid">

                <?php while ($book = mysqli_fetch_assoc($books)): ?>

                    <article class="seller-book-card">

                        <?php if (!empty($book['image'])): ?>

                            <img
                                class="seller-book-image"

                                src="../image/<?php
                                echo rawurlencode($book['image']);
                                ?>"

                                alt="<?php
                                echo htmlspecialchars($book['title']);
                                ?>"
                            >

                        <?php else: ?>

                            <div class="seller-no-image">
                                No Image
                            </div>

                        <?php endif; ?>


                        <div class="seller-book-content">

                            <h2>
                                <?php
                                echo htmlspecialchars($book['title']);
                                ?>
                            </h2>

                            <p class="seller-muted">

                                by

                                <?php
                                echo htmlspecialchars($book['author']);
                                ?>

                            </p>


                            <div class="seller-book-meta">

                                <span>
                                    <?php
                                    echo htmlspecialchars($book['genre']);
                                    ?>
                                </span>

                                <span>
                                    <?php
                                    echo htmlspecialchars($book['language']);
                                    ?>
                                </span>

                                <span>
                                    <?php
                                    echo htmlspecialchars(
                                        $book['book_condition']
                                    );
                                    ?>
                                </span>

                            </div>


                            <p>

                                <strong>Price:</strong>

                                RM
                                <?php
                                echo number_format(
                                    (float)$book['price'],
                                    2
                                );
                                ?>

                            </p>


                            <p>

                                <strong>Quantity:</strong>

                                <?php
                                echo (int)$book['quantity'];
                                ?>

                            </p>


                            <div class="seller-actions">

                                <a
                                    class="seller-btn seller-btn-edit"

                                    href="edit_book.php?id=<?php
                                    echo (int)$book['book_id'];
                                    ?>"
                                >
                                    Edit
                                </a>


                                <form
                                    class="delete-form"
                                    method="post"
                                    action="delete_book.php"
                                >

                                    <input
                                        type="hidden"
                                        name="book_id"

                                        value="<?php
                                        echo (int)$book['book_id'];
                                        ?>"
                                    >


                                    <button
                                        class="seller-btn seller-btn-delete"
                                        type="submit"

                                        data-title="<?php
                                        echo htmlspecialchars(
                                            $book['title'],
                                            ENT_QUOTES
                                        );
                                        ?>"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>


        <?php else: ?>


            <div class="seller-empty-state">

                <h2>No books listed yet</h2>

                <p>
                    Start selling by adding your first
                    second-hand book.
                </p>

                <a
                    class="seller-btn seller-btn-primary"
                    href="add_book.php"
                >
                    Add Your First Book
                </a>

            </div>


        <?php endif; ?>

    </div>

</section>


<script src="../js/seller.js"></script>

<?php
require_once "../includes/footer.php";
?>