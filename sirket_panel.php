<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['sirket_id'])) {
    header("Location: sirket_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tip']) && $_POST['tip'] == 'otel') {
        $otel_id = uniqid('OTEL_');
        $sirket_id = $_SESSION['sirket_id'];
        $otel_adi = $_POST['otel_adi'];
        $konum = $_POST['konum'];
        $yildiz_sayisi = $_POST['yildiz_sayisi'];
        $oda_turu = $_POST['oda_turu'];
        $bos_oda_sayisi = $_POST['bos_oda_sayisi'];
        $ucret = $_POST['ucret'] * 1.18; // KDV dahil

        $sql = "INSERT INTO oteller (otel_id, sirket_id, otel_adi, konum, yildiz_sayisi, oda_turu, bos_oda_sayisi, ucret) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisid", $otel_id, $sirket_id, $otel_adi, $konum, $yildiz_sayisi, $oda_turu, $bos_oda_sayisi, $ucret);
        
        if ($stmt->execute()) {
            $success = "Otel başarıyla eklendi!";
        } else {
            $error = "Otel eklenirken bir hata oluştu!";
        }
    } elseif (isset($_POST['tip']) && $_POST['tip'] == 'sefer') {
        $sefer_id = uniqid('SEFER_');
        $sirket_id = $_SESSION['sirket_id'];
        $kalkis_noktasi = $_POST['kalkis_noktasi'];
        $varis_noktasi = $_POST['varis_noktasi'];
        $kalkis_saati = $_POST['kalkis_saati'];
        $varis_saati = $_POST['varis_saati'];
        $kapasite = $_POST['kapasite'];
        $ucret = $_POST['ucret'] * 1.18; // KDV dahil
        $bos_koltuk_sayisi = $kapasite;
        $arac_turu = $_POST['arac_turu'];

        $sql = "INSERT INTO seferler (sefer_id, sirket_id, kalkis_noktasi, varis_noktasi, kalkis_saati, varis_saati, kapasite, ucret, bos_koltuk_sayisi, arac_turu) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssiids", $sefer_id, $sirket_id, $kalkis_noktasi, $varis_noktasi, $kalkis_saati, $varis_saati, $kapasite, $ucret, $bos_koltuk_sayisi, $arac_turu);
        
        if ($stmt->execute()) {
            $success = "Sefer başarıyla eklendi!";
        } else {
            $error = "Sefer eklenirken bir hata oluştu!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şirket Paneli - Rezervasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Şirket Paneli</div>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="sirket_logout.php">Çıkış</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Otel Ekle</h2>
            <?php if(isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="sirket_panel.php" method="POST">
                <input type="hidden" name="tip" value="otel">
                
                <div class="form-group">
                    <label for="otel_adi">Otel Adı:</label>
                    <input type="text" id="otel_adi" name="otel_adi" required>
                </div>
                
                <div class="form-group">
                    <label for="konum">Konum:</label>
                    <input type="text" id="konum" name="konum" required>
                </div>
                
                <div class="form-group">
                    <label for="yildiz_sayisi">Yıldız Sayısı:</label>
                    <input type="number" id="yildiz_sayisi" name="yildiz_sayisi" min="1" max="5" required>
                </div>
                
                <div class="form-group">
                    <label for="oda_turu">Oda Türü:</label>
                    <select id="oda_turu" name="oda_turu" required>
                        <option value="Standart">Standart</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="bos_oda_sayisi">Boş Oda Sayısı:</label>
                    <input type="number" id="bos_oda_sayisi" name="bos_oda_sayisi" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="ucret">Ücret (KDV Hariç):</label>
                    <input type="number" id="ucret" name="ucret" min="0" step="0.01" required>
                </div>
                
                <button type="submit">Otel Ekle</button>
            </form>
        </section>

        <section class="search-section">
            <h2>Sefer Ekle</h2>
            
            <form action="sirket_panel.php" method="POST">
                <input type="hidden" name="tip" value="sefer">
                
                <div class="form-group">
                    <label for="kalkis_noktasi">Kalkış Noktası:</label>
                    <input type="text" id="kalkis_noktasi" name="kalkis_noktasi" required>
                </div>
                
                <div class="form-group">
                    <label for="varis_noktasi">Varış Noktası:</label>
                    <input type="text" id="varis_noktasi" name="varis_noktasi" required>
                </div>
                
                <div class="form-group">
                    <label for="kalkis_saati">Kalkış Saati:</label>
                    <input type="datetime-local" id="kalkis_saati" name="kalkis_saati" required>
                </div>
                
                <div class="form-group">
                    <label for="varis_saati">Varış Saati:</label>
                    <input type="datetime-local" id="varis_saati" name="varis_saati" required>
                </div>
                
                <div class="form-group">
                    <label for="kapasite">Kapasite:</label>
                    <input type="number" id="kapasite" name="kapasite" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="ucret">Ücret (KDV Hariç):</label>
                    <input type="number" id="ucret" name="ucret" min="0" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="arac_turu">Araç Türü:</label>
                    <select id="arac_turu" name="arac_turu" required>
                        <option value="Uçak">Uçak</option>
                        <option value="Otobüs">Otobüs</option>
                    </select>
                </div>
                
                <button type="submit">Sefer Ekle</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html> 