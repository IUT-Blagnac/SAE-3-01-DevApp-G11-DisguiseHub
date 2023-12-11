-- Insertion des catégories
INSERT INTO Categorie (nomCategorie) VALUES ('PROMOTIONS');
INSERT INTO Categorie (nomCategorie) VALUES ('DEGUISEMENTS ADULTES');
INSERT INTO Categorie (nomCategorie) VALUES ('DEGUISEMENTS ENFANTS');
INSERT INTO Categorie (nomCategorie) VALUES ('DEGUISEMENTS COUPLES');
INSERT INTO Categorie (nomCategorie) VALUES ('ACCESSOIRES');
INSERT INTO Categorie (nomCategorie) VALUES ('DECORATIONS');
INSERT INTO Categorie (nomCategorie) VALUES ('THEMES');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (2, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (2, 'PERSONNAGES');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (2, 'PIRATES');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (3, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (3, 'PERSONNAGES');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (3, 'PRINCESSES');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (4, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (4, 'PERSONNAGES');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (4, 'NOUVEL AN');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (5, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (5, 'NOUVEL AN');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (5, 'PERSONNAGES');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (6, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (6, 'NOUVEL AN');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (6, 'PIRATES');

INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (7, 'NOEL');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (7, 'NOUVEL AN');
INSERT INTO Categorie (idCategoriePere, nomCategorie) VALUES (7, 'PERSONNAGES');

-- Insertion des CB
INSERT INTO Cartebleue (numCB, nomSurCB, dateExpCB, codeSecuriteCB) VALUES 
  ('1111222233334444', 'Dupont Alice', '12/24', '123'),
  ('2222333344445555', 'Martin Bob', '05/23', '456'),
  ('3333444455556666', 'Lefevre Claire', '09/25', '789'),
  ('4444555566667777', 'Robert David', '03/26', '012'),
  ('5555666677778888', 'Leroux Emilie', '08/22', '345'),
  ('6666777788889999', 'Durand François', '11/23', '678'),
  ('7777888899990000', 'Moreau Géraldine', '07/25', '901'),
  ('8888999900001111', 'Girard Hugo', '10/24', '234'),
  ('9999000011112222', 'Leclerc Isabelle', '04/27', '567'),
  ('0000111122223333', 'Roux Jean', '06/26', '890');

-- Insertion des clients
INSERT INTO Client (numCB, nomClient, prenomClient, adresseClient, mailClient, codePostalClient, villeClient, genreClient, dateNaissanceClient, telClient, mdpClient, isAdmin) VALUES 
  ('1111222233334444', 'Dupont', 'Alice', '1 rue de la Paix', 'alice.dupont@email.com', 75000, 'Paris', 'Femme', STR_TO_DATE('24-May-2005', '%d-%M-%Y'), '0123456780', 'motdepasse1', false),
  ('2222333344445555', 'Martin', 'Bob', '2 Rue des Champs', 'bob.martin@email.com', 69002, 'Lyon', 'Homme', STR_TO_DATE('15-Feb-1985', '%d-%b-%Y'), '0234567891', 'motdepasse2', false),
  ('3333444455556666', 'Lefevre', 'Claire', '3 Rue des Étoiles', 'claire.lefevre@email.com', 13003, 'Marseille', 'Femme', STR_TO_DATE('20-Mar-1988', '%d-%b-%Y'), '0345678900', 'motdepasse3', false),
  ('4444555566667777', 'Robert', 'David', '4 Rue des Montagnes', 'david.robert@email.com', 31004, 'Toulouse', 'Homme', STR_TO_DATE('10-Apr-1992', '%d-%b-%Y'), '0456789010', 'motdepasse4', false),
  ('5555666677778888', 'Leroux', 'Emilie', '5 Rue des Plages', 'emilie.leroux@email.com', 44005, 'Nantes', 'Femme', STR_TO_DATE('25-May-1987', '%d-%b-%Y'), '0567890120', 'motdepasse5', false),
  ('6666777788889999', 'Durand', 'François', '6 Rue des Bois', 'francois.durand@email.com', 67006, 'Strasbourg', 'Homme', STR_TO_DATE('30-Jun-1991', '%d-%b-%Y'), '0678901230', 'motdepasse6', false),
  ('7777888899990000', 'Moreau', 'Géraldine', '7 Rue des Vignes', 'geraldine.moreau@email.com', 75007, 'Paris', 'Femme', STR_TO_DATE('15-Jul-1984', '%d-%b-%Y'), '0789012340', 'motdepasse7', false),
  ('8888999900001111', 'Girard', 'Hugo', '8 Rue des Rivières', 'hugo.girard@email.com', 69008, 'Lyon', 'Homme', STR_TO_DATE('05-Aug-1993', '%d-%b-%Y'), '089012345-', 'motdepasse8', false),
  ('9999000011112222', 'Leclerc', 'Isabelle', '9 Rue des Châteaux', 'isabelle.leclerc@email.com', 13009, 'Marseille', 'Femme', STR_TO_DATE('10-Sep-1989', '%d-%b-%Y'), '0901234567', 'motdepasse9', false),
  ('0000111122223333', 'Roux', 'Jean', '10 Rue des Monts', 'jean.roux@email.com', 31010, 'Toulouse', 'Homme', STR_TO_DATE('20-Oct-1986', '%d-%b-%Y'), '0012345670', 'motdepasse10', false),
  (null, 'Nichele', 'Angelo', '11 Rue des Monts', 'angelo.nichele@email.com', 31700, 'Cornebarrieu', 'Homme', STR_TO_DATE('29-Apr-2004', '%d-%b-%Y'), '0785431000', 'motdepasse11', false),
  (null, 'Doe', 'John', '11 Rue des Fleurs', 'john.doe@email.com', 44011, 'Nantes', 'Homme', STR_TO_DATE('05-Nov-1990', '%d-%b-%Y'), '0123456781', 'motdepasse12', false),
  (null, 'Smith', 'Emma', '12 Rue des Arbres', 'emma.smith@email.com', 69012, 'Lyon', 'Femme', STR_TO_DATE('10-Dec-1995', '%d-%b-%Y'), '0234567892', 'motdepasse13', false),
  (null, 'Garcia', 'Antonio', '13 Rue des Écoles', 'antonio.garcia@email.com', 13013, 'Marseille', 'Homme', STR_TO_DATE('15-Jan-1983', '%d-%b-%Y'), '0345678901', 'motdepasse14', false),
  (null, 'Johnson', 'Olivia', '14 Rue des Montagnes', 'olivia.johnson@email.com', 31014, 'Toulouse', 'Femme', STR_TO_DATE('20-Feb-1987', '%d-%b-%Y'), '0456789011', 'motdepasse15', false),
  (null, 'Williams', 'Sophia', '15 Rue des Plages', 'sophia.williams@email.com', 44015, 'Nantes', 'Femme', STR_TO_DATE('25-Mar-1992', '%d-%b-%Y'), '0567890121', 'motdepasse16', false),
  (null, 'Brown', 'Liam', '16 Rue des Bois', 'liam.brown@email.com', 67016, 'Strasbourg', 'Homme', STR_TO_DATE('30-Apr-1988', '%d-%b-%Y'), '0678901231', 'motdepasse17', false),
  (null, 'Jones', 'Ava', '17 Rue des Vignes', 'ava.jones@email.com', 75017, 'Paris', 'Femme', STR_TO_DATE('15-May-1995', '%d-%b-%Y'), '0789012341', 'motdepasse18', false),
  (null, 'Miller', 'Noah', '18 Rue des Rivières', 'noah.miller@email.com', 69018, 'Lyon', 'Homme', STR_TO_DATE('05-Jun-1989', '%d-%b-%Y'), '0890123451', 'motdepasse19', false),
  (null, 'Davis', 'Mia', '19 Rue des Châteaux', 'mia.davis@email.com', 13019, 'Marseille', 'Femme', STR_TO_DATE('10-Jul-1986', '%d-%b-%Y'), '0901234561', 'motdepasse20', false),
  (null, 'Wilson', 'James', '20 Rue des Monts', 'james.wilson@email.com', 31020, 'Toulouse', 'Homme', STR_TO_DATE('20-Aug-1993', '%d-%b-%Y'), '0012345671', 'motdepasse21', false),
  (null, 'Taylor', 'Charlotte', '21 Rue des Fleurs', 'charlotte.taylor@email.com', 44021, 'Nantes', 'Femme', STR_TO_DATE('05-Sep-1984', '%d-%b-%Y'), '0123456782', 'motdepasse22', false),
  (null, 'Anderson', 'Benjamin', '22 Rue des Arbres', 'benjamin.anderson@email.com', 69022, 'Lyon', 'Homme', STR_TO_DATE('10-Oct-1991', '%d-%b-%Y'), '0234567893', 'motdepasse23', false),
  (null, 'Thomas', 'Harper', '23 Rue des Écoles', 'harper.thomas@email.com', 13023, 'Marseille', 'Homme', STR_TO_DATE('15-Nov-1983', '%d-%b-%Y'), '0345678902', 'motdepasse24', false),
  (null, 'Adams', 'Sophi', '24 Rue des Montagnes', 'sophi.adams@email.com', 31024, 'Toulouse', 'Femme', STR_TO_DATE('20-Dec-1990', '%d-%b-%Y'), '0456789013', 'motdepasse25', false),
  (null, 'Baker', 'Alexander', '25 Rue des Plages', 'alexander.baker@email.com', 44025, 'Nantes', 'Homme', STR_TO_DATE('25-Jan-1985', '%d-%b-%Y'), '0567890122', 'motdepasse26', false),
  (null, 'Nouvel', 'Sophie', '26 Rue des Fleurs', 'sophie.nouvel@email.com', 69026, 'Lyon', 'Femme', STR_TO_DATE('05-Feb-1992', '%d-%b-%Y'), '0123456783', 'motdepasse27', false),
  (null, 'Gauthier', 'Jacque', '27 Rue des Arbres', 'jacque.gauthier@email.com', 13027, 'Marseille', 'Homme', STR_TO_DATE('10-Mar-1987', '%d-%b-%Y'), '0234567894', 'motdepasse28', false),
  (null, 'Lemoine', 'Léa', '28 Rue des Écoles', 'léa.lemoine@email.com', 31028, 'Toulouse', 'Femme', STR_TO_DATE('15-Apr-1994', '%d-%b-%Y'), '0345678903', 'motdepasse29', false),
  (null, 'Rousseau', 'Bastien', '29 Rue des Montagnes', 'bastien.rousseau@email.com', 44029, 'Nantes', 'Homme', STR_TO_DATE('20-May-1989', '%d-%b-%Y'), '0456789014', 'motdepasse30', false),
  (null, 'Marchand', 'Léa', '30 Rue des Plages', 'lea.marchand@email.com', 67030, 'Strasbourg', 'Femme', STR_TO_DATE('25-Jun-1996', '%d-%b-%Y'), '0567890123', 'motdepasse31', false),
  (null, 'Lefort', 'Lucas', '31 Rue des Bois', 'lucas.lefort@email.com', 75031, 'Paris', 'Homme', STR_TO_DATE('30-Jul-1991', '%d-%b-%Y'), '0678901233', 'motdepasse32', false),
  (null, 'Simon', 'Chloé', '32 Rue des Vignes', 'chloe.simon@email.com', 69032, 'Lyon', 'Femme', STR_TO_DATE('15-Aug-1986', '%d-%b-%Y'), '0789012342', 'motdepasse33', false),
  (null, 'Lefebvre', 'Arthur', '33 Rue des Rivières', 'arthur.lefebvre@email.com', 13033, 'Marseille', 'Homme', STR_TO_DATE('05-Sep-1993', '%d-%b-%Y'), '0890123452', 'motdepasse34', false),
  (null, 'Mercier', 'Laura', '34 Rue des Châteaux', 'laura.mercier@email.com', 31034, 'Toulouse', 'Femme', STR_TO_DATE('10-Oct-1988', '%d-%b-%Y'), '0901234562', 'motdepasse35', false),
  (null, 'Dupuis', 'Théo', '35 Rue des Monts', 'theo.dupuis@email.com', 44035, 'Nantes', 'Homme', STR_TO_DATE('20-Nov-1995', '%d-%b-%Y'), '0012345672', 'motdepasse36', false),
  (null, 'Morin', 'Julie', '36 Rue des Fleurs', 'julie.morin@email.com', 69036, 'Lyon', 'Femme', STR_TO_DATE('05-Dec-1990', '%d-%b-%Y'), '0123456784', 'motdepasse37', false),
  (null, 'Giraud', 'Luc', '37 Rue des Arbres', 'luc.giraud@email.com', 13037, 'Marseille', 'Homme', STR_TO_DATE('10-Jan-1987', '%d-%b-%Y'), '0234567895', 'motdepasse38', false),
  (null, 'Robin', 'Emma', '38 Rue des Écoles', 'emma.robin@email.com', 31038, 'Toulouse', 'Femme', STR_TO_DATE('15-Feb-1994', '%d-%b-%Y'), '0345678904', 'motdepasse39', false),
  (null, 'Chevalier', 'Hugo', '39 Rue des Montagnes', 'hugo.chevalier@email.com', 44039, 'Nantes', 'Homme', STR_TO_DATE('20-Mar-1989', '%d-%b-%Y'), '0456789015', 'motdepasse40', false),
  (null, 'Lefevre', 'Léa', '40 Rue des Plages', 'lea.lefevre@email.com', 67040, 'Strasbourg', 'Femme', STR_TO_DATE('25-Apr-1996', '%d-%b-%Y'), '0567890124', 'motdepasse41', false),
  (null, 'Renaud', 'Lucas', '41 Rue des Bois', 'lucas.renaud@email.com', 75041, 'Paris', 'Homme', STR_TO_DATE('30-May-1991', '%d-%b-%Y'), '0678901234', 'motdepasse42', false),
  (null, 'Gauthier', 'Chloé', '42 Rue des Vignes', 'chloe.gauthier@email.com', 69042, 'Lyon', 'Femme', STR_TO_DATE('15-Jun-1986', '%d-%b-%Y'), '0789012344', 'motdepasse43', false),
  (null, 'Lemoine', 'Arthur', '43 Rue des Rivières', 'arthur.lemoine@email.com', 13043, 'Marseille', 'Homme', STR_TO_DATE('05-Jul-1993', '%d-%b-%Y'), '0890123453', 'motdepasse44', false),
  (null, 'Mercier', 'Jade', '44 Rue des Châteaux', 'jade.mercier@email.com', 31044, 'Toulouse', 'Femme', STR_TO_DATE('10-Aug-1988', '%d-%b-%Y'), '0901234563', 'motdepasse45', false),
  (null, 'Dupuis', 'Téo', '45 Rue des Monts', 'teo.dupuis@email.com', 44045, 'Nantes', 'Homme', STR_TO_DATE('20-Sep-1995', '%d-%b-%Y'), '0012345673', 'motdepasse46', false),
  (null, 'Lefort', 'Léa', '46 Rue des Fleurs', 'lea.lefort@email.com', 69046, 'Lyon', 'Femme', STR_TO_DATE('05-Oct-1992', '%d-%b-%Y'), '0123456786', 'motdepasse47', false),
  (null, 'Simon', 'Thomas', '47 Rue des Arbres', 'thomas.simon@email.com', 13047, 'Marseille', 'Homme', STR_TO_DATE('10-Nov-1987', '%d-%b-%Y'), '0234567896', 'motdepasse48', false),
  (null, 'Lefebvre', 'Emma', '48 Rue des Écoles', 'emma.lefebvre@email.com', 31048, 'Toulouse', 'Femme', STR_TO_DATE('15-Dec-1994', '%d-%b-%Y'), '0345678905', 'motdepasse49', false),
  (null, 'Mercier', 'Hugo', '49 Rue des Montagnes', 'hugo.mercier@email.com', 44049, 'Nantes', 'Homme', STR_TO_DATE('20-Jan-1989', '%d-%b-%Y'), '0456789016', 'motdepasse50', false);

-- Insertion des produits
INSERT INTO Produit (idCategorie, nomProduit, descProduit, prixProduit, qteProduit, tailleProduit, couleurProduit) VALUES 
  (8, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'S', 'rouge et blanc'),
  (8, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'M', 'rouge et blanc'),
  (8, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'L', 'rouge et blanc'),
  (8, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XL', 'rouge et blanc'),
  (8, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XXL', 'rouge et blanc'),
  (9, 'Superman', 'Déguisement de Superman', 45.99, 100, 'S', 'rouge et bleu'),
  (9, 'Superman', 'Déguisement de Superman', 45.99, 100, 'M', 'rouge et bleu'), 
  (9, 'Superman', 'Déguisement de Superman', 45.99, 100, 'L', 'rouge et bleu'),
  (9, 'Superman', 'Déguisement de Superman', 45.99, 100, 'XL', 'rouge et bleu'),
  (9, 'Superman', 'Déguisement de Superman', 45.99, 100, 'XXL', 'rouge et bleu'),
  (10, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'S', 'marron'),
  (10, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'M', 'marron'),
  (10, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'L', 'marron'),
  (10, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'XL', 'marron'),
  (10, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'XXL', 'marron'),
  (11, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'XS', 'rouge et blanc'),
  (11, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'S', 'rouge et blanc'),
  (11, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'M', 'rouge et blanc'),
  (11, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'L', 'rouge et blanc'),
  (12, 'Batman', 'Déguisement de Batman', 35.99, 100, 'XS', 'noir'),
  (12, 'Batman', 'Déguisement de Batman', 35.99, 100, 'S', 'noir'),
  (12, 'Batman', 'Déguisement de Batman', 35.99, 100, 'M', 'noir'),
  (12, 'Batman', 'Déguisement de Batman', 35.99, 100, 'L', 'noir'),
  (13, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'XS', 'bleu et blanc'),
  (13, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'S', 'bleu et blanc'),
  (13, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'M', 'bleu et blanc'),
  (13, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'L', 'bleu et blanc'),
  (14, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'S', 'rouge et blanc'),
  (14, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'M', 'rouge et blanc'),
  (14, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'L', 'rouge et blanc'),
  (14, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'XL', 'rouge et blanc'),
  (14, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'XXL', 'rouge et blanc'),
  (15, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'S', 'noir et rouge'),
  (15, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'M', 'noir et rouge'),
  (15, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'L', 'noir et rouge'),
  (15, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'XL', 'noir et rouge'),
  (15, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'XXL', 'noir et rouge'),
  (16, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'S', 'noir et blanc et coloré'),
  (16, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'M', 'noir et blanc et coloré'),
  (16, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'L', 'noir et blanc et coloré'),
  (16, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'XL', 'noir et blanc et coloré'),
  (16, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'XXL', 'noir et blanc et coloré'),
  (17, 'Chapeau du Pere Noël', 'Accessoire du pere noël', 12.99, 150, null, 'rouge et blanc'),
  (18, 'Cravate chic et classe', 'Cravate pour le nouvel an', 20.99, 200, null, 'noir'),
  (19, 'Cape de Superman', 'Accessoire pour le costume de Superman', 15.99, 100, null, 'rouge'),
  (20, 'Girlande de Noël', 'Décoration de noël', 5.99, 250, null, 'doré'),
  (21, 'Nappe chic pour table', 'Nappe de table ronde pour le nouvel an', 25.99, 70, null, 'noir'),
  (22, 'Baril Explosif de Pirates', 'Décoration pour pirates', 54.99, 20, null, 'bois'),
  (23, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'S', 'rouge et blanc'),
  (23, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'M', 'rouge et blanc'),
  (23, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'L', 'rouge et blanc'),
  (23, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XL', 'rouge et blanc'),
  (23, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XXL', 'rouge et blanc'),
  (23, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'XS', 'rouge et blanc'),
  (23, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'S', 'rouge et blanc'),
  (23, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'M', 'rouge et blanc'),
  (23, 'Mère Noël', 'Déguisement de la mère noël', 40.99, 50, 'L', 'rouge et blanc'),
  (23, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'S', 'rouge et blanc'),
  (23, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'M', 'rouge et blanc'),
  (23, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'L', 'rouge et blanc'),
  (23, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'XL', 'rouge et blanc'),
  (23, 'Pere et Mere Noël', 'Déguisement du pere et de la mere noël', 75.99, 100, 'XXL', 'rouge et blanc'),
  (23, 'Chapeau du Pere Noël', 'Accessoire du pere noël', 12.99, 150, null, 'rouge et blanc'),
  (23, 'Girlande de Noël', 'Décoration de noël', 5.99, 250, null, 'doré'),
  (24, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'S', 'noir et blanc et coloré'),
  (24, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'M', 'noir et blanc et coloré'),
  (24, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'L', 'noir et blanc et coloré'),
  (24, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'XL', 'noir et blanc et coloré'),
  (24, 'Classe et Festif', 'Déguisement festif pour le nouvel an', 79.99, 100, 'XXL', 'noir et blanc et coloré'),
  (24, 'Cravate chic et classe', 'Cravate pour le nouvel an', 20.99, 200, null, 'noir'),
  (24, 'Nappe chic pour table', 'Nappe de table ronde pour le nouvel an', 25.99, 70, null, 'noir'),
  (25, 'Superman', 'Déguisement de Superman', 45.99, 100, 'S', 'rouge et bleu'),
  (25, 'Superman', 'Déguisement de Superman', 45.99, 100, 'M', 'rouge et bleu'), 
  (25, 'Superman', 'Déguisement de Superman', 45.99, 100, 'L', 'rouge et bleu'),
  (25, 'Superman', 'Déguisement de Superman', 45.99, 100, 'XL', 'rouge et bleu'),
  (25, 'Superman', 'Déguisement de Superman', 45.99, 100, 'XXL', 'rouge et bleu'),
  (25, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'S', 'marron'),
  (25, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'M', 'marron'),
  (25, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'L', 'marron'),
  (25, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'XL', 'marron'),
  (25, 'Jack Sparow', 'Déguisment de Jack Sparow', 43.99, 75, 'XXL', 'marron'),
  (25, 'Batman', 'Déguisement de Batman', 35.99, 100, 'XS', 'noir'),
  (25, 'Batman', 'Déguisement de Batman', 35.99, 100, 'S', 'noir'),
  (25, 'Batman', 'Déguisement de Batman', 35.99, 100, 'M', 'noir'),
  (25, 'Batman', 'Déguisement de Batman', 35.99, 100, 'L', 'noir'),
  (25, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'XS', 'bleu et blanc'),
  (25, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'S', 'bleu et blanc'),
  (25, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'M', 'bleu et blanc'),
  (25, 'Reine des neiges', 'Déguisement de la reine des neiges', 42.99, 200, 'L', 'bleu et blanc'),
  (25, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'S', 'noir et rouge'),
  (25, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'M', 'noir et rouge'),
  (25, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'L', 'noir et rouge'),
  (25, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'XL', 'noir et rouge'),
  (25, 'Batman et WonderWoman', 'Déguisement de Batman et de WonderWoman', 80.99, 75, 'XXL', 'noir et rouge'),
  (25, 'Cape de Superman', 'Accessoire pour le costume de Superman', 15.99, 100, null, 'rouge');

-- Insertion des images
INSERT INTO Image VALUES 
  (100000, 'https://picsum.photos/360/360?image=0'),
  (100001, 'https://picsum.photos/360/360?image=1'),
  (100002, 'https://picsum.photos/360/360?image=2'),
  (100003, 'https://picsum.photos/360/360?image=3'),
  (100004, 'https://picsum.photos/360/360?image=4'),
  (100005, 'https://picsum.photos/360/360?image=5'),
  (100006, 'https://picsum.photos/360/360?image=6'),
  (100007, 'https://picsum.photos/360/360?image=7'),
  (100008, 'https://picsum.photos/360/360?image=8'),
  (100009, 'https://picsum.photos/360/360?image=9'),
  (100010, 'https://picsum.photos/360/360?image=10'),
  (100011, 'https://picsum.photos/360/360?image=11'),
  (100012, 'https://picsum.photos/360/360?image=12'),
  (100013, 'https://picsum.photos/360/360?image=13'),
  (100014, 'https://picsum.photos/360/360?image=14'),
  (100015, 'https://picsum.photos/360/360?image=15'),
  (100016, 'https://picsum.photos/360/360?image=16'),
  (100017, 'https://picsum.photos/360/360?image=17'),
  (100018, 'https://picsum.photos/360/360?image=18'),
  (100019, 'https://picsum.photos/360/360?image=19'),
  (100020, 'https://picsum.photos/360/360?image=20'),
  (100021, 'https://picsum.photos/360/360?image=21'),
  (100022, 'https://picsum.photos/360/360?image=22'),
  (100023, 'https://picsum.photos/360/360?image=23'),
  (100024, 'https://picsum.photos/360/360?image=24'),
  (100025, 'https://picsum.photos/360/360?image=25'),
  (100026, 'https://picsum.photos/360/360?image=26'),
  (100027, 'https://picsum.photos/360/360?image=27'),
  (100028, 'https://picsum.photos/360/360?image=28'),
  (100029, 'https://picsum.photos/360/360?image=29'),
  (100030, 'https://picsum.photos/360/360?image=30'),
  (100031, 'https://picsum.photos/360/360?image=31'),
  (100032, 'https://picsum.photos/360/360?image=32'),
  (100033, 'https://picsum.photos/360/360?image=33'),
  (100034, 'https://picsum.photos/360/360?image=34'),
  (100035, 'https://picsum.photos/360/360?image=35'),
  (100036, 'https://picsum.photos/360/360?image=36'),
  (100037, 'https://picsum.photos/360/360?image=37'),
  (100038, 'https://picsum.photos/360/360?image=38'),
  (100039, 'https://picsum.photos/360/360?image=39'),
  (100040, 'https://picsum.photos/360/360?image=40'),
  (100041, 'https://picsum.photos/360/360?image=41'),
  (100042, 'https://picsum.photos/360/360?image=42'),
  (100043, 'https://picsum.photos/360/360?image=43'),
  (100044, 'https://picsum.photos/360/360?image=44'),
  (100045, 'https://picsum.photos/360/360?image=45'),
  (100046, 'https://picsum.photos/360/360?image=46'),
  (100047, 'https://picsum.photos/360/360?image=47'),
  (100048, 'https://picsum.photos/360/360?image=48'),
  (100049, 'https://picsum.photos/360/360?image=49'),
  (100050, 'https://picsum.photos/360/360?image=50'),
  (100051, 'https://picsum.photos/360/360?image=51'),
  (100052, 'https://picsum.photos/360/360?image=52'),
  (100053, 'https://picsum.photos/360/360?image=53'),
  (100054, 'https://picsum.photos/360/360?image=54'),
  (100055, 'https://picsum.photos/360/360?image=55'),
  (100056, 'https://picsum.photos/360/360?image=56'),
  (100057, 'https://picsum.photos/360/360?image=57'),
  (100058, 'https://picsum.photos/360/360?image=58'),
  (100059, 'https://picsum.photos/360/360?image=59'),
  (100060, 'https://picsum.photos/360/360?image=60'),
  (100061, 'https://picsum.photos/360/360?image=61'),
  (100062, 'https://picsum.photos/360/360?image=62'),
  (100063, 'https://picsum.photos/360/360?image=63'),
  (100064, 'https://picsum.photos/360/360?image=64'),
  (100065, 'https://picsum.photos/360/360?image=65'),
  (100066, 'https://picsum.photos/360/360?image=66'),
  (100067, 'https://picsum.photos/360/360?image=67'),
  (100068, 'https://picsum.photos/360/360?image=68'),
  (100069, 'https://picsum.photos/360/360?image=69'),
  (100070, 'https://picsum.photos/360/360?image=70'),
  (100071, 'https://picsum.photos/360/360?image=71'),
  (100072, 'https://picsum.photos/360/360?image=72'),
  (100073, 'https://picsum.photos/360/360?image=73'),
  (100074, 'https://picsum.photos/360/360?image=74'),
  (100075, 'https://picsum.photos/360/360?image=75'),
  (100076, 'https://picsum.photos/360/360?image=76'),
  (100077, 'https://picsum.photos/360/360?image=77'),
  (100078, 'https://picsum.photos/360/360?image=78'),
  (100079, 'https://picsum.photos/360/360?image=79'),
  (100080, 'https://picsum.photos/360/360?image=80'),
  (100081, 'https://picsum.photos/360/360?image=81'),
  (100082, 'https://picsum.photos/360/360?image=82'),
  (100083, 'https://picsum.photos/360/360?image=83'),
  (100084, 'https://picsum.photos/360/360?image=84'),
  (100085, 'https://picsum.photos/360/360?image=85'),
  (100086, 'https://picsum.photos/360/360?image=86'),
  (100087, 'https://picsum.photos/360/360?image=87'),
  (100088, 'https://picsum.photos/360/360?image=88'),
  (100089, 'https://picsum.photos/360/360?image=89'),
  (100090, 'https://picsum.photos/360/360?image=90'),
  (100091, 'https://picsum.photos/360/360?image=91'),
  (100092, 'https://picsum.photos/360/360?image=92'),
  (100093, 'https://picsum.photos/360/360?image=93'),
  (100094, 'https://picsum.photos/360/360?image=94');

-- Insertion des produits apparentés
INSERT INTO ProduitApparente VALUES
  (100000, 100016),
  (100001, 100017),
  (100002, 100018),
  (100005, 100020),
  (100006, 100021),
  (100007, 100022),
  (100010, 100047),
  (100011, 100047),
  (100012, 100047),
  (100013, 100047),
  (100014, 100047),
  (100023, 100015),
  (100024, 100016),
  (100025, 100017),
  (100026, 100018),
  (100032, 100020),
  (100033, 100021),
  (100034, 100022),
  (100027, 100000),
  (100028, 100001),
  (100029, 100002),
  (100030, 100003),
  (100031, 100004),
  (100037, 100043),
  (100038, 100043),
  (100039, 100043),
  (100040, 100043),
  (100041, 100043);

-- Insertion des produits composés
INSERT INTO ProduitCompose VALUES
  (100027, 'Ce produit est composé d''un déguisement du pere noël et d''un de la mere noël en taille S'),
  (100028, 'Ce produit est composé d''un déguisement du pere noël et d''un de la mere noël en taille M'),
  (100029, 'Ce produit est composé d''un déguisement du pere noël et d''un de la mere noël en taille L'),
  (100030, 'Ce produit est composé d''un déguisement du pere noël et d''un de la mere noël en taille XL'),
  (100031, 'Ce produit est composé d''un déguisement du pere noël et d''un de la mere noël en taille XXL'),
  (100032, 'Ce produit est composé d''un déguisement de Batman et d''un de WonderWoman en taille S'),
  (100033, 'Ce produit est composé d''un déguisement de Batman et d''un de WonderWoman en taille M'),
  (100034, 'Ce produit est composé d''un déguisement de Batman et d''un de WonderWoman en taille L'),
  (100035, 'Ce produit est composé d''un déguisement de Batman et d''un de WonderWoman en taille XL'),
  (100036, 'Ce produit est composé d''un déguisement de Batman et d''un de WonderWoman en taille XXL'),
  (100037, 'Ce produit est composé d''un déguisement festif homme et un pour femme en taille S'),
  (100038, 'Ce produit est composé d''un déguisement festif homme et un pour femme en taille M'),
  (100039, 'Ce produit est composé d''un déguisement festif homme et un pour femme en taille L'),
  (100040, 'Ce produit est composé d''un déguisement festif homme et un pour femme en taille XL'),
  (100041, 'Ce produit est composé d''un déguisement festif homme et un pour femme en taille XXL');

-- Insertion des Paiements
INSERT INTO Paiement (numCB) VALUES
  ('1111222233334444'),
  ('2222333344445555'),
  ('3333444455556666'),
  ('4444555566667777'),
  ('5555666677778888'),
  ('6666777788889999'),
  ('7777888899990000'),
  ('8888999900001111'),
  ('9999000011112222'),
  ('0000111122223333');


-- Insertion des commandes
INSERT INTO Commande (idClient, idPaiement, dateCommande, fraisLivraison, adrLivraison, codePostalLivraison, statutCommande) VALUES
  (1, 1, STR_TO_DATE('01-Jan-2019', '%d-%b-%Y'), 5.99, '1 Rue des Fleurs', 13001, 'En cours de préparation'),
  (4, 1, STR_TO_DATE('21-Jan-2023', '%d-%b-%Y'), 7.99, '10 Rue des Fleurs', 31000, 'En cours de livraison'),
  (34, 1, STR_TO_DATE('29-Apr-2023', '%d-%b-%Y'), 2.99, '23 Rue des Fleurs', 31700, 'Livree');

-- Insertion dans Commander
INSERT INTO Commander (refProduit, idCommande, qteCommandee) VALUES
 (100000, 1, 2),
 (100045, 2, 4),
 (100038, 3, 1);


 -- Insertion dans Avis
INSERT INTO Avis (refProduit, idClient, commentaire, note) VALUES
  (100000, 1, 'Produit impeccable', 5),
  (100021, 43, 'Troué !!', 1),
  (100035, 31, 'Très bon produit', 4),
  (100045, 4, 'Produit impeccable', 5),
  (100038, 34, 'Bon Produit', 3);

-- Insertion dans Avis (les réponses)
INSERT INTO Avis (idAvisPere, refProduit, idClient, commentaire, note) VALUES
  (1, 100000, 1, 'Merci pour votre retour', 5),
  (2, 100021, 43, 'Nous sommes désolé vous allez être rembouré', 1),
  (3, 100035, 31, 'Merci !', 4),
  (4, 100045, 4, 'Parfait merci ! Content pour vous', 5),
  (5, 100038, 34, 'Pouvez-vous en dire plus ?', 3);
