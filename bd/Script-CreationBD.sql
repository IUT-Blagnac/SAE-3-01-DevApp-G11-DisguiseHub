DROP TABLE IF EXISTS CategTaille;
DROP TABLE IF EXISTS GuideTaille;
DROP TABLE IF EXISTS Avis;
DROP TABLE IF EXISTS Commander;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS ProduitCompose;
DROP TABLE IF EXISTS ProduitApparente;
DROP TABLE IF EXISTS Image;
DROP TABLE IF EXISTS Produit;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Paiement;
DROP TABLE IF EXISTS VirementBancaire;
DROP TABLE IF EXISTS Paypal;
DROP TABLE IF EXISTS Cartebleue;

CREATE TABLE Cartebleue (
    numCB CHAR(16),
    nomSurCB VARCHAR(30) NOT NULL,
    dateExpCB VARCHAR(7) NOT NULL,
    codeSecuriteCB DECIMAL(4) NOT NULL,
    PRIMARY KEY (numCB)
) Engine=InnoDB;

CREATE TABLE Paypal (
    idPaypal INT AUTO_INCREMENT,
    UNIQUE (mailPaypal),
    PRIMARY KEY (idPaypal)
) Engine=InnoDB;

CREATE TABLE VirementBancaire (
    idVirement INT AUTO_INCREMENT,
    PRIMARY KEY (idVirement)
) Engine=InnoDB;

CREATE TABLE Paiement (
    idPaiement INT AUTO_INCREMENT,
    numCB CHAR(16),
    idPaypal INT,
    idVirement INT,
    PRIMARY KEY (idPaiement),
    FOREIGN KEY (numCB) REFERENCES Cartebleue(numCB),
    FOREIGN KEY (idPaypal) REFERENCES Paypal(idPaypal),
    FOREIGN KEY (idVirement) REFERENCES VirementBancaire(idVirement)
) Engine=InnoDB;

CREATE TABLE Client (
    idClient INT AUTO_INCREMENT,
    numCB CHAR(16),
    nomClient VARCHAR(30),
    prenomClient VARCHAR(30),
    adresseClient TEXT,
    mailClient VARCHAR(100) NOT NULL,
    codePostalClient DECIMAL(5),
    villeClient VARCHAR(50),
    civiliteClient VARCHAR(50),
    dateNaissanceClient DATE,
    telClient CHAR(10) NOT NULL,
    mdpClient VARCHAR(50),
    PRIMARY KEY (idClient),
    UNIQUE (mailClient),
    UNIQUE (telClient),
    FOREIGN KEY (numCB) REFERENCES Cartebleue(numCB)
) Engine=InnoDB;

CREATE TABLE Categorie (
    idCategorie INT AUTO_INCREMENT,
    idCategoriePere INT,
    nomCategorie VARCHAR(50),
    PRIMARY KEY (idCategorie),
    FOREIGN KEY (idCategoriePere) REFERENCES Categorie(idCategorie)
) Engine=InnoDB;

CREATE TABLE Produit (
    refProduit INT AUTO_INCREMENT,
    idCategorie INT,
    nomProduit VARCHAR(100),
    descProduit TEXT,
    prixProduit DECIMAL(6,2),
    qteProduit DECIMAL(4),
    tailleProduit VARCHAR(3),
    couleurProduit VARCHAR(40),
    PRIMARY KEY (refProduit),
    FOREIGN KEY (idCategorie) REFERENCES Categorie(idCategorie)
) Engine=InnoDB;

CREATE TABLE Image (
    refProduit INT,
    imageProduit VARCHAR(255),
    PRIMARY KEY (refProduit, imageProduit),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit)
) Engine=InnoDB;

CREATE TABLE ProduitApparente (
    refProduit1 INT,
    refProduit2 INT,
    PRIMARY KEY (refProduit1, refProduit2),
    FOREIGN KEY (refProduit1) REFERENCES Produit(refProduit),
    FOREIGN KEY (refProduit2) REFERENCES Produit(refProduit)
) Engine=InnoDB;

CREATE TABLE ProduitCompose (
    refProduitCompose INT,
    composition TEXT,
    PRIMARY KEY (refProduitCompose),
    FOREIGN KEY (refProduitCompose) REFERENCES Produit(refProduit)
) Engine=InnoDB;

CREATE TABLE Commande (
    idCommande INT AUTO_INCREMENT,
    idClient INT,
    idPaiement INT,
    dateCommande DATE NOT NULL,
    fraisLivraison DECIMAL(6,2),
    adrLivraison TEXT NOT NULL,
    codePostalLivraison DECIMAL(5),
    statutCommande VARCHAR(50),
    PRIMARY KEY (idCommande),
    FOREIGN KEY (idClient) REFERENCES Client(idClient),
    FOREIGN KEY (idPaiement) REFERENCES Paiement(idPaiement)
) Engine=InnoDB;

CREATE TABLE Commander (
    refProduit INT,
    idCommande INT,
    qteCommandee INT,
    PRIMARY KEY (refProduit, idCommande),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit),
    FOREIGN KEY (idCommande) REFERENCES Commande(idCommande)
) Engine=InnoDB;

CREATE TABLE Avis (
    idAvis INT AUTO_INCREMENT,
    idAvisPere INT,
    refProduit INT,
    idClient INT,
    commentaire TEXT,
    note DECIMAL(1) NOT NULL,
    PRIMARY KEY (idAvis),
    FOREIGN KEY (idAvisPere) REFERENCES Avis(idAvis),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit),
    FOREIGN KEY (idClient) REFERENCES Client(idClient)
) Engine=InnoDB;

CREATE TABLE GuideTaille (
    idTaille INT AUTO_INCREMENT,
    tourPoitrine DECIMAL(6,2),
    tourTaille DECIMAL(6,2),
    tourBassin DECIMAL(6,2),
    tailleFR VARCHAR(3),
    tailleACommander VARCHAR(3),
    PRIMARY KEY (idTaille)
) Engine=InnoDB;

CREATE TABLE CategTaille (
    idTaille INT,
    refProduit INT,
    tailleSelonAgeEtSexe VARCHAR(3),
    PRIMARY KEY (idTaille, refProduit),
    FOREIGN KEY (idTaille) REFERENCES GuideTaille(idTaille),
    FOREIGN KEY (refProduit) REFERENCES Produit(refProduit)
) Engine=InnoDB;

ALTER TABLE Produit AUTO_INCREMENT = 100000;
ALTER TABLE Avis AUTO_INCREMENT = 1;