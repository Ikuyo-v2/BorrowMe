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



$related_sql = "SELECT * FROM books WHERE id != ? LIMIT 5";
$related_stmt = $conn->prepare($related_sql);
$related_stmt->bind_param("i", $book['id']);
$related_stmt->execute();
$related_books = $related_stmt->get_result();
$related_stmt->close();


$recommended_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
                    FROM books b 
                    JOIN categories c ON b.category_id = c.id 
                    GROUP BY b.id
                    ORDER BY RAND() 
                    LIMIT 10";

$recommended_stmt = $conn->prepare($recommended_sql);
$recommended_stmt->execute();
$recommended_result = $recommended_stmt->get_result();
while ($row = $recommended_result->fetch_assoc()) {
  $recommended_books[] = $row;
}
$recommended_stmt->close();


$hots_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
             FROM books b 
             JOIN categories c ON b.category_id = c.id 
             GROUP BY b.id
             ORDER BY b.id DESC 
             LIMIT 10";
$hots_stmt = $conn->prepare($hots_sql);
$hots_stmt->execute();
$hots_result = $hots_stmt->get_result();
while ($row = $hots_result->fetch_assoc()) {
  $hots_books[] = $row;
}


$new_sql= "SELECT b.id, b.image_path, b.title, b.author, b.release_date, c.category AS category_name 
                     FROM books b 
                     JOIN categories c ON b.category_id = c.id 
                     GROUP BY b.id
                     ORDER BY b.release_date DESC 
                     LIMIT 10";
$new_stmt = $conn->prepare($new_sql);
$new_stmt->execute();
$new_result = $new_stmt->get_result();
while ($row = $new_result->fetch_assoc()) {
  $new_books[] = $row;
}


$best_sql = "SELECT b.id, b.image_path, b.title, b.author, c.category AS category_name 
             FROM books b 
             JOIN categories c ON b.category_id = c.id 
             GROUP BY b.id
             ORDER BY b.release_date ASC
             LIMIT 10";
$best_stmt = $conn->prepare($best_sql);
$best_stmt->execute();
$best_result = $best_stmt->get_result();
while ($row = $best_result->fetch_assoc()) {
  $best_books[] = $row;
}





function truncate($string, $limit)
{
  if (mb_strlen($string) > $limit) {
    return mb_substr($string, 0, $limit) . "...";
  }
  return $string;
}


?>









<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BorrowMe</title>
  <link rel="stylesheet" href="home.css" />
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
        <li class="nav-item active"><a href="Home.php">Home</a></li>
        <li class="nav-item"><a href="categories.php">Categories</a></li>
        <li class="nav-item"><a href="pre-order.php">Pre-Orders</a></li>
        <li class="nav-item"><a href="new_release_1.php">New releases</a></li>
        <li class="nav-item"><a href="support.php">Support</a></li>
      </ul>
    </nav>
  </header>
  <section class="slideshow-container">
    <div class="slide fade active" style="transform: translateX(0); opacity: 1">
      <img src="imgs/slideshow1.jpg" alt="Slide 1" class="slide-image" />
    </div>
    <div class="slide fade" style="transform: translateX(100%); opacity: 0">
      <img src="imgs/slideshow2.jpg" alt="Slide 2" class="slide-image" />
    </div>
  </section>
  <script>
    let slideIndex = 1;
    const slides = document.getElementsByClassName("slide");
    function showSlides() {
      slides[slideIndex - 1].classList.remove("active");
      slides[slideIndex - 1].style.transform = "translateX(-100%)";
      slides[slideIndex - 1].style.opacity = "0";

      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }

      slides[slideIndex - 1].classList.add("active");
      slides[slideIndex - 1].style.transform = "translateX(0)";
      slides[slideIndex - 1].style.opacity = "1";

      setTimeout(() => {
        const oldIndex = slideIndex - 2;
        const resetIndex = oldIndex < 0 ? slides.length - 1 : oldIndex;
        slides[resetIndex].style.transform = "translateX(100%)";
      }, 1000);

      setTimeout(showSlides, 15000);
    }
    showSlides();
  </script>



  <section class="recommended-section">
    <h2>Recommended for you</h2>
    <div class="cards-carousel-wrapper">
      <button class="carousel-btn left-btn">&#10094;</button>
      <div class="cards-carousel">
        <?php foreach ($recommended_books as $id => $book): ?>
          <div class="card">
            <a href="product.php?id=<?php echo $book['id']; ?>">
              <button class="Border">
                <div class="image-container">
                  <img src="<?php echo ($book['image_path']); ?>" alt="img" />
                  <span class="fast-delivery">Fast Delivery</span>
                </div>
                <div class="card-text">
                  <p><?php echo truncate($book['title'], 20); ?></p>
                  <p><?php echo truncate($book['author'], 20); ?></p>
                  <p><?php echo truncate($book['category_name'], 20); ?></p>
                </div>
              </button>
            </a>
          </div>
        <?php endforeach; ?>


      </div>
      <button class="carousel-btn right-btn">&#10095;</button>

    </div>
    <button class="show-more-btn">Show More</button>
  </section>

  <section class="recommended-section">
    <h2>Hots & Popular</h2>
    <div class="cards-carousel-wrapper">
      <button class="carousel-btn left-btn">&#10094;</button>
      <div class="cards-carousel">
        <?php foreach ($hots_books as $id => $book): ?>
          <div class="card">
            <a href="product.php?id=<?php echo $book['id']; ?>">
              <button class="Border">
                <div class="image-container">
                  <img src="<?php echo ($book['image_path']); ?>" alt="img" />
                  <span class="fast-delivery">Fast Delivery</span>
                </div>
                <div class="card-text">
                  <p><?php echo truncate($book['title'], 20); ?></p>
                  <p><?php echo truncate($book['author'], 20); ?></p>
                  <p><?php echo truncate($book['category_name'], 20); ?></p>
                </div>
              </button>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-btn right-btn">&#10095;</button>
    </div>
    <button class="show-more-btn">Show More</button>
  </section>

    <section class="recommended-section">
    <h2>New Releases</h2>
    <div class="cards-carousel-wrapper">
      <button class="carousel-btn left-btn">&#10094;</button>
      <div class="cards-carousel">
        <?php foreach ($new_books as $id => $book): ?>
          <div class="card">
            <a href="product.php?id=<?php echo $book['id']; ?>">
              <button class="Border">
                <div class="image-container">
                  <img src="<?php echo ($book['image_path']); ?>" alt="img" />
                  <span class="fast-delivery">Fast Delivery</span>
                </div>
                <div class="card-text">
                  <p><?php echo truncate($book['title'], 20); ?></p>
                  <p><?php echo truncate($book['author'], 20); ?></p>
                  <p><?php echo truncate($book['category_name'], 20); ?></p>
                </div>
              </button>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-btn right-btn">&#10095;</button>
    </div>
    <button class="show-more-btn">Show More</button>
  </section>
  
  <section class="recommended-section">
  <h2>Best Of All TIme</h2>
  <div class="cards-carousel-wrapper">
    <button class="carousel-btn left-btn">&#10094;</button>
    <div class="cards-carousel">
      <?php foreach ($best_books as $id => $book): ?>
        <div class="card">
          <a href="product.php?id=<?php echo $book['id']; ?>">
            <button class="Border">
              <div class="image-container">
                <img src="<?php echo ($book['image_path']); ?>" alt="img" />
                <span class="fast-delivery">Fast Delivery</span>
              </div>
              <div class="card-text">
                <p><?php echo truncate($book['title'], 20); ?></p>
                <p><?php echo truncate($book['author'], 20); ?></p>
                <p><?php echo truncate($book['category_name'], 20); ?></p>
              </div>
            </button>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-btn right-btn">&#10095;</button>
  </div>
  <button class="show-more-btn">Show More</button>
</section>



  <script>
    const leftBtn = document.querySelector(".left-btn");
    const rightBtn = document.querySelector(".right-btn");
    const carousel = document.querySelector(".cards-carousel");

    leftBtn.addEventListener("click", () => {
      carousel.scrollBy({ left: -300, behavior: "smooth" });
    });

    rightBtn.addEventListener("click", () => {
      carousel.scrollBy({ left: 300, behavior: "smooth" });
    });
  </script>

  <br />
  <section class="news-section" style="background-color: #f0f0f0; padding: 40px 20px; text-align: center">
    <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 30px">
      News
    </h2>
    <div class="news-carousel-wrapper" style="
          position: relative;
          max-width: 1200px;
          margin: 0 auto;
          display: flex;
          align-items: center;
          justify-content: center;
        ">
      <button class="carousel-btn left-btn" aria-label="Previous News">
        &#10094;
      </button>
      <div class="news-carousel" style="
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 20px;
            padding: 10px 0;
            scrollbar-width: none;
          ">
        <div class="news-card" style="
              background-color: white;
              min-width: 220px;
              flex: 0 0 auto;
              border-radius: 8px;
              box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
              padding: 10px;
              text-align: center;
              position: relative;
            ">
          <div class="image-container" style="
                position: relative;
                width: 160px;
                height: 220px;
                margin: 0 auto 10px auto;
                border-radius: 6px;
                overflow: hidden;
              ">
            <img src="imgs/news/News1.png" alt="New Arrivals" style="width: 100%; height: 100%; object-fit: cover" />
            <div style="
                  position: absolute;
                  top: 8px;
                  left: 8px;
                  background: #e60000;
                  color: white;
                  font-size: 10px;
                  padding: 3px 8px;
                  border-radius: 10px 0 10px 10px;
                  font-weight: 600;
                  text-transform: uppercase;
                ">
              New Arrivals
            </div>
          </div>
          <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px">
            New !!!
          </div>
          <div style="font-weight: 600; font-size: 13px; margin-bottom: 10px">
            Ayo segera baca buku yang <br />dinanti-nantikan sekarang juga !
          </div>
          <button style="
                background: rgba(255, 0, 0, 0.67);
                color: white;
                border: none;
                border-radius: 25px;
                padding: 10px 20px;
                font-weight: 700;
                cursor: pointer;
              ">
            Start Reading
          </button>
        </div>

        <div class="news-card" style="
              background-color: white;
              min-width: 220px;
              flex: 0 0 auto;
              border-radius: 8px;
              box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
              padding: 10px;
              text-align: center;
              position: relative;
            ">
          <div class="image-container" style="
                position: relative;
                width: 160px;
                height: 220px;
                margin: 0 auto 10px auto;
                border-radius: 6px;
                overflow: hidden;
              ">
            <img src="imgs/news/News2.png" alt="Popular" style="width: 100%; height: 100%; object-fit: cover" />
            <div style="
                  position: absolute;
                  top: 8px;
                  left: 8px;
                  background: #ffb347;
                  color: black;
                  font-size: 10px;
                  padding: 3px 8px;
                  border-radius: 10px 0 10px 10px;
                  font-weight: 600;
                  text-transform: uppercase;
                ">
              Popular
            </div>
          </div>
          <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px">
            Popular
          </div>
          <div style="font-weight: 600; font-size: 13px; margin-bottom: 10px">
            Jangan ketinggalan Ayo baca sekarang !
          </div>
          <br />
          <button style="
                background: rgba(255, 0, 0, 0.67);
                color: white;
                border: none;
                border-radius: 25px;
                padding: 10px 20px;
                font-weight: 700;
                cursor: pointer;
              ">
            Start Reading
          </button>
        </div>

        <div class="news-card" style="
              background-color: white;
              min-width: 220px;
              flex: 0 0 auto;
              border-radius: 8px;
              box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
              padding: 10px;
              text-align: center;
              position: relative;
            ">
          <div class="image-container" style="
                position: relative;
                width: 160px;
                height: 220px;
                margin: 0 auto 10px auto;
                border-radius: 6px;
                overflow: hidden;
              ">
            <img src="imgs/news/News3.png" alt="Coming Soon" style="width: 100%; height: 100%; object-fit: cover" />
            <div style="
                  position: absolute;
                  top: 8px;
                  left: 8px;
                  background: #999;
                  color: white;
                  font-size: 10px;
                  padding: 3px 8px;
                  border-radius: 10px 0 10px 10px;
                  font-weight: 600;
                  text-transform: uppercase;
                ">
              Coming Soon
            </div>
          </div>
          <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px">
            Coming Soon
          </div>
          <div style="font-weight: 600; font-size: 13px; margin-bottom: 10px">
            Ayo nantikan buku kesayangan mu !
          </div>
          <br />
          <button style="
                background: rgba(255, 0, 0, 0.67);
                color: white;
                border: none;
                border-radius: 25px;
                padding: 10px 20px;
                font-weight: 700;
                cursor: pointer;
              ">
            Coming Soon
          </button>
        </div>

        <div class="news-card" style="
              background-color: white;
              min-width: 220px;
              flex: 0 0 auto;
              border-radius: 8px;
              box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
              padding: 10px;
              text-align: center;
              position: relative;
            ">
          <div class="image-container" style="
                position: relative;
                width: 160px;
                height: 220px;
                margin: 0 auto 10px auto;
                border-radius: 6px;
                overflow: hidden;
              ">
            <img src="imgs/news/News4.png" alt="Recommended" style="width: 100%; height: 100%; object-fit: cover" />
            <div style="
                  position: absolute;
                  top: 8px;
                  left: 8px;
                  background: #cc33cc;
                  color: white;
                  font-size: 10px;
                  padding: 3px 8px;
                  border-radius: 10px 0 10px 10px;
                  font-weight: 600;
                  text-transform: uppercase;
                ">
              Recommended
            </div>
          </div>
          <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px">
            Recommended
          </div>
          <div style="font-weight: 600; font-size: 13px; margin-bottom: 10px">
            Buku yang menarik dan <br>
            cocok untuk kamu baca
          </div>
          <br />
          <button style="
                background: rgba(255, 0, 0, 0.67);
                color: white;
                border: none;
                border-radius: 25px;
                padding: 10px 20px;
                font-weight: 700;
                cursor: pointer;
              ">
            Start Reading
          </button>
        </div>
      </div>
      <button class="carousel-btn right-btn" aria-label="Next News">
        &#10095;
      </button>
    </div>
  </section>
  <br />
  <br />

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