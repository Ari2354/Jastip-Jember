<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jastip 
    Jember</title>
  <link rel="stylesheet" href="aset/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@1,100;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
  
  <header>
    <h1>Jastip Jember</h1>
    <div class="logo">
      <img src="aset/logologin.png" alt="Logo">
    </div>
    <nav>
      <ul class="navigasi">
        <li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
        <li><a href="#"><i class="fas fa-info"></i> Tentang Kami</a></li>
        <li><a href="#"><i class="fas fa-phone"></i> Kontak</a></li>
      </ul>
    </nav>
    <button class="tombol-menu" onclick="toggleNavigasi()">
      <i class="fas fa-bars"></i>
    </button>
  </header>

  <script>
    function toggleNavigasi() {
      const navigasi = document.querySelector('.navigasi');
      navigasi.classList.toggle('show');
    }
  </script>
</body>
</html>
