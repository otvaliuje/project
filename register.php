<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $mail = $_POST['mail'];
    $sifre = $_POST['sifre'];
    
    $musteri_id = uniqid('MUST_');
    
    $sql = "INSERT INTO musteriler (musteri_id, ad, soyad, telefon, mail, sifre) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $musteri_id, $ad, $soyad, $telefon, $mail, $sifre);
    
    if ($stmt->execute()) {
        $_SESSION['musteri_id'] = $musteri_id;
        $_SESSION['ad'] = $ad;
        $_SESSION['soyad'] = $soyad;
        header("Location: index.php");
        exit();
    } else {
        $error = "Kayıt sırasında bir hata oluştu!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Rezervasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Rezervasyon Sistemi</div>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="login.php">Giriş</a></li>
                <li><a href="register.php">Kayıt Ol</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Kayıt Ol</h2>
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="ad">Ad:</label>
                    <input type="text" id="ad" name="ad" required>
                </div>
                
                <div class="form-group">
                    <label for="soyad">Soyad:</label>
                    <input type="text" id="soyad" name="soyad" required>
                </div>
                
                <div class="form-group">
                    <label for="telefon">Telefon:</label>
                    <input type="tel" id="telefon" name="telefon" required>
                </div>
                
                <div class="form-group">
                    <label for="mail">E-posta:</label>
                    <input type="email" id="mail" name="mail" required>
                </div>
                
                <div class="form-group">
                    <label for="sifre">Şifre:</label>
                    <input type="password" id="sifre" name="sifre" required>
                </div>
                
                <button type="submit">Kayıt Ol</button>
            </form>
            
            <p class="form-footer">
                Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a>
            </p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html> 