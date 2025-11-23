<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "borrowme");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT books.*, categories.category AS category_name 
        FROM books 
        JOIN categories ON books.category_id = categories.id 
        WHERE books.title = 'ERIN HUNTER WARRIORS' 
        AND books.author = 'Natalie & Sara'";

$result = mysqli_query($conn, $sql);
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) === 0) {
  die("No book found");
}

$books = [];
while ($row = mysqli_fetch_assoc($result)) {
  $books[] = $row;
}

$book = $books[0];


$title = $book['title'];
$author = $book['author'];
$category = $book['category_name'];
$description = $book['description'] ? nl2br($book['description']) : '';
$image = $book['image_path'];
$book = $books[0];



$recommended_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
                    FROM books b 
                    JOIN categories c ON b.category_id = c.id 
                    GROUP BY b.id
                    ORDER BY RAND() 
                    LIMIT 100";

$recommended_stmt = $conn->prepare($recommended_sql);
$recommended_stmt->execute();
$recommended_result = $recommended_stmt->get_result();
while ($row = $recommended_result->fetch_assoc()) {
  $recommended_books[] = $row;
}
$recommended_stmt->close();


function truncate($string, $limit)
{
  if (mb_strlen($string) > $limit) {
    return mb_substr($string, 0, $limit) . "...";
  }
  return $string;
}



















?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BorrowMe - Categories</title>
  <link rel="stylesheet" href="categories.css">
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
        <li class="nav-item active"><a href="categories.php">Categories</a></li>
        <li class="nav-item"><a href="pre-order.php">Pre-Orders</a></li>
        <li class="nav-item"><a href="new_release_1.php">New releases</a></li>
        <li class="nav-item"><a href="support.php">Support</a></li>
      </ul>
    </nav>
  </header>


  <?php
  // Get category from GET parameter if present
  $selected_category = isset($_GET['category']) ? $_GET['category'] : null;

  // Sanitize category input (basic)
  $selected_category = ($selected_category);

  // Fetch categories from DB to dynamically generate list, rather than hardcoding
  $categories_result = mysqli_query($conn, "SELECT category FROM categories ORDER BY category ASC");
  $categories = [];
  if ($categories_result) {
      while ($row = mysqli_fetch_assoc($categories_result)) {
          $categories[] = $row['category'];
      }
  }

  // Get books filtered by category if category param is set; else all books
  if ($selected_category && in_array($selected_category, $categories)) {
      // Prepare SQL with category filter
      $filtered_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
                      FROM books b 
                      JOIN categories c ON b.category_id = c.id 
                      WHERE c.category = ?
                      GROUP BY b.id
                      ORDER BY RAND()
                      LIMIT 100";

      $stmt = $conn->prepare($filtered_sql);
      $stmt->bind_param("s", $selected_category);
      $stmt->execute();
      $filtered_result = $stmt->get_result();
      $recommended_books = [];
      while ($row = $filtered_result->fetch_assoc()) {
          $recommended_books[] = $row;
      }
      $stmt->close();
  } else {
      // No category selected or invalid category, so show all recommended
      $recommended_books = [];
      $recommended_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
                      FROM books b 
                      JOIN categories c ON b.category_id = c.id 
                      GROUP BY b.id
                      ORDER BY RAND() 
                      LIMIT 100";

      $recommended_stmt = $conn->prepare($recommended_sql);
      $recommended_stmt->execute();
      $recommended_result = $recommended_stmt->get_result();
      while ($row = $recommended_result->fetch_assoc()) {
        $recommended_books[] = $row;
      }
      $recommended_stmt->close();
  }
  ?>

  <section class="categories">
    <h2>Categories:</h2>
    <div class="category-list">
      <p><a href="categories.php" class="<?php echo (!$selected_category) ? 'active-category' : ''; ?>">All Categories</a></p>
      <?php foreach ($categories as $category_name): ?>
        <p>
          <a href="categories.php?category=<?php echo urlencode($category_name); ?>" 
             class="<?php echo ($selected_category == $category_name) ? 'active-category' : ''; ?>">
            <?php echo ($category_name); ?>
          </a>
        </p>
      <?php endforeach; ?>
    </div>
  </section>


<section class="books">
    <div class="categories-books">
        <?php if (count($recommended_books) === 0): ?>
            <p>No books found in this category.</p>
        <?php else: ?>
            <?php foreach ($recommended_books as $id => $book): ?>
                <a href="product.php?id=<?php echo $book['id']; ?>" class="book-link">
                    <div class="book-card">
                        <div class="image-container">
                            <img src="<?php echo $book['image_path']; ?>" alt="<?php echo $book['title']; ?>" />
                        </div>
                        <div class="card-text">
                            <p class="book-title"><?php echo truncate($book['title'], 20); ?></p>
                            <p class="book-author"><?php echo truncate($book['author'], 20); ?></p>
                            <p class="book-category"><?php echo truncate($book['category_name'], 20); ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
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

</body>
</html>