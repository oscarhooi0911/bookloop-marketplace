<?php
// search and filter values when redirecting from the former buyer URL.
$query = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../customer/browse_books.php' . ($query !== '' ? '?' . $query : ''));
exit();
