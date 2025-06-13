DELIMITER $$
CREATE PROCEDURE sp_MusteriEkle (
    id VARCHAR(64),
    ad VARCHAR(64),
    soy VARCHAR(64),
    tel VARCHAR(25),
    mail VARCHAR(250),
    sifre VARCHAR(64)
)
BEGIN
    INSERT INTO musteriler
    VALUES (id, ad, soy, tel, mail, sifre);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_MusteriGuncelle (
    id VARCHAR(64),
    ad VARCHAR(64),
    soy VARCHAR(64),
    tel VARCHAR(25),
    mail VARCHAR(250),
    sifre VARCHAR(64)
)
BEGIN
    UPDATE musteriler
    SET 
        ad = ad,
        soyad = soy,
        telefon = tel,
        mail = mail,
        sifre = sifre
    WHERE musteri_id = id;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_SeferEkle (
    id VARCHAR(64),
    sid VARCHAR(64),
    kn VARCHAR(250),
    vn VARCHAR(250),
    ks DATETIME,
    vs DATETIME,
    kap INT,
    ucr DECIMAL(10,2),
    bks INT,
    at VARCHAR(50)
)
BEGIN
    INSERT INTO seferler
    VALUES (id, sid, kn, vn, ks, vs, kap, ucr, bks, at);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_OtelEkle (
    id VARCHAR(64),
    sid VARCHAR(64),
    oa VARCHAR(250),
    kon VARCHAR(250),
    ys INT,
    ot VARCHAR(50),
    bos INT,
    ucr DECIMAL(10,2)
)
BEGIN
    INSERT INTO oteller
    VALUES (id, sid, oa, kon, ys, ot, bos, ucr);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_RezervasyonEkle (
    id VARCHAR(64),
    mid VARCHAR(64),
    bt DATETIME,
    bit DATETIME,
    tu DECIMAL(10,2),
    rt VARCHAR(50),
    rz DATETIME,
    dur VARCHAR(50)
)
BEGIN
    INSERT INTO rezervasyonlar
    VALUES (id, mid, bt, bit, tu, rt, rz, dur);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_OdemeEkle (
    id VARCHAR(64),
    rid VARCHAR(64),
    ot VARCHAR(50),
    tut DECIMAL(10,2),
    otar DATETIME,
    pb VARCHAR(10),
    idur VARCHAR(50),
    itar DATETIME
)
BEGIN
    INSERT INTO odeme_bilgiler
    VALUES (id, rid, ot, tut, otar, pb, idur, itar);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_RezervasyonIptal (
    id VARCHAR(64)
)
BEGIN
    UPDATE rezervasyonlar
    SET durum = 'İptal Edildi'
    WHERE rezervasyon_id = id;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_OdemeIade (
    id VARCHAR(64),
    itar DATETIME
)
BEGIN
    UPDATE odeme_bilgiler
    SET 
        iade_durum = 'İade Edildi',
        iade_tarihi = itar
    WHERE odeme_id = id;
END $$
DELIMITER ; 