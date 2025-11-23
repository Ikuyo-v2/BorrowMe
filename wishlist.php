<?php
session_start();
require_once 'database.php';

$conn = db();

if (!isset($_SESSION['user_name'])) {
    // User not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

$user_table = preg_replace('[^a-zA-Z0-9_]', '_', $_SESSION['user_name']); // sanitize table name

$table_check_query = "SHOW TABLES LIKE '" . $conn->real_escape_string($user_table) . "'";
$result = $conn->query($table_check_query);

if ($result->num_rows === 0) {
    // Create table
    $create_table_query = "CREATE TABLE `$user_table` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        book_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $conn->query($create_table_query);
}

$wishlist_sql = "SELECT b.*, c.category, w.quantity 
                 FROM `$user_table` w
                 JOIN books b ON w.book_id = b.id
                 JOIN categories c ON b.category_id = c.id
                 ORDER BY w.date_added DESC";

$wishlist_result = $conn->query($wishlist_sql);
$wishlist_items = [];

if ($wishlist_result) {
    while ($row = $wishlist_result->fetch_assoc()) {
        $wishlist_items[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BorrowMe - Wishlist</title>
  <link rel="stylesheet" href="wishlist.css">
  <link rel="stylesheet" href="home.css">
</head>
<body>

  <!-- Header -->
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
        <li class="nav-item"><a href="support.php">Support</a></li>
      </ul>
    </nav>
  </header>
  <!-- Wishlist -->
  <section class="wishlist-section">
    <h2>Wishlist :</h2>

    <?php if (count($wishlist_items) === 0): ?>
        <p>Your wishlist is empty.</p>
    <?php else: ?>
        <?php foreach ($wishlist_items as $item): ?>
            <div class="wishlist-item" data-book-id="<?php echo ($item['id']); ?>">
              <input type="checkbox">
              <img src="<?php echo ($item['image_path']); ?>" alt="<?php echo ($item['title']); ?>">
              <div class="info">
                <h3><?php echo ($item['title']); ?></h3>
                <p><?php echo ($item['author']); ?></p>
                <span><?php echo ($item['category']); ?></span>
              </div>
              <div class="quantity">
                <button class="minus">−</button>
                <span class="count"><?php echo ($item['quantity']); ?></span>
                <button class="plus">+</button>
              </div>
              <button class="remove-btn">Remove</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <button class="order-btn"><a style="text-decoration:none; color:inherit;" href="Pickup.php">Pesan Sekarang</a></button>
  </section>

  <!-- Footer -->
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

  <!-- Script -->
  <script>
    // Fungsi untuk menambah / mengurangi jumlah dan handle remove button
    document.querySelectorAll('.wishlist-item').forEach(item => {
      const plus = item.querySelector('.plus');
      const minus = item.querySelector('.minus');
      const count = item.querySelector('.count');
      const removeBtn = item.querySelector('.remove-btn');
      const bookId = item.getAttribute('data-book-id');
      let value = parseInt(count.textContent);

      plus.addEventListener('click', () => {
        value++;
        updateQuantity(bookId, value);
        count.textContent = value;
      });

      minus.addEventListener('click', () => {
        if (value > 1) {
          value--;
          updateQuantity(bookId, value);
          count.textContent = value;
        }
      });

      removeBtn.addEventListener('click', () => {
          if (confirm('Are you sure you want to remove this item from wishlist?')) {
              removeItem(bookId);
              item.remove();
          }
      });
    });

    function updateQuantity(bookId, quantity) {
      fetch('wishlist_action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=update&book_id=${bookId}&quantity=${quantity}`
      });
    }

    function removeItem(bookId) {
      fetch('wishlist_action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=remove&book_id=${bookId}`
      });
    }
  </script>
</body>
</html>

