<?php
session_start();
require_once 'database.php';

$conn = db();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_table = preg_replace('/[^a-zA-Z0-9_]/', '_', $_SESSION['user_name']); // sanitize table name

// Fetch wishlist items
$table_check_query = "SHOW TABLES LIKE '" . $conn->real_escape_string($user_table) . "'";
$result = $conn->query($table_check_query);

if ($result->num_rows === 0) {
    // Create table if not exists
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

// Initialize form variables for user info
$name = $email = $phone = $address = $branch = $pickup_time = $return_date = "";
$errors = [];
$submitted = false;
$confirmation_msg = "";

// handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $branch = $_POST['branch'] ?? '';
    $pickup_time = $_POST['pickup_time'] ?? '';
    $return_date = $_POST['return_date'] ?? '';

    // The quantities will come as an array keyed by book_id
    $quantities = $_POST['quantities'] ?? [];

    // Validate user inputs
    if (empty($name)) $errors[] = "Nama Lengkap wajib diisi.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (empty($phone)) $errors[] = "Nomor Telepon wajib diisi.";
    if (empty($address)) $errors[] = "Alamat Lengkap wajib diisi.";
    if (empty($branch)) $errors[] = "Cabang BorrowMe harus dipilih.";
    if (empty($pickup_time)) $errors[] = "Jam Pengambilan harus diisi.";
    if (empty($return_date)) $errors[] = "Tanggal Pengembalian harus diisi.";

    // Validate quantities for each wishlist book; must be >=1
    foreach ($wishlist_items as &$item) {
        $book_id = $item['id'];
        if (!isset($quantities[$book_id]) || intval($quantities[$book_id]) < 1) {
            $quantities[$book_id] = 1;
        }
        $item['quantity'] = intval($quantities[$book_id]);
    }
    unset($item);

    if (count($errors) === 0) {
        $submitted = true;
        $confirmation_msg = "Pesanan berhasil dibuat!<br>";
        $confirmation_msg .= "Nama: " . htmlspecialchars($name) . "<br>";
        $confirmation_msg .= "Email: " . htmlspecialchars($email) . "<br>";
        $confirmation_msg .= "Telepon: " . htmlspecialchars($phone) . "<br>";
        $confirmation_msg .= "Alamat: " . nl2br(htmlspecialchars($address)) . "<br>";
        $confirmation_msg .= "Cabang: " . htmlspecialchars($branch) . "<br>";
        $confirmation_msg .= "Jam Pengambilan: " . htmlspecialchars($pickup_time) . "<br>";
        $confirmation_msg .= "Tanggal Pengembalian: " . htmlspecialchars($return_date) . "<br>";
        $confirmation_msg .= "Produk yang dipesan:<br>";
        foreach ($wishlist_items as $item) {
            $confirmation_msg .= "- " . htmlspecialchars($item['title']) . " (Qty: " . $item['quantity'] . ")<br>";
        }
        // Optionally save order data in database here
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BorrowMe - Pickup</title>
  <link rel="stylesheet" href="pickup.css" />
  <link rel="stylesheet" href="home.css" />
</head>
<body>
<header>
  <div class="top-bar">
    <div class="logo-container">
      <a href="home.php"><img src="imgs/Logo.png" alt="BorrowMe Logo" class="logo" /></a>
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
          <a href="profile.php" class="profile-link"><img src="imgs/icons/heart.png" alt="" class="icons" /></a>
          <a href="wishlist.php" class="profile-link"><img src="imgs/icons/User.png" alt="" class="icons" /></a>
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
<main class="checkout-container">
  <div class="left">
    <h2>Checkout</h2>
    <p class="label">Metode Pengantaran</p>
    <div class="delivery-method">
      <button type="button" class="btn gray">Delivery</button>
      <button type="button" class="btn brown">Pick Up</button>
    </div>

    <?php if ($submitted): ?>
      <div class="confirmation" style="background:#d4edda; color:#155724; padding:10px; margin-bottom:10px; border-radius:5px;">
        <h3>Konfirmasi Pesanan</h3>
        <p><?php echo $confirmation_msg ?></p>
        <p><a href="pickup.php">Buat Pesanan Baru</a></p>
      </div>
    <?php else: ?>
      <?php if (!empty($errors)): ?>
        <div class="errors" style="color:red; margin-bottom:10px;">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="pickup.php">
        <label>Nama Lengkap *</label>
        <input type="text" name="name" required value="<?php echo htmlspecialchars($name) ?>" />

        <label>Email *</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($email) ?>" />

        <label>Nomor Telepon *</label>
        <input type="tel" name="phone" required value="<?php echo htmlspecialchars($phone) ?>" />

        <label>Alamat Lengkap *</label>
        <textarea name="address" rows="4" required><?php echo htmlspecialchars($address) ?></textarea>

        <label>Cabang BorrowMe *</label>
        <select name="branch" id="branch" onchange="updateAddress()" required>
          <option value="">-- Pilih Cabang --</option>
          <option value="sutoyo" <?php echo $branch === "sutoyo" ? "selected" : "" ?>>Cabang Sutoyo</option>
          <option value="gajahmada" <?php echo $branch === "gajahmada" ? "selected" : "" ?>>Cabang Gajahmada</option>
          <option value="adisucipto" <?php echo $branch === "adisucipto" ? "selected" : "" ?>>Cabang Adisucipto</option>
        </select>

        <label>Jam Pengambilan *</label>
        <input type="time" name="pickup_time" required value="<?php echo htmlspecialchars($pickup_time) ?>" />

        <label>Tanggal Pengembalian *</label>
        <input type="date" name="return_date" required value="<?php echo htmlspecialchars($return_date) ?>" />

        <label>Wishlist Produk *</label>
        <?php if(count($wishlist_items) === 0): ?>
          <p>Wishlist Anda kosong.</p>
        <?php else: ?>
          <?php foreach($wishlist_items as $item): ?>
            <div class="product-box" data-book-id="<?php echo $item['id']; ?>">
              <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" />
              <div>
                <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                <p><?php echo htmlspecialchars($item['author']); ?></p>
                <span><?php echo htmlspecialchars($item['category']); ?></span>
              </div>
              <div class="quantity">
                <button type="button" class="minus" onclick="changeQuantity(<?php echo $item['id']; ?>, -1)">−</button>
                <span id="qty-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                <button type="button" class="plus" onclick="changeQuantity(<?php echo $item['id']; ?>, 1)">+</button>
              </div>
              <input type="hidden" name="quantities[<?php echo $item['id']; ?>]" id="input-qty-<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>"/>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <label>Alamat toko :</label>
        <textarea id="alamatToko" readonly></textarea>

        <button type="submit" class="order-btn">Pesan Sekarang</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="right">
    <h3>Produk Wishlist Anda :</h3>
    <?php if(count($wishlist_items) === 0): ?>
      <p>Wishlist Anda kosong.</p>
    <?php else: ?>
      <?php foreach($wishlist_items as $item): ?>
        <div class="product-box" data-book-id="<?php echo $item['id']; ?>">
          <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" />
          <div>
            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
            <p><?php echo htmlspecialchars($item['author']); ?></p>
            <span><?php echo htmlspecialchars($item['category']); ?></span>
          </div>
          <div class="quantity">
            <button type="button" class="minus" onclick="changeQuantity(<?php echo $item['id']; ?>, -1)">−</button>
            <span id="display-qty-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
            <button type="button" class="plus" onclick="changeQuantity(<?php echo $item['id']; ?>, 1)">+</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<footer>
  <div class="footer-content">
    <div class="left">
      <h3>BorrowMe</h3>
      <p>Email : BorrowMe@Lbrary.com</p>
      <p>Wa : +62 81251768179</p>
    </div>

    <div class="right">
      <h3>About us</h3>
      <table>
        <tr><td>Aricks Wijaya</td><td>05</td></tr>
        <tr><td>David Aditya Wijaya</td><td>12</td></tr>
        <tr><td>Daniel Riady</td><td>14</td></tr>
      </table>
    </div>
  </div>
  <p class="copyright">Copyright BorrowMe. All Right Reserved</p>
</footer>

<script>
  function updateAddress() {
    const branch = document.getElementById("branch").value;
    const alamatToko = document.getElementById("alamatToko");

    if (branch === "sutoyo") {
      alamatToko.value = "Jalan Letjen Sutoyo, Parit Tokaya, Kec. Pontianak Selatan, Kota Pontianak, Kalimantan Barat 78121";
    } else if (branch === "gajahmada") {
      alamatToko.value = "Jalan Gajahmada No 20, Benua Melayu Darat, Kec. Pontianak Selatan, Kota Pontianak, Kalimantan Barat 78243";
    } else if (branch === "adisucipto") {
      alamatToko.value = "Jalan Adisucipto No 45, Sungai Raya, Kubu Raya, Kalimantan Barat 78121";
    } else {
      alamatToko.value = "";
    }
  }

  function changeQuantity(bookId, delta) {
    const qtySpan = document.getElementById(`qty-${bookId}`);
    const inputQty = document.getElementById(`input-qty-${bookId}`);
    const displayQtySpan = document.getElementById(`display-qty-${bookId}`);

    let currentQty = parseInt(qtySpan.textContent);
    let newQty = currentQty + delta;
    if (newQty < 1) newQty = 1;

    qtySpan.textContent = newQty;
    inputQty.value = newQty;

    if (displayQtySpan) {
      displayQtySpan.textContent = newQty;
    }
  }

  window.addEventListener('load', () => {
    updateAddress();
  });
</script>

</body>
</html>
