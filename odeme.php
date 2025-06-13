<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['musteri_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['rezervasyon_id'])) {
    header("Location: index.php");
    exit();
}

$rezervasyon_id = $_GET['rezervasyon_id'];

$sql = "SELECT * FROM rezervasyonlar WHERE rezervasyon_id = ? AND musteri_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $rezervasyon_id, $_SESSION['musteri_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$rezervasyon = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $odeme_id = uniqid('ODEME_');
    $odeme_turu = $_POST['odeme_turu'];
    $odeme_tutari = $rezervasyon['toplam_ucret'];
    $odeme_tarihi = date('Y-m-d H:i:s');
    $para_birimi = 'TRY';
    $iade_durum = 'Beklemede';
    
    $sql = "INSERT INTO odeme_bilgiler (odeme_id, rezervasyon_id, odeme_turu, odeme_tutari, odeme_tarihi, para_birimi, iade_durum) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsss", $odeme_id, $rezervasyon_id, $odeme_turu, $odeme_tutari, $odeme_tarihi, $para_birimi, $iade_durum);
    
    if ($stmt->execute()) {
        header("Location: rezervasyonlarim.php");
        exit();
    } else {
        $error = "Ödeme sırasında bir hata oluştu!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme - Rezervasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Rezervasyon Sistemi</div>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="rezervasyonlarim.php">Rezervasyonlarım</a></li>
                <li><a href="logout.php">Çıkış</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Ödeme</h2>
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="payment-details">
                <h3>Rezervasyon Detayları</h3>
                <p>Rezervasyon Türü: <?php echo $rezervasyon['rezervasyon_turu']; ?></p>
                <p>Toplam Ücret: <?php echo $rezervasyon['toplam_ucret']; ?> TL</p>
            </div>
            
            <form action="odeme.php?rezervasyon_id=<?php echo $rezervasyon_id; ?>" method="POST">
                <div class="form-group">
                    <label for="odeme_turu">Ödeme Türü:</label>
                    <select id="odeme_turu" name="odeme_turu" required>
                        <option value="Kredi Kartı">Kredi Kartı</option>
                        <option value="Banka Ödemesi">Banka Ödemesi</option>
                    </select>
                </div>
                
                <div id="kredi_karti_detay" class="payment-details" style="display: none;">
                    <div class="form-group">
                        <label for="kart_no">Kart Numarası:</label>
                        <input type="text" id="kart_no" name="kart_no" maxlength="16" pattern="[0-9]{16}">
                    </div>
                    
                    <div class="form-group">
                        <label for="son_kullanma">Son Kullanma Tarihi:</label>
                        <input type="text" id="son_kullanma" name="son_kullanma" maxlength="5" placeholder="AA/YY">
                    </div>
                    
                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" maxlength="3" pattern="[0-9]{3}">
                    </div>
                </div>
                
                <div id="banka_detay" class="payment-details" style="display: none;">
                    <p>Banka Hesap Bilgileri:</p>
                    <p>Banka: X Bank</p>
                    <p>IBAN: TR00 0000 0000 0000 0000 0000 00</p>
                    <p>Hesap Sahibi: Rezervasyon Sistemi</p>
                </div>
                
                <button type="submit">Ödeme Yap</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
    </footer>

    <script>
        document.getElementById('odeme_turu').addEventListener('change', function() {
            var krediKartiDetay = document.getElementById('kredi_karti_detay');
            var bankaDetay = document.getElementById('banka_detay');
            
            if (this.value === 'Kredi Kartı') {
                krediKartiDetay.style.display = 'block';
                bankaDetay.style.display = 'none';
            } else {
                krediKartiDetay.style.display = 'none';
                bankaDetay.style.display = 'block';
            }
        });
    </script>
</body>
</html> 