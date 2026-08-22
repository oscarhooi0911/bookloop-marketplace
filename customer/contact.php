<?php
$name = '';
$email = '';
$phone = '';
$subject = '';
$message = '';
$errors = [];
$success = '';

// Check whether form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form values
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');


	//Validation
	//Name
    if ($name === '') {
        $errors['name'] = "Name is required.";
    } elseif (strlen($name) < 2) {
        $errors['name'] = "Name must be at least 2 characters.";
    } elseif (strlen($name) > 100) {
        $errors['name'] = "Name must not exceed 100 characters.";
    }


	//Email
    if ($email === '') {
        $errors['email'] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }


	//Phone
    if ($phone === '') {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {
        $errors['phone'] = "Please enter a valid phone number.";
    }


    //Subject
    if ($subject === '') {
        $errors['subject'] = "Subject is required.";
    } elseif (strlen($subject) < 3) {
        $errors['subject'] = "Subject must be at least 3 characters.";
    } elseif (strlen($subject) > 150) {
        $errors['subject'] = "Subject must not exceed 150 characters.";
    }


    //Message
    if ($message === '') {
        $errors['message'] = "Message is required.";
    } elseif (strlen($message) < 10) {
        $errors['message'] = "Message must be at least 10 characters.";
    } elseif (strlen($message) > 1000) {
        $errors['message'] = "Message must not exceed 1000 characters.";
    }


	//No error
    if (empty($errors)) {

        $success = "Thank you for contacting BookLoop Marketplace. We will get back to you soon.";

        // Clear form
        $name = '';
        $email = '';
        $phone = '';
        $subject = '';
        $message = '';
    }
}

include ("../includes/header.php");
?>

<link rel="stylesheet" href="../css/contact.css">

<div class="contact-page">

	<div class="contact-header">
		<h1>Contact Us</h1>
		<p>Have a question or need help? We would love to hear from you.</p>
	</div>

	<div class="contact-container">
		<div class="contact-info">
			<h2>Get in Touch</h2>
			<p>
				If you have any questions about buying,
				selling, or using BookLoop Marketplace,
				feel free to contact us.
			</p>

			<!-- Email -->
			<div class="contact-item">
				<h3>Email</h3>
				<p>
					<a href="mailto:bookloop@example.com">bookloop@example.com</a>
				</p>
			</div>

			<!-- Phone -->
			<div class="contact-item">
				<h3>Phone</h3>
				<p>
					<a href="tel:+60123456789">+60 12-345 6789</a>
				</p>
			</div>

			<!-- Address -->
			<div class="contact-item">
				<h3>Address</h3>
				<p>
					BookLoop Marketplace<br>
					Kuala Lumpur, Malaysia
				</p>
			</div>

			<!-- Opening Hours -->
			<div class="contact-item">
				<h3>Business Hours</h3>
				<p>Monday - Friday: 9:00 AM - 5:00 PM</p>
			</div>

			<!-- Social Media -->
			<div class="social-links">
				<h3>Follow Us</h3>
				<a href="#" target="_blank">Facebook</a>
				<a href="#" target="_blank">Instagram</a>
				<a href="#" target="_blank">TikTok</a>
			</div>
		</div>
		
		<!--Contact From-->
		<div class="contact-form">
			<h2>Send Us a Message</h2>
			<?php if ($success !== ''): ?>
				<div class="success-message"><?php echo htmlspecialchars($success); ?></div>
			<?php endif; ?>

			<form action="contact.php" method="POST">

				<!-- Name -->
				<div class="form-group">
					<label for="name">Full Name</label>
					<input
						type="text"
						id="name"
						name="name"
						value="<?php echo htmlspecialchars($name); ?>"
						placeholder="Enter your name"
					>

					<?php if (isset($errors['name'])): ?>
						<div class="error-message">
							<?php echo htmlspecialchars($errors['name']); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Email -->
				<div class="form-group">
					<label for="email">Email Address</label>
					<input
						type="email"
						id="email"
						name="email"
						value="<?php echo htmlspecialchars($email); ?>"
						placeholder="Enter your email"
					>

					<?php if (isset($errors['email'])): ?>
						<div class="error-message">
							<?php echo htmlspecialchars($errors['email']); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Phone -->
				<div class="form-group">
					<label for="phone">Phone Number</label>
					<input
						type="text"
						id="phone"
						name="phone"
						value="<?php echo htmlspecialchars($phone); ?>"
						placeholder="Enter your phone number"
					>

					<?php if (isset($errors['phone'])): ?>
						<div class="error-message">
							<?php echo htmlspecialchars($errors['phone']); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Subject -->
				<div class="form-group">
					<label for="subject">Subject</label>
					<input
						type="text"
						id="subject"
						name="subject"
						value="<?php echo htmlspecialchars($subject); ?>"
						placeholder="Enter subject"
					>

					<?php if (isset($errors['subject'])): ?>
						<div class="error-message">
							<?php echo htmlspecialchars($errors['subject']); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Message -->
				<div class="form-group">
					<label for="message">Message</label>
					<textarea
						id="message"
						name="message"
						rows="6"
						placeholder="Enter your message"
					><?php echo htmlspecialchars($message); ?></textarea>

					<?php if (isset($errors['message'])): ?>
						<div class="error-message">
							<?php echo htmlspecialchars($errors['message']); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Submit -->
				<button type="submit" class="contact-button">Send Message</button>
			</form>
		</div>
	</div>
	
	<!-- Google Map -->
	<div class="contact-map">
		<h2>Our Location</h2>
		<iframe
			src="https://www.google.com/maps?q=Universiti+Tunku+Abdul+Rahman+Sungai+Long+Campus&output=embed"
			width="100%"
			height="400"
			style="border:0;"
			allowfullscreen=""
			loading="lazy"
			referrerpolicy="no-referrer-when-downgrade">
		</iframe>
	</div>
</div>

<?php 
include("../includes/footer.php"); 
?>
