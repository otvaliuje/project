<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Rezervasyon Sistemi</div>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <?php if(isset($_SESSION['musteri_id'])): ?>
                    <li><a href="rezervasyonlarim.php">Rezervasyonlarım</a></li>
                    <li><a href="profil.php">Profilim</a></li>
                    <li><a href="logout.php">Çıkış</a></li>
                <?php else: ?>
                    <li><a href="login.php">Giriş</a></li>
                    <li><a href="register.php">Kayıt Ol</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Rezervasyon Ara</h2>
            <form action="arama.php" method="GET">
                <div class="search-type">
                    <label>
                        <input type="radio" name="tip" value="otel" checked> Otel
                    </label>
                    <label>
                        <input type="radio" name="tip" value="sefer"> Sefer
                    </label>
                </div>
                
                <div class="search-fields">
                    <input type="text" name="kalkis" placeholder="Kalkış Noktası">
                    <input type="text" name="varis" placeholder="Varış Noktası">
                    <input type="date" name="tarih">
                    <button type="submit">Ara</button>
                </div>
            </form>
        </section>

        <section class="featured">
            <h2>Öne Çıkan Oteller</h2>
            <div class="featured-items">
                <?php
                $sql = "SELECT * FROM oteller ORDER BY yildiz_sayisi DESC LIMIT 3";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <div class="item">
                    <h3><?php echo $row['otel_adi']; ?></h3>
                    <p>Konum: <?php echo $row['konum']; ?></p>
                    <p>Yıldız: <?php echo $row['yildiz_sayisi']; ?></p>
                    <p>Fiyat: <?php echo $row['ucret']; ?> TL</p>
                    <a href="detay.php?tip=otel&id=<?php echo $row['otel_id']; ?>" class="btn">Detaylar</a>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="featured">
            <h2>Popüler Seferler</h2>
            <div class="featured-items">
                <?php
                $sql = "SELECT * FROM seferler ORDER BY kalkis_saati DESC LIMIT 3";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <div class="item">
                    <h3><?php echo $row['kalkis_noktasi']; ?> - <?php echo $row['varis_noktasi']; ?></h3>
                    <p>Tarih: <?php echo date('d.m.Y H:i', strtotime($row['kalkis_saati'])); ?></p>
                    <p>Araç: <?php echo $row['arac_turu']; ?></p>
                    <p>Fiyat: <?php echo $row['ucret']; ?> TL</p>
                    <a href="detay.php?tip=sefer&id=<?php echo $row['sefer_id']; ?>" class="btn">Detaylar</a>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html> 