CREATE DATABASE rezervasyon_sistemi;
USE rezervasyon_sistemi;

CREATE TABLE sirket_hesaplar (
    sirket_id VARCHAR(64) NOT NULL,
    sirket_adi VARCHAR(250) NOT NULL,
    telefon VARCHAR(25) NOT NULL,
    mail VARCHAR(250) NOT NULL,
    sifre VARCHAR(64) NOT NULL,
    sirket_turu VARCHAR(50) NOT NULL,
    PRIMARY KEY(sirket_id)
);

CREATE TABLE musteriler (
    musteri_id VARCHAR(64) NOT NULL,
    ad VARCHAR(64) NOT NULL,
    soyad VARCHAR(64) NOT NULL,
    telefon VARCHAR(25) NOT NULL,
    mail VARCHAR(250) NOT NULL,
    sifre VARCHAR(64) NOT NULL,
    PRIMARY KEY(musteri_id)
);

CREATE TABLE seferler (
    sefer_id VARCHAR(64) NOT NULL,
    sirket_id VARCHAR(64) NOT NULL,
    kalkis_noktasi VARCHAR(250) NOT NULL,
    varis_noktasi VARCHAR(250) NOT NULL,
    kalkis_saati DATETIME NOT NULL,
    varis_saati DATETIME NOT NULL,
    kapasite INT NOT NULL,
    ucret DECIMAL(10,2) NOT NULL,
    bos_koltuk_sayisi INT NOT NULL,
    arac_turu VARCHAR(50) NOT NULL,
    PRIMARY KEY(sefer_id),
    FOREIGN KEY(sirket_id) REFERENCES sirket_hesaplar(sirket_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE oteller (
    otel_id VARCHAR(64) NOT NULL,
    sirket_id VARCHAR(64) NOT NULL,
    otel_adi VARCHAR(250) NOT NULL,
    konum VARCHAR(250) NOT NULL,
    yildiz_sayisi INT NOT NULL,
    oda_turu VARCHAR(50) NOT NULL,
    bos_oda_sayisi INT NOT NULL,
    ucret DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(otel_id),
    FOREIGN KEY(sirket_id) REFERENCES sirket_hesaplar(sirket_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE rezervasyonlar (
    rezervasyon_id VARCHAR(64) NOT NULL,
    musteri_id VARCHAR(64) NOT NULL,
    baslangic_tarihi DATETIME NOT NULL,
    bitis_tarihi DATETIME NOT NULL,
    toplam_ucret DECIMAL(10,2) NOT NULL,
    rezervasyon_turu VARCHAR(50) NOT NULL,
    rezervasyon_zamani DATETIME NOT NULL,
    durum VARCHAR(50) NOT NULL,
    PRIMARY KEY(rezervasyon_id),
    FOREIGN KEY(musteri_id) REFERENCES musteriler(musteri_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE odeme_bilgiler (
    odeme_id VARCHAR(64) NOT NULL,
    rezervasyon_id VARCHAR(64) NOT NULL,
    odeme_turu VARCHAR(50) NOT NULL,
    odeme_tutari DECIMAL(10,2) NOT NULL,
    odeme_tarihi DATETIME NOT NULL,
    para_birimi VARCHAR(10) NOT NULL,
    iade_durum VARCHAR(50) NOT NULL,
    iade_tarihi DATETIME,
    PRIMARY KEY(odeme_id),
    FOREIGN KEY(rezervasyon_id) REFERENCES rezervasyonlar(rezervasyon_id)
        ON DELETE CASCADE ON UPDATE CASCADE
); 