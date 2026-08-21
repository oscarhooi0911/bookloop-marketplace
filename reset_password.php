<?php

include("database/database.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/* Check email */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {

    $email = trim($_POST['email']);

    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id FROM users WHERE email=?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);


    if (!$user) {

        header("Location: forgot_password.php?error=emailnotfound");
        exit();

    }


    $_SESSION['reset_user_id'] = (int) $user['user_id'];

}


/* Check reset session */

elseif (empty($_SESSION['reset_user_id'])) {

    header("Location: forgot_password.php");
    exit();

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Reset Password - Second-Hand Book Marketplace
    </title>

    <link
        rel="stylesheet"
        href="css/login.css"
    >

</head>


<body class="auth-page">


    <!-- Left Side -->

    <div class="auth-left">

        <div class="auth-overlay">

            <h1>
                Second-Hand Book Marketplace
            </h1>

            <p>
                Create a new password and continue your book journey.
            </p>

        </div>

    </div>



    <!-- Right Side -->

    <div class="auth-right">

        <div class="auth-card">


            <h2>
                Reset Password
            </h2>


            <p class="auth-subtitle">
                Enter your new password below.
            </p>



            <form
                action="update_reset_password.php"
                method="POST"
            >


                <!-- New Password -->

                <div class="form-group">

                    <label for="reset-password">
                        New Password
                    </label>


                    <div class="password-group">

                        <input
                            type="password"
                            id="reset-password"
                            name="password"
                            placeholder="Enter new password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'reset-password',
                                'reset-eye'
                            )"
                            aria-label="Show or hide password"
                        >

                            <span id="reset-eye">
                                👁
                            </span>

                        </button>

                    </div>

                </div>



                <!-- Confirm Password -->

                <div class="form-group">

                    <label for="reset-confirm-password">
                        Confirm Password
                    </label>


                    <div class="password-group">

                        <input
                            type="password"
                            id="reset-confirm-password"
                            name="confirm_password"
                            placeholder="Confirm new password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'reset-confirm-password',
                                'reset-confirm-eye'
                            )"
                            aria-label="Show or hide confirm password"
                        >

                            <span id="reset-confirm-eye">
                                👁
                            </span>

                        </button>

                    </div>

                </div>



                <!-- Error Messages -->

                <?php

                if (isset($_GET['error'])) {


                    if ($_GET['error'] == "nomatch") {

                        echo '
                        <div class="error-message">
                            Password and confirm password do not match.
                        </div>';

                    }


                    if ($_GET['error'] == "weakpassword") {

                        echo '
                        <div class="error-message">

                            <p>Password must contain:</p>

                            <ul>

                                <li>At least 8 characters</li>

                                <li>
                                    At least 1 uppercase letter (A-Z)
                                </li>

                                <li>
                                    At least 1 number (0-9)
                                </li>

                                <li>
                                    At least 1 special character (@, #, $, !)
                                </li>

                            </ul>

                        </div>';

                    }

                }

                ?>

                <!-- Update Password -->

                <button
                    type="submit"
                    class="auth-button"
                >
                    Update Password
                </button>


            </form>

            <hr>

            <!-- Login -->

            <p class="auth-footer">

                Remember your password?

                <a href="login.php">
                    Login Here
                </a>

            </p>


        </div>

    </div>



    <script>

    function togglePassword(passwordId, eyeId) {

        const password =
            document.getElementById(passwordId);

        const eye =
            document.getElementById(eyeId);


        if (password.type === "password") {

            password.type = "text";

            eye.textContent = "🙈";

        } else {

            password.type = "password";

            eye.textContent = "👁";

        }

    }

    </script>


</body>

</html>