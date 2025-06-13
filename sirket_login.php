<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = $_POST['mail'];
    $sifre = $_POST['sifre'];
    
    $sql = "SELECT * FROM sirket_hesaplar WHERE mail = ? AND sifre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $mail, $sifre);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $sirket = $result->fetch_assoc();
        $_SESSION['sirket_id'] = $sirket['sirket_id'];
        $_SESSION['sirket_adi'] = $sirket['sirket_adi'];
        header("Location: sirket_panel.php");
        exit();
    } else {
        $error = "Geçersiz e-posta veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şirket Girişi - Rezervasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Rezervasyon Sistemi</div>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="sirket_login.php">Şirket Girişi</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Şirket Girişi</h2>
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="sirket_login.php" method="POST">
                <div class="form-group">
                    <label for="mail">E-posta:</label>
                    <input type="email" id="mail" name="mail" required>
                </div>
                
                <div class="form-group">
                    <label for="sifre">Şifre:</label>
                    <input type="password" id="sifre" name="sifre" required>
                </div>
                
                <button type="submit">Giriş Yap</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html> 