/*///////////////////////////////////////////////*/
/*///////////////////////////////////////////////*/
/*///////////////////////////////////////////////*/
CREATE TABLE produit (
    Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    reference VARCHAR(50),
    couleur VARCHAR(50),
    quantite INT,
    colisage INT DEFAULT 12,
    marque VARCHAR(25) DEFAULT "ATELIER TROPEZIEN",
    numProd INT,
    CodeEAN VARCHAR(13),
    addrsImage VARCHAR(255) DEFAULT "TAMPON-AT.png",
    addrsScancode VARCHAR(255)
)
CREATE TABLE List (scan_code int(13))
INSERT INTO produit VALUES (
    0,
    'zero',
    'zero',
    0,
    0,
    'MARQUE'
    1000,
    000000000000,
    'TAMPON-AT.png',
    NULL
)
/*///////////////////////////////////////////////*/
/*///////////////////////////////////////////////*/
/*///////////////////////////////////////////////*/