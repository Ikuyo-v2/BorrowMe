
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
?>







<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BORROWME</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="Profile.css" />
  </head>
  <body>
    <div class="container">
      <header class="header">
        <div class="logo">
          <a href="home.php">
          <img src="imgs/Logo.png" alt="Logo" />
          </a>
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Cari sesuatu..." />
        </div>
        <div>
          <div
            style="
              display: flex;
              justify-content: space-between;
              align-items: center;
              gap: 20px;
            "
          >
            <a href="profile.php" class="profile-link"><img src="imgs/icons/heart.png" alt="" class="icons"></a>
            <a href="wishlist.php" class="profile-link"><img src="imgs/icons/User.png" alt="" class="icons"></a>
          </div>
        </div>
      </header>

      <div class="content">
        <aside class="sidebar">
          <div
            class="profile-header"
            style="display: flex; align-items: center; gap: 10px"
          >
            <img
              src="imgs/Logo.png"
              alt="Foto Profil"
              style="width: 80px; height: auto; border-radius: 50%"
            />
            <div style="display: flex; flex-direction: column; gap: 6px">
              <h3 style="margin: 0">Danvicks</h3>
              <button class="btn-nomor" style="margin-top: 2px">
                Tambahkan Nomor Hp
              </button>
            </div>
          </div>
          <nav class="menu">
            <h4>Menu</h4>
            <ul>
              <li>Chat</li>
              <li>Ulasan</li>
              <li>Pusat Bantuan</li>
              <li>Riwayat</li>z
              <li>Favorit</li>
            </ul>
            <h4>Peminjaman</h4>
            <ul>
              <li>Dalam Proses</li>
              <li>Selesai</li>
              <li>Dibatalkan</li>
            </ul>
          </nav>
        </aside>

        <section class="info-box">
          <h3>Informasi Pengguna</h3>
          <div class="info-grid">
            <p><span class="info-label">Nama:</span> Danvicks</p>
            <p><span class="info-label">Jenis Kelamin:</span> Pria</p>
            <p><span class="info-label">Tanggal Lahir:</span> 12-02-2009</p>
            <p><span class="info-label">Nomor HP:</span> -</p>
            <p><span class="info-label">Email:</span> Danvicks@gmail.com</p>
          </div>
          <div class="info-personal">
            <button class="btn-action">Ubah Password</button>
            <button class="btn-action">Pin Pembelian</button>
            <button class="btn-action">Verifikasi Instansi</button>
          </div>
        </section>

        <section class="alamat">
          <h3>Daftar Alamat</h3>
          <div class="search-alamat">
            <input type="text" placeholder="Cari alamat..." />
          </div>
          <div class="alamat-item">
            <strong>Rumah (Utama):</strong><br />
            Jl. Letjen Jendral S. Parman No. 123, Kota Pontianak, Kalimantan
            Barat, Indonesia<br />
            Sekolah Kristen Immanuel
          </div>
          <div class="alamat-item">
            <strong>Kantor:</strong><br />
            081189833888<br />
            Bangka Belitung Darat, Kec. Pontianak Tenggara, Kota Pontianak,
            Kalimantan Barat
          </div>
          <button class="btn-tambah">+ Tambah Alamat Baru</button>
        </section>
      </div>
    </div>
  </body>
</html>
