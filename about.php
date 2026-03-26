<?php include 'includes/header.php'; ?>

<style>
/* عام للصفحة */
body {
    background: #f5f7fb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* حاوية المحتوى */
.about-container {
    max-width: 900px;
    margin: 80px auto;
    padding: 40px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    text-align: center;
    animation: fadeIn 1s ease-in-out;
}

/* العنوان */
.about-container h2 {
    font-size: 32px;
    color: #37493b;
    margin-bottom: 20px;
    position: relative;
}

.about-container h2::after {
    content: '';
    width: 60px;
    height: 4px;
    background: #37493b;
    display: block;
    margin: 10px auto 0;
    border-radius: 2px;
}

/* الفقرة */
.about-container p {
    font-size: 18px;
    color: #555;
    line-height: 1.8;
    margin-bottom: 25px;
}

/* زر العودة للصفحة الرئيسية */
.back-home {
    display: inline-block;
    padding: 12px 25px;
    background: #37493b;
    color: #fff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.back-home:hover {
    background: #2c3e2f;
}

/* إضافة تأثير fadeIn */
@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>

<div class="about-container">
    <h2>About Us 🛒</h2>
    <p>Welcome to our E-commerce store! This project is built using PHP and MySQL. 
    Here you can browse, add products to your cart, and place orders online. 
    Our goal is to provide a smooth and secure shopping experience for everyone.</p>
    
    <p>We designed this project to practice full-stack development skills, including backend programming, database management, and responsive front-end design.</p>
    
    <a href="index.php" class="back-home">🏠 Back to Home</a>
</div>

<?php include 'includes/footer.php'; ?>