<?php
$query = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../customer/book_detail.php' . ($query !== '' ? '?' . $query : ''));
exit();
