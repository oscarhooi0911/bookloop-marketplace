<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../database/database.php";

// Ensure user is an authenticated customer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;
$action  = isset($_GET['action']) ? $_GET['action'] : '';

if ($book_id > 0) {
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT IGNORE INTO wishlist (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
    } elseif ($action === 'remove') {
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
    }
}

// Redirect back to referring page or default wishlist view
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "wishlist.php";
header("Location: " . $referer);
exit();