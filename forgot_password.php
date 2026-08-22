<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Second-Hand Book Marketplace</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="auth-page">
    <!-- Left Side -->
    <div class="auth-left">
        <div class="auth-overlay">
            <h1>Second-Hand Book Marketplace</h1>
            <p>Reset your password and continue your book journey.</p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="auth-right">
        <div class="auth-card">
            <h2>Forgot Password</h2>
            <p class="auth-subtitle">Enter your email to reset your password.</p>

            <form action="reset_password.php" method="POST">
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
				
                <!-- Error Message -->
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "emailnotfound") {
                        echo '
                        <div class="error-message">Email does not exist.</div>';
                    }
                }
                ?>
				
                <!-- Continue Button -->
                <button
                    type="submit"
                    class="auth-button"
                >
                    Continue
                </button>
            </form>

            <hr>
			
            <!-- Login Link -->
            <p class="auth-footer">
                Remember your password?
                <a href="login.php"> Login Here</a>
            </p>
        </div>
    </div>
</body>
</html>