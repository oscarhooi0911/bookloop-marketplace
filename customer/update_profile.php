<?php

include("../authentication/check_login.php");
include("../database/database.php");

$id = $_SESSION['user_id'];

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

$full_name_error = '';
$phone_error = '';
$address_error = '';
$profile_picture_error = '';

$filename = '';


//Validation
// Name
if ($full_name === '') {
	
    $full_name_error = "Full name is required.";
	
} elseif (strlen($full_name) < 2) {

    $full_name_error = "Full name must be at least 2 characters.";

} elseif (strlen($full_name) > 100) {

    $full_name_error = "Full name must not exceed 100 characters.";
}

// Phone
if ($phone !== '') {

    if (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {

        $phone_error = "Invalid phone number.";

    }
}


// Address
if (strlen($address) > 500) {

    $address_error = "Address must not exceed 500 characters.";
}


// Profile Picture
if (
    isset($_FILES['profile_picture']) &&
    $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE
) {

    if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {

        $profile_picture_error = "Error uploading profile picture.";

    } else {

        $file = $_FILES['profile_picture'];


        // Check file size
        if ($file['size'] > 2 * 1024 * 1024) {

            $profile_picture_error =
                "Profile picture must not exceed 2MB.";
        }


        // Check actual file type
        $file_type = mime_content_type($file['tmp_name']);

        $allowed_types = [
            'image/jpeg',
            'image/png'
        ];

        if (!in_array($file_type, $allowed_types)) {

            $profile_picture_error =
                "Only JPG, JPEG and PNG images are allowed.";
        }

        // Generate filename
        if ($profile_picture_error === '') {

            $extension =
                strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            $filename =
                time() . "_" . uniqid() . "." . $extension;
        }
    }
}


//Got error
if (
    $full_name_error !== '' ||
    $phone_error !== '' ||
    $address_error !== '' ||
    $profile_picture_error !== ''
) {

    $query = http_build_query([
        'full_name_error' => $full_name_error,
        'phone_error' => $phone_error,
        'address_error' => $address_error,
        'profile_picture_error' => $profile_picture_error
    ]);

    header("Location: edit_profile.php?" . $query);
    exit;
}


//Update Database
if ($filename !== '') {
    $upload_path = "../upload/profile/" . $filename;
    if (!move_uploaded_file(
        $_FILES['profile_picture']['tmp_name'],
        $upload_path
    )) {
        header(
            "Location: edit_profile.php?profile_picture_error=" .
            urlencode("Failed to upload profile picture.")
        );
        exit;
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
         SET full_name=?, phone=?, address=?, profile_picture=?
         WHERE user_id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $full_name,
        $phone,
        $address,
        $filename,
        $id
    );

} else {
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
         SET full_name=?, phone=?, address=?
         WHERE user_id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $full_name,
        $phone,
        $address,
        $id
    );
}

if (mysqli_stmt_execute($stmt)) {
    header("Location: profile.php?update=success");
    exit;
} else {
    die("Failed to update profile.");
}
?>