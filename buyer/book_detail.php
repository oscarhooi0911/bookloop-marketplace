<?php
// Preserve the requested book ID while using the shared detail page.
$query = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../customer/book_detail.php' . ($query !== '' ? '?' . $query : ''));
exit();
