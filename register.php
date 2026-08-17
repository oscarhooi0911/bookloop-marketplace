<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Second-Hand Book Marketplace - Register</title>

    <link rel="stylesheet" href="css/login.css">

</head>

<body class="auth-page">

    <div class="auth-left">

        <div class="auth-overlay">

            <h1>Second-Hand Book Marketplace</h1>

            <p>Buy. Sell. Read Again.</p>

        </div>

    </div>


    <div class="auth-right">

        <div class="auth-card">

            <h2>Create Account</h2>

            <p class="auth-subtitle">
                Register to start buying and selling books
            </p>


            <form action="authentication/register_process.php" method="POST">

                <!-- Full Name -->
                <div class="form-group">

                    <label for="full_name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


                <!-- Email -->
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <!-- Phone -->
                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="Enter your phone number"
                    >

                </div>


                <!-- Address -->
                <div class="form-group">

                    <label for="address">
                        Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="2"
                        placeholder="Enter your address"
                    ></textarea>

                </div>


                <!-- Password -->
                <div class="form-group">

                    <label for="register-password">
                        Password
                    </label>

                    <div class="password-group">

                        <input
                            type="password"
                            id="register-password"
                            name="password"
                            placeholder="Create password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('register-password', 'register-eye')"
                            aria-label="Show or hide password"
                        >
                            <span id="register-eye">👁</span>
                        </button>

                    </div>

                </div>


                <!-- Confirm Password -->
                <div class="form-group">

                    <label for="confirm-password">
                        Confirm Password
                    </label>

                    <div class="password-group">

                        <input
                            type="password"
                            id="confirm-password"
                            name="confirm_password"
                            placeholder="Confirm password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('confirm-password', 'confirm-eye')"
                            aria-label="Show or hide confirm password"
                        >
                            <span id="confirm-eye">👁</span>
                        </button>

                    </div>

                </div>


                <!-- Error Messages -->
                <?php

                if (isset($_GET['error'])) {

                    if ($_GET['error'] == "email_exists") {

                        echo '
                        <div class="error-message">
                            Email already exists. Please use another email.
                        </div>';

                    }


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
                                <li>At least 1 uppercase letter (A-Z)</li>
                                <li>At least 1 number (0-9)</li>
                                <li>At least 1 special character (@, #, $, !)</li>
                            </ul>

                        </div>';

                    }

                }

                ?>


                <!-- Register Button -->
                <button
                    type="submit"
                    class="auth-button"
                >
                    Register
                </button>

            </form>


            <hr>


            <p class="auth-footer">

                Already have an account?

                <a href="login.php">
                    Login Here
                </a>

            </p>

        </div>

    </div>


    <script>

    function togglePassword(passwordId, eyeId) {

        const password = document.getElementById(passwordId);
        const eye = document.getElementById(eyeId);

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