<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

$success = false;

// عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $message])) {
            $success = true;
        }
    }
}
?>

<style>
/* التصميم كما في السابق */
body { background: #f5f7fb; font-family: 'Segoe UI', sans-serif; }
.contact-container { max-width: 700px; margin: 80px auto; padding: 40px; background: #fff; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); text-align: center; }
.contact-container h2 { font-size: 32px; color: #37493b; margin-bottom: 25px; }
.contact-container form { display: flex; flex-direction: column; gap: 15px; margin-top: 20px; }
.contact-container input, .contact-container textarea { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 12px; font-size: 16px; }
.contact-container textarea { min-height: 120px; resize: vertical; }
.contact-container button { padding: 15px; background: #37493b; color: #fff; font-size: 18px; border: none; border-radius: 12px; cursor: pointer; }
.contact-container button:hover { background: #2c3e2f; }
.success-msg { background: #d4edda; padding: 15px; border-radius: 12px; margin-bottom: 20px; color: #155724; }
</style>

<div class="contact-container">
    <h2>Contact Us 📬</h2>

    <?php if ($success): ?>
        <div class="success-msg">
            ✅ Your message has been sent successfully!
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="👤 Your Name" required>
        <input type="email" name="email" placeholder="📧 Your Email" required>
        <textarea name="message" placeholder="✏️ Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>