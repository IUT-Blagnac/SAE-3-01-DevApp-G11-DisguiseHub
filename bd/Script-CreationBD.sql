DROP TABLE IF EXISTS CategTaille;
DROP TABLE IF EXISTS GuideTaille;
DROP TABLE IF EXISTS Avis;
DROP TABLE IF EXISTS Commander;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS ProduitCompose;
DROP TABLE IF EXISTS ProduitApparente;
DROP TABLE IF EXISTS Produit;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Paiement;
DROP TABLE IF EXISTS VirementBancaire;
DROP TABLE IF EXISTS Paypal;
DROP TABLE IF EXISTS Cartebleue;

CREATE TABLE Cartebleue (
    numCB CHAR(16),
    nomSurCB VARCHAR(30),
    dateExpCB DATE,
    codeSecuriteCB DECIMAL(3),
    PRIMARY KEY (numCB)
) Engine=InnoDB;

CREATE TABLE Paypal (
    idPaypal DECIMAL AUTO_INCREMENT,
    PRIMARY KEY (idPaypal)
) Engine=InnoDB;

CREATE TABLE VirementBancaire (
    idVirement DECIMAL AUTO_INCREMENT,
    PRIMARY KEY (idVirement)
) Engine=InnoDB;

CREATE TABLE Paiement (
    idPaiement DECIMAL AUTO_INCREMENT,
    numCB CHAR(16),
    idPaypal DECIMAL,
    idVirement DECIMAL,
    PRIMARY KEY (idPaiement),
    FOREIGN KEY (numCB) REFERENCES Cartebleue(numCB),
    FOREIGN KEY (idPaypal) REFERENCES Paypal(idPaypal),
    FOREIGN KEY (idVirement) REFERENCES VirementBancaire(idVirement)
) Engine=InnoDB;

CREATE TABLE Client (
    idClient INT PRIMARY KEY AUTO_INCREMENT,
    numCB CHAR(16),
    nomClient VARCHAR(30),
    prenomClient VARCHAR(30),
    adresseClient VARCHAR(30),
    mailClient VARCHAR(30),
    codePostalClient DECIMAL(5),
    villeClient VARCHAR(30),
    civiliteClient VARCHAR(30),
    dateNaissanceClient DATE,
    telClient CHAR(10),
    mdpClient VARCHAR(30),
    PRIMARY KEY (numClient),
    UNIQUE (mailClient),
    UNIQUE (telClient),
    FOREIGN KEY (numCB) REFERENCES Cartebleue(numCB)
) Engine=InnoDB;

INSERT INTO Client (numCB, nomClient, prenomClient, adresseClient, mailClient, codePostalClient, villeClient, civiliteClient, dateNaissanceClient, telClient, mdpClient) VALUES ('1234567891234567', 'DUPONT', 'Jean', '1 rue de la Paix', '    ', 75000, 'Paris', 'Monsieur', STR_TO_DATE('24-May-2005', '%d-%M-%Y'), '0123456789', '123456');
INSERT INTO Client (numCB, nomClient, prenomClient, adresseClient, mailClient, codePostalClient, villeClient, civiliteClient, dateNaissanceClient, telClient, mdpClient) VALUES ('1234567891234567', 'DUPONT', 'Jean', '1 rue de la Paix', '  ', 75000, 'Paris', 'Monsieur', STR_TO_DATE('24-May-2005', '%d-%M-%Y'), '0123456729', '123456');


CREATE TABLE Categorie (
    idCategorie DECIMAL AUTO_INCREMENT,
    idCategoriePere DECIMAL AUTO_INCREMENT,
    nomCategorie VARCHAR(30),
    PRIMARY KEY (idCategorie),
    FOREIGN KEY (idCategoriePere) REFERENCES Categorie(idCategorie)
) Engine=InnoDB;

CREATE TABLE Produit (
    refProduit VARCHAR(30),
    idCategorie DECIMAL AUTO_INCREMENT,
    nomProduit VARCHAR(50),
    descProduit VARCHAR(255),
    prixProduit DECIMAL(6,2),
    qteProduit DECIMAL,
    tailleProduit VARCHAR(3),
    couleurProduit VARCHAR(30),
    imageProduit VARCHAR(255),
    PRIMARY KEY (refProduit),
    FOREIGN KEY (idCategorie) REFERENCES Categorie(idCategorie)
) Engine=InnoDB;

CREATE TABLE ProduitApparente (
    refProduit1 INT,
    refProduit2 INT,
    PRIMARY KEY (refProduit1, refProduit2),
    FOREIGN KEY (refProduit1) REFERENCES Produit(refProduit),
    FOREIGN KEY (refProduit2) REFERENCES Produit(refProduit)
) Engine=InnoDB;

CREATE TABLE ProduitCompose (
    refProduitCompose INT PRIMARY KEY,
    composition TEXT,
    FOREIGN KEY (refProduitCompose) REFERENCES Produit(refProduit)
) Engine=InnoDB;

CREATE TABLE Commande (
    idCommande DECIMAL AUTO_INCREMENT,
    numClient DECIMAL AUTO_INCREMENT,
    idPaiement DECIMAL AUTO_INCREMENT,
    dateCommande DATE,
    fraisLivraison DECIMAL(6,2),
    adrLivraison VARCHAR(30),
    codePostalLivraison DECIMAL(5),
    statutCommande VARCHAR(50),
    PRIMARY KEY (idCommande),
    FOREIGN KEY (numClient) REFERENCES Client(numClient),
    FOREIGN KEY (idPaiement) REFERENCES Paiement(idPaiement)
) Engine=InnoDB;

CREATE TABLE Commander (
    refProduit VARCHAR(30),
    idCommande DECIMAL AUTO_INCREMENT,
    qteCommandee DECIMAL,
    PRIMARY KEY (refProduit, idCommande),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit),
    FOREIGN KEY (idCommande) REFERENCES Commande(idCommande)
) Engine=InnoDB;

CREATE TABLE Avis (
    idAvis DECIMAL,
    idAvisPere DECIMAL,
    refProduit VARCHAR(30),
    numClient DECIMAL,
    commentaire VARCHAR(255),
    note DECIMAL(1),
    PRIMARY KEY (idAvis),
    FOREIGN KEY (idAvisPere) REFERENCES Avis(idAvis),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit),
    FOREIGN KEY (numClient) REFERENCES Client(numClient)
) Engine=InnoDB;

CREATE TABLE GuideTaille (
    idTaille DECIMAL,
    tourPoitrine DECIMAL(6,2),
    tourTaille DECIMAL(6,2),
    tourBassin DECIMAL(6,2),
    tailleFR VARCHAR(3),
    tailleACommander VARCHAR(3),
    PRIMARY KEY (idTaille)
) Engine=InnoDB;

CREATE TABLE CategTaille (
    idTaille DECIMAL,
    refProduit VARCHAR(30),
    tailleSelonAgeEtSexe VARCHAR(3),
    PRIMARY KEY (idTaille, refProduit),
    FOREIGN KEY (idTaille) REFERENCES GuideTaille(idTaille),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit)
) Engine=InnoDB;


CREATE TRIGGER check_dateExpCB
BEFORE INSERT ON Cartebleue
FOR EACH ROW
BEGIN
    IF NEW.dateExpCB <> DATE_FORMAT(NEW.dateExpCB, '%d/%m/%Y') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date d''expiration de la carte bleue doit être au format DD/MM/YYYY.';
    END IF;
END;
//

CREATE TRIGGER check_dateNaissanceClient
BEFORE INSERT ON Client
FOR EACH ROW
BEGIN
    IF NEW.dateNaissanceClient <> DATE_FORMAT(NEW.dateNaissanceClient, '%d/%m/%Y') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date de naissance du client doit être au format DD/MM/YYYY.';
    END IF;
END;
//

CREATE TRIGGER check_tailleProduit
BEFORE INSERT ON Produit
FOR EACH ROW
BEGIN
    IF NEW.tailleProduit NOT IN ('XS', 'S', 'M', 'L', 'XL', 'XXL') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La taille du produit doit être XS, S, M, L, XL ou XXL.';
    END IF;
END;
//

CREATE TRIGGER check_dateCommande
BEFORE INSERT ON Commande
FOR EACH ROW
BEGIN
    IF NEW.dateCommande <> DATE_FORMAT(NEW.dateCommande, '%d/%m/%Y') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date de commande doit être au format DD/MM/YYYY.';
    END IF;
END;
//

CREATE TRIGGER check_note
BEFORE INSERT ON Avis
FOR EACH ROW
BEGIN
    IF NEW.note NOT BETWEEN 0 AND 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La note doit être comprise entre 0 et 5.';
    END IF;
END;
//

CREATE TRIGGER check_tailleFR_and_tailleACommander
BEFORE INSERT ON GuideTaille
FOR EACH ROW
BEGIN
    IF NEW.tailleFR NOT IN ('XS', 'S', 'M', 'L', 'XL', 'XXL') OR NEW.tailleACommander NOT IN ('XS', 'S', 'M', 'L', 'XL', 'XXL') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Les tailles FR et à commander doivent être XS, S, M, L, XL ou XXL.';
    END IF;
END;
//

CREATE TRIGGER check_tailleSelonAgeEtSexe
BEFORE INSERT ON CategTaille
FOR EACH ROW
BEGIN
    IF NEW.tailleSelonAgeEtSexe NOT IN ('XS', 'S', 'M', 'L', 'XL', 'XXL') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La taille selon l''âge et le sexe doit être XS, S, M, L, XL ou XXL.';
    END IF;
END;
//

ALTER TABLE Client 
MODIFY numClient AUTO_INCREMENT;

ALTER TABLE 