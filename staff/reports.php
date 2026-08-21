<?php
require_once "../authentication/check_staff.php";
require_once "../includes/header.php";
?>

<div class="report-page">

    <div class="report-card">

        <div class="report-header">
            <h2>Report a Problem</h2>

            <p>Use this form to report any problem or issue to the company.</p>
			
        </div>

        <form method="post" action="submit_report.php">

            <div class="report-form-group">
                <label for="subject">Subject</label>

                <input type="text" id="subject" name="subject" placeholder="Enter the problem subject" required>
            </div>

            <div class="report-form-group">
                <label for="message">Problem Description</label>

                <textarea id="message" name="message" rows="7" placeholder="Describe the problem in detail..." required></textarea>
            </div>

            <div class="report-buttons">

                <button type="submit"class="report-submit">Submit Report</button>

                <a href="dashboard.php" class="report-cancel">Cancel</a>

            </div>

        </form>

    </div>

</div>

<?php
require_once "../includes/footer.php";
?>