<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Second-Hand Book Marketplace - Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">

   

</head>

<body>

<div class="auth-page">

    <!-- Left Side -->
    <div class="auth-left">

        <div class="auth-overlay">
            <h1>Second-Hand Book Marketplace</h1>
            <p>Buy. Sell. Read Again.</p>
        </div>

    </div>


    <!-- Right Side -->
    <div class="auth-right">

        <div class="auth-card">
            <h2>Welcome back</h2>
            <p class="auth-subtitle">Login to your account</p>


            <form action="authentication/login_process.php" method="POST">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >
                </div>


                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                        <button
							type="button"
							class="password-toggle"
							onclick="togglePassword()"
							aria-label="Show or hide password"
						>
							<span id="eyeIcon">👁</span>
						</button>
                    </div>
                </div>


                <!-- Remember Me / Forgot Password -->
                <div class="login-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>

                <!-- Error Messages -->
                <?php
                if (isset($_GET['error'])) {

                    if ($_GET['error'] == "wrongpassword") {

                        echo '
                        <div class="error-message">
                            Incorrect password.
                        </div>';
                    }

                    if ($_GET['error'] == "emailnotfound") {

                        echo '
                        <div class="error-message">
                            Email address not found.
                        </div>';
                    }

                    if ($_GET['error'] == "loginrequired") {

                        echo '
                        <div class="error-message">
                            Please login first.
                        </div>';
                    }

                    if ($_GET['error'] == "success") {

                        echo '
                        <div class="success-message">
                            Registration successful. Please login.
                        </div>';
                    }
                }

                if (isset($_GET['reset']) && $_GET['reset'] == "success") {

                    echo '
                    <div class="success-message">
                        Password updated. Please login.
                    </div>';
                }
                ?>

                <!-- Login Button -->
                <button type="submit" class="auth-button">Login</button>
            </form>
            <hr>

            <!-- Register Link -->
            <p class="auth-footer">
                Don't have an account?
                <a href="register.php">Register Here</a>
            </p>

        </div>

    </div>

</div>

<script>

function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        eyeIcon.textContent = "⌣";
    } else {

        password.type = "password";
        eyeIcon.textContent = "👁";
    }
}

</script>

</body>

</html>