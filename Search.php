<?php
session_start();
require_once 'database.php';

$conn = db();
$search_query = '';
$results = [];

if (isset($_GET['q'])) {
    $search_query = trim($_GET['q']);
    if ($search_query !== '') {
        $sql = "SELECT b.*, c.category FROM books b 
                JOIN categories c ON b.category_id = c.id 
                WHERE b.title LIKE ? 
                OR b.author LIKE ? 
                OR c.category LIKE ?";

        $param = '%' . $search_query . '%';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $param, $param, $param);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorrowMe - Search Results</title>
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="new_release_2.css" />
    <link rel="stylesheet" href="categories.css" />
</head>
<body>

<header>
    <div class="top-bar">
      <div class="logo-container">
        <a href="home.php">
          <img src="imgs/Logo.png" alt="BorrowMe Logo" class="logo" />
        </a>
      </div>
      <form class="search-form" method="GET" action="Search.php">
        <input type="text" name="q" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search: text book, e-books, journals, etc" class="search-input" />
        <button type="submit">Search</button>
      </form>
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
<br>
<br>
<div class="search-results-container" style="max-width: 800px; margin: 0 auto;">
  <h2>Search results for "<?php echo htmlspecialchars($search_query); ?>"</h2>

  <?php if ($search_query === ''): ?>
    <p>Please enter a search term.</p>
  <?php elseif (count($results) === 0): ?>
    <p>No results found.</p>
  <?php else: ?>

    <section class="books">
    <div class="categories-books">
      <?php foreach ($results as $book): ?>
        <a href="product.php?id=<?php echo $book['id']; ?>" style="text-decoration: none; color: inherit;">
          <button class="book-card">
            <div class="image-container">
              <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" />
            </div>
            <div class="card-text">
              <p><?php echo (mb_strlen($book['title']) > 20) ? mb_substr($book['title'], 0, 20) . "..." : htmlspecialchars($book['title']); ?></p>
              <p><?php echo (mb_strlen($book['author']) > 20) ? mb_substr($book['author'], 0, 20) . "..." : htmlspecialchars($book['author']); ?></p>
              <p><?php echo (mb_strlen($book['category']) > 20) ? mb_substr($book['category'], 0, 20) . "..." : htmlspecialchars($book['category']); ?></p>
            </div>
          </button>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
</section>




<br><br>

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
</html>