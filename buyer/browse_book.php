<?php
$query = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../customer/browse_books.php' . ($query !== '' ? '?' . $query : ''));
exit();
