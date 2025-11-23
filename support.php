<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Support | BorrowMe</title>
  <link rel="stylesheet" href="support.css">
  <link rel="stylesheet" href="home.css">
</head>
<body>


<header>
    <div class="top-bar">
      <div class="logo-container">
        <a href="home.php">
          <img src="imgs/Logo.png" alt="BorrowMe Logo" class="logo" />
        </a>
      </div>
      <a href="search.php" style="text-decoration:none;">
      <form class="search-form">
        <input type="text" placeholder="Search: text book, e-books, journals, etc" class="search-input" />
      </form>
      </a>
      <div class="auth-links">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a href="login.php" class="login-link">Login</a>
          <a href="Register.php" class="account-link">Make an account</a>
        <?php else: ?>
          <div class="user-menu">
            <a href="profile.php" class="profile-link"><img src="imgs/icons/heart.png" alt="" class="icons"></a>
            <a href="wishlist.php" class="profile-link"><img src="imgs/icons/User.png" alt="" class="icons"></a>
            <a href="logout.php" class="logout-link">Logout</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <nav class="nav-bar">
      <ul class="nav-menu">
        <li class="nav-item"><a href="Home.php">Home</a></li>
        <li class="nav-item"><a href="categories.php">Categories</a></li>
        <li class="nav-item"><a href="pre-order.php">Pre-Orders</a></li>
        <li class="nav-item"><a href="new_release_1.php">New releases</a></li>
        <li class="nav-item active"><a href="support.php">Support</a></li>
      </ul>
    </nav>
  </header>

  <!-- Title Bar -->
  <div class="title-bar">
    <h2>SUPPORT</h2>
  </div>

  <!-- Support Section (BOX) -->
  <section class="box support-section">
    <h3>What can we help you with?</h3>
    <input type="text" class="search-box" placeholder="Search your Problem">
    <button class="btn-search">Search articles</button>
  </section>

  <!-- Contact Section (BOX) -->
  <section class="box contact-section">
    <h3 class="contact-title">Contact Us 💬</h3>

    <div class="faq-section">
      <h4>❓ Question?</h4>
      <p>Need a quick answer to your question? Check out our FAQs for answers to some of the most common questions.</p>
      <a href="#" class="btn-faq">VISIT FAQ</a>
    </div>

    <div class="location-section">
      <h4>📍 Our Location</h4>
      <p><strong>Address:</strong><br>
        BorrowMe BookStore<br>
        Pt . Indonesian Smart <br>
        Jl. Letjen Sutoyo <br>
        Kristen Immanuel School<br>
        Pontianak Barat
      </p>
    </div>

    <div class="call-section">
      <h4>📞 Call Us</h4>
      <p><strong>Monday – Saturday:</strong> 07:00 – 17:00 WIB<br>
        +62 82137018719 (WA)<br>
        +62 81439298170 (Office)<br>
        Email: <a href="mailto:BorrowMe@lbry.com">BorrowMe@lbry.com</a>
      </p>
    </div>
  </section>

  <!-- Footer (BOX) -->
 <footer class="footer">
      <div class="footer-container">
        <div class="footer-section footer-left">
          <h2>BorrowMe</h2>
          <p>Email : BorrowMe@Lbry.com</p>
          <p>Wa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: +62 81251768179</p>
        </div>
        <div class="footer-section footer-right"></div>
        <div class="footer-section footer-right"></div>
        <div class="footer-section footer-middle">
          <h3>About us</h3>
          <div class="footer-names">
            <p>Aricks Wijaya</p>
            <p>David Aditya Wijaya</p>
            <p>Daniel Riady</p>
          </div>
        </div>
        <div class="footer-section footer-right">
          <h3>Absen</h3>
          <div class="footer-absen">
            <p>05</p>
            <p>12</p>
            <p>14</p>
          </div>
        </div>
      </div>
      <hr />

      <p class="footer-copyright">Copyright BorrowMe. All Right Reserved</p>
    </footer>

</body>
