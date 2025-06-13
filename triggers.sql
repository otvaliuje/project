DELIMITER //
CREATE TRIGGER trg_rezervasyon_kapasite_kontrol
BEFORE INSERT ON rezervasyonlar
FOR EACH ROW
BEGIN
    DECLARE mevcut_kapasite INT;
    DECLARE rezervasyon_sayisi INT;
    
    IF NEW.rezervasyon_turu = 'Otel' THEN
        SELECT bos_oda_sayisi INTO mevcut_kapasite
        FROM oteller
        WHERE otel_id = NEW.rezervasyon_id;
        
        IF mevcut_kapasite <= 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Otel dolu!';
        END IF;
    ELSE
        SELECT bos_koltuk_sayisi INTO mevcut_kapasite
        FROM seferler
        WHERE sefer_id = NEW.rezervasyon_id;
        
        IF mevcut_kapasite <= 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Sefer dolu!';
        END IF;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER trg_rezervasyon_sonrasi_kapasite_guncelle
AFTER INSERT ON rezervasyonlar
FOR EACH ROW
BEGIN
    IF NEW.rezervasyon_turu = 'Otel' THEN
        UPDATE oteller
        SET bos_oda_sayisi = bos_oda_sayisi - 1
        WHERE otel_id = NEW.rezervasyon_id;
    ELSE
        UPDATE seferler
        SET bos_koltuk_sayisi = bos_koltuk_sayisi - 1
        WHERE sefer_id = NEW.rezervasyon_id;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER trg_iade_kontrol
BEFORE UPDATE ON odeme_bilgiler
FOR EACH ROW
BEGIN
    DECLARE rezervasyon_zamani DATETIME;
    
    IF NEW.iade_durum = 'İade Edildi' THEN
        SELECT r.rezervasyon_zamani INTO rezervasyon_zamani
        FROM rezervasyonlar r
        WHERE r.rezervasyon_id = NEW.rezervasyon_id;
        
        IF TIMESTAMPDIFF(HOUR, rezervasyon_zamani, NOW()) > 3 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'İade süresi 3 saati geçti!';
        END IF;
    END IF;
END //
DELIMITER ; 