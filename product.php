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






function truncate($string, $limit) {
    if (mb_strlen($string) > $limit) {
        return mb_substr($string, 0, $limit) . "...";
    }
    return $string;
}





$conn = mysqli_connect("localhost", "root", "", "borrowme");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
  header("Location: home.php");
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_wishlist'])) {
    if (!$user_name) {
        header("Location: login.php");
        exit();
    }

    $book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
    if ($book_id <= 0) {
        die("Invalid book id");
    }

    $conn = mysqli_connect("localhost", "root", "", "borrowme");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_table = preg_replace('/[^a-zA-Z0-9_]/', '_', $user_name);

    $table_check_query = "SHOW TABLES LIKE '" . $conn->real_escape_string($user_table) . "'";
    $result = $conn->query($table_check_query);

    if ($result->num_rows === 0) {
        $create_table_query = "CREATE TABLE `$user_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            book_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $conn->query($create_table_query);
    }

    $check_query = "SELECT quantity FROM `$user_table` WHERE book_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $check_result = $stmt->get_result();
    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1;

        $update_query = "UPDATE `$user_table` SET quantity = ? WHERE book_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $new_quantity, $book_id);
        $stmt->execute();
    } else {
        $insert_query = "INSERT INTO `$user_table` (book_id, quantity) VALUES (?, 1)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
    }

    header("Location: product.php?id=$book_id&wishlist=added");
    exit();
}

$book_id = (int)$_GET['id'];

$sql = "SELECT books.*, categories.category AS category_name
        FROM books
        JOIN categories ON books.category_id = categories.id
        WHERE books.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

$book = $result->fetch_assoc();

if (!$book) {
  die("Book not found");
}

$related_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
                    FROM books b 
                    JOIN categories c ON b.category_id = c.id 
                    GROUP BY b.id
                    ORDER BY RAND() 
                    LIMIT 25";
$related_stmt = $conn->prepare($related_sql);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
$related_books = $related_result;

$title = $book['title'];
$author = $book['author'];
$category = $book['category_name'];
$description = $book['description'] ? nl2br($book['description']) : ''; 
$image = $book['image_path'];


?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title> <?php echo $book['title']; ?> </title>
  <link rel="stylesheet" href="home.css" />
</head>

<body>
  <header>
    <div class="top-bar">
      <div class="logo-container">
        <img src="imgs/Logo.png" alt="BorrowMe Logo" class="logo" />
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
            <a href="profile.php" class="profile-link"><img src="imgs/icons/User.png" alt="" class="icons"></a>
            <a href="logout.php" class="logout-link">Logout</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <nav class="nav-bar">
      <ul class="nav-menu">
        <li class="nav-item active"><a href="Home.php">Home</a></li>
        <li class="nav-item"><a href="categories.php">Categories</a></li>
        <li class="nav-item"><a href="#">Pre-Orders</a></li>
        <li class="nav-item"><a href="new_release_1.php">New releases</a></li>
        <li class="nav-item"><a href="support.html">Support</a></li>
      </ul>
    </nav>
  </header>

  <main class="product-main">
    <div class="product-container" style="
          display: flex;
          gap: 20px;
          max-width: 800px;
          margin: 20px 0;
          padding: 20px;
        ">
      <img src=" <?php echo $book['image_path']; ?> " alt="Warriors Natalie & Sara"
        style="width: 200px; height: auto; flex-shrink: 0" />
      <div class="product-details" style="flex: 1">
        <h1 style="margin: 0 0 10px 0; font-size: 2em"> <?php echo $book['title']; ?> </h1>
        <h2 style="margin: 0 0 10px 0; color: #222; font-size: 1.3em">
          <?php echo $book['author']; ?>
        </h2>
        <div style="font-size: 1.1em; margin-bottom: 18px"> <?php echo $book['category_name']; ?> </div>
        <div style="
              background: #ededed;
              padding: 14px 18px;
              border-radius: 6px;
              width: fit-content;
              font-size: 1em;
              margin-bottom: 10px;
            ">

          <script>
            const today = new Date();
            const tiga_hari_kemudian = new Date(today);
            tiga_hari_kemudian.setDate(today.getDate() + 3);

            const year = tiga_hari_kemudian.getFullYear();
            const month = String(tiga_hari_kemudian.getMonth() + 1).padStart(2, '0');
            const day = String(tiga_hari_kemudian.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;

            document.write("Estimasi Tiba : " + formattedDate);
          </script>
        </div>
            <form method="POST" style="display: inline; margin-top: 16px;">
    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
    <button type="submit" name="add_wishlist" style="
          background: #f00;
          color: #fff;
          border: none;
          border-radius: 24px;
          padding: 12px 32px;
          font-size: 16px;
          cursor: pointer;
        ">
      Add to wishlist
    </button>
  </form>
      </div>
    </div>
  </main>
  <div style="max-width: 800px; margin: 0 32px auto">
    <h2 style="color: #444; margin-bottom: 10px">Description:</h2>
    <p style="font-size: 1.07em; color: #444; margin-top: 0">
      <?php echo $book['description']; ?>
    </p>
  </div>


  <div style="max-width: none; margin: 100px">
    <h2 style="margin: 18px">Produk Lainnya :</h2>
    <div id="produk-lainnya-scroll" style="
          display: flex;
          gap: 100px;
          margin-bottom: 32px;
          overflow-x: auto;
          white-space: nowrap;
          scroll-behavior: smooth;
        ">
      <?php while ($related_book = $related_books->fetch_assoc()): ?>
        <div style="text-align: center; width: 120px; display: inline-block">
          <a href="product.php?id=<?php echo $related_book['id']; ?>" style="text-decoration: none; color: inherit;">
            <img src="<?php echo $related_book['image_path']; ?>" alt="<?php echo htmlspecialchars($related_book['title']); ?>" style="
                  width: 200px;
                  height: 280px;
                  object-fit: cover;
                  border-radius: 6px;
                " />
            <div style="font-weight: bold; margin-top: 8px"><?php echo truncate($book['title'], 20); ?> </div>
            <div style="font-size: 14px"><?php echo truncate($book['author'], 20); ?></div>
            <div style="font-size: 13px; color: #888"><?php echo truncate($book['category_name'], 20); ?></div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>



      </form>
    </div>
  </div>
  <script>
    const scrollContainer = document.getElementById("produk-lainnya-scroll");
    let scrollAmount = 0;
    let maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
  </script>

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