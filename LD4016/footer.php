<!-- footer.php -->
<footer class="footer-container">
    <div class="footer-content">
        <p>&copy; <?php echo date("Y"); ?> Delicious Pizza. All rights reserved.</p>
        <a href="contactus.php" class="footer-contact-btn">Contact Us</a>
        <div class="footer-links">
            <a href="#" id="privacyNoticeLink">Privacy Notice</a> |
            <a href="#" id="privacyPolicyLink">Privacy Policy</a>
        </div>
    </div>
</footer>

<!-- Privacy Notice Modal -->
<div id="privacyNoticeModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closePrivacyNotice">&times;</span>
        <h2>Privacy Notice</h2>
        <p>Effective Date: 30/08/2024

            <br>Who We Are:
            <br>At Delicious Pizza, your privacy is important to us. This notice explains how we collect, use, and protect your personal information when you visit our website or place an order.

            <br>What Information We Collect:

            <br>Personal Information: Name, address, email, phone number, and payment details when you place an order.
            <br>Technical Information: IP address, browser type, and device information collected automatically through cookies.
            <br>How We Use Your Information:

            <br>To process your orders and payments.
            <br>To communicate with you about your orders or respond to your inquiries.
            <br>To improve our website and services based on user interactions.
            <br>Your Rights:

            <br>You can request access, correction, or deletion of your personal information.
            <br>You can opt out of marketing communications at any time.
            <br>For full details, please see our Privacy Policy below or contact us.</p>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyPolicyModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closePrivacyPolicy">&times;</span>
        <h2>Privacy Policy</h2>
        <p>1. Introduction
        <br>Delicious Pizza is committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and safeguard your personal information when you interact with our website.

        <br>2. Information We Collect

        <br>Personal Information: Collected when you register, place an order, or contact us.
        <br>Technical Data: Collected through cookies and similar technologies to enhance user experience.
        <br>3. How We Use Your Information

        <br>Order Processing: To handle orders, process payments, and deliver services.
        <br>Customer Support: To respond to inquiries or resolve issues.
        <br>Marketing: To send promotional offers if you consent.
        <br>4. Sharing Your Information

        <br>We do not sell your personal information. We only share your data with trusted third parties (e.g., payment processors, delivery services) as necessary to fulfill your order.
        <br>5. Security Measures
        <br>We implement security measures, such as encryption and secure server connections, to protect your personal information from unauthorized access.

        <br>6. Your Rights

        <br>Access and Correction: You can request a copy of your data and ask us to correct any inaccuracies.
        <br>Data Deletion: You can request the deletion of your personal information under certain conditions.
        <br>Marketing Preferences: Opt out of receiving marketing communications at any time.

        <br>8. Updates to This Policy
        <br>We may update this policy occasionally. Any changes will be posted on this page, and we encourage you to review it regularly.

        <br>9. Contact Us
        <br>If you have any questions or concerns about this Privacy Policy, please contact us.</p>
    </div>
</div>

<script>
    // JavaScript for opening and closing modals
    const privacyNoticeLink = document.getElementById('privacyNoticeLink');
    const privacyNoticeModal = document.getElementById('privacyNoticeModal');
    const closePrivacyNotice = document.getElementById('closePrivacyNotice');

    const privacyPolicyLink = document.getElementById('privacyPolicyLink');
    const privacyPolicyModal = document.getElementById('privacyPolicyModal');
    const closePrivacyPolicy = document.getElementById('closePrivacyPolicy');

    privacyNoticeLink.addEventListener('click', (e) => {
        e.preventDefault();
        privacyNoticeModal.style.display = 'block';
    });

    privacyPolicyLink.addEventListener('click', (e) => {
        e.preventDefault();
        privacyPolicyModal.style.display = 'block';
    });

    closePrivacyNotice.addEventListener('click', () => {
        privacyNoticeModal.style.display = 'none';
    });

    closePrivacyPolicy.addEventListener('click', () => {
        privacyPolicyModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === privacyNoticeModal) {
            privacyNoticeModal.style.display = 'none';
        }
        if (event.target === privacyPolicyModal) {
            privacyPolicyModal.style.display = 'none';
        }
    });
</script>
