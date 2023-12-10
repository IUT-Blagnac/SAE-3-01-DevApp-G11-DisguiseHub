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
  (2, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'S', 'rouge et blanc'),
  (2, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'M', 'rouge et blanc'),
  (2, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'L', 'rouge et blanc'),
  (2, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XL', 'rouge et blanc'),
  (2, 'Pere Noël' , 'Déguisement du pere noël', 50.99, 50, 'XXL', 'rouge et blanc'),
  



