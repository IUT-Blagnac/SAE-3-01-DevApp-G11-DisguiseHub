-- Insérer des dates
-- STR_TO_DATE('24-May-2005', '%d-%M-%Y')


-- INSERTION DES CATEGORIES
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


-- INSERTION DES Clients
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO Client (numCB, nomClient, prenomClient, adresseClient, mailClient, codePostalClient, villeClient, civiliteClient, dateNaissanceClient, telClient, mdpClient)
VALUES
  ('1111222233334444', 'Dupont', 'Alice', '1 Rue des Fleurs', 'alice.dupont@email.com', '75001', 'Paris', 'Mme', '1990-01-01', '0123456789', 'motdepasse1'),
  ('2222333344445555', 'Martin', 'Bob', '2 Rue des Champs', 'bob.martin@email.com', '69002', 'Lyon', 'M.', '1985-02-15', '0234567890', 'motdepasse2'),
  ('3333444455556666', 'Lefevre', 'Claire', '3 Rue des Étoiles', 'claire.lefevre@email.com', '13003', 'Marseille', 'Mme', '1988-03-20', '0345678901', 'motdepasse3'),
  ('4444555566667777', 'Robert', 'David', '4 Rue des Montagnes', 'david.robert@email.com', '31004', 'Toulouse', 'M.', '1992-04-10', '0456789012', 'motdepasse4'),
  ('5555666677778888', 'Leroux', 'Emilie', '5 Rue des Plages', 'emilie.leroux@email.com', '44005', 'Nantes', 'Mme', '1987-05-25', '0567890123', 'motdepasse5'),
  ('6666777788889999', 'Durand', 'François', '6 Rue des Bois', 'francois.durand@email.com', '67006', 'Strasbourg', 'M.', '1991-06-30', '0678901234', 'motdepasse6'),
  ('7777888899990000', 'Moreau', 'Géraldine', '7 Rue des Vignes', 'geraldine.moreau@email.com', '75007', 'Paris', 'Mme', '1984-07-15', '0789012345', 'motdepasse7'),
  ('8888999900001111', 'Girard', 'Hugo', '8 Rue des Rivières', 'hugo.girard@email.com', '69008', 'Lyon', 'M.', '1993-08-05', '0890123456', 'motdepasse8'),
  ('9999000011112222', 'Leclerc', 'Isabelle', '9 Rue des Châteaux', 'isabelle.leclerc@email.com', '13009', 'Marseille', 'Mme', '1989-09-10', '0901234567', 'motdepasse9'),
  ('0000111122223333', 'Roux', 'Jean', '10 Rue des Monts', 'jean.roux@email.com', '31010', 'Toulouse', 'M.', '1986-10-20', '0012345678', 'motdepasse10'),
  ('1111222233334444', 'Fernandez', 'Laura', '11 Rue des Lacs', 'laura.fernandez@email.com', '44011', 'Nantes', 'Mme', '1994-11-28', '0123456789', 'motdepasse11'),
  ('2222333344445555', 'Meyer', 'Nicolas', '12 Rue des Collines', 'nicolas.meyer@email.com', '67012', 'Strasbourg', 'M.', '1983-12-05', '0234567890', 'motdepasse12'),
  (null, 'Blanc', 'Olivier', '13 Rue des Forêts', 'olivier.blanc@email.com', '13013', 'Marseille', 'M.', '1982-01-18', '0345678901', 'motdepasse13'),
  (null, 'Lemoine', 'Pauline', '14 Rue des Océans', 'pauline.lemoine@email.com', '31014', 'Toulouse', 'Mme', '1990-02-22', '0456789012', 'motdepasse14'),
  (null, 'Perez', 'Quentin', '15 Rue des Plaines', 'quentin.perez@email.com', '44015', 'Nantes', 'M.', '1987-03-15', '0567890123', 'motdepasse15'),
  (null, 'Roger', 'Sophie', '16 Rue des Îles', 'sophie.roger@email.com', '67016', 'Strasbourg', 'Mme', '1991-04-27', '0678901234', 'motdepasse16'),
  (null, 'Lafontaine', 'Théo', '17 Rue des Arbres', 'theo.lafontaine@email.com', '75017', 'Paris', 'M.', '1986-05-10', '0789012345', 'motdepasse17'),
  (null, 'Noël', 'Ursule', '18 Rue des Grottes', 'ursule.noel@email.com', '69018', 'Lyon', 'Mme', '1992-06-14', '0890123456', 'motdepasse18'),
  (null, 'Vidal', 'Valentin', '19 Rue des Rochers', 'valentin.vidal@email.com', '13019', 'Marseille', 'M.', '1985-07-29', '0901234567', 'motdepasse19'),
  (null, 'Bernard', 'Wendy', '20 Rue des Vagues', 'wendy.bernard@email.com', '31020', 'Toulouse', 'Mme', '1993-08-03', '0012345678', 'motdepasse20'),
  (null, 'Caron', 'Xavier', '21 Rue des Vallées', 'xavier.caron@email.com', '44021', 'Nantes', 'M.', '1988-09-18', '0123456789', 'motdepasse21'),
  (null, 'Dufour', 'Yasmine', '22 Rue des Volcans', 'yasmine.dufour@email.com', '67022', 'Strasbourg', 'Mme', '1994-10-23', '0234567890', 'motdepasse22'),
  (null, 'Gonzalez', 'Zacharie', '23 Rue des Vents', 'zacharie.gonzalez@email.com', '13023', 'Marseille', 'M.', '1983-11-17', '0345678901', 'motdepasse23'),
  (null, 'Henry', 'Alice', '24 Rue des Arbustes', 'alice.henry@email.com', '31024', 'Toulouse', 'Mme', '1991-12-22', '0456789012', 'motdepasse24'),
  (null, 'Ibrahim', 'Baptiste', '25 Rue des Montagnes', 'baptiste.ibrahim@email.com', '44025', 'Nantes', 'M.', '1984-01-13', '0567890123', 'motdepasse25'),
  (null, 'Joubert', 'Catherine', '26 Rue des Rivières', 'catherine.joubert@email.com', '67026', 'Strasbourg', 'Mme', '1990-02-27', '0678901234', 'motdepasse26'),
  (null, 'Klein', 'Damien', '27 Rue des Châteaux', 'damien.klein@email.com', '75027', 'Paris', 'M.', '1986-03-31', '0789012345', 'motdepasse27'),
  (null, 'Lamy', 'Emeline', '28 Rue des Collines', 'emeline.lamy@email.com', '69028', 'Lyon', 'Mme', '1992-04-05', '0890123456', 'motdepasse28'),
  (null, 'Mathieu', 'Fabien', '29 Rue des Forêts', 'fabien.mathieu@email.com', '13029', 'Marseille', 'M.', '1985-05-19', '0901234567', 'motdepasse29'),
  (null, 'Naud', 'Gabrielle', '30 Rue des Îles', 'gabrielle.naud@email.com', '31030', 'Toulouse', 'Mme', '1993-06-24', '0012345678', 'motdepasse30'),
  (null, 'Olivier', 'Henri', '31 Rue des Lacs', 'henri.olivier@email.com', '44031', 'Nantes', 'M.', '1988-07-28', '0123456789', 'motdepasse31'),
  (null, 'Perrin', 'Isaure', '32 Rue des Plages', 'isaure.perrin@email.com', '67032', 'Strasbourg', 'Mme', '1994-08-02', '0234567890', 'motdepasse32'),
  (null, 'Quentin', 'Jérôme', '33 Rue des Rochers', 'jerome.quentin@email.com', '13033', 'Marseille', 'M.', '1983-11-17', '0345678901', 'motdepasse33'),
  (null, 'Riviere', 'Karine', '34 Rue des Îles', 'karine.riviere@email.com', '31034', 'Toulouse', 'Mme', '1991-12-22', '0456789012', 'motdepasse34'),
  (null, 'Sauvage', 'Luc', '35 Rue des Vallées', 'luc.sauvage@email.com', '44035', 'Nantes', 'M.', '1984-01-13', '0567890123', 'motdepasse35'),
  (null, 'Tardif', 'Morgane', '36 Rue des Montagnes', 'morgane.tardif@email.com', '67036', 'Strasbourg', 'Mme', '1990-02-27', '0678901234', 'motdepasse36'),
  (null, 'Urbain', 'Nicolas', '37 Rue des Rivières', 'nicolas.urbain@email.com', '75037', 'Paris', 'M.', '1986-03-31', '0789012345', 'motdepasse37'),
  (null, 'Leroy', 'Olivier', '38 Rue des Arbustes', 'olivier.leroy@email.com', '13038', 'Marseille', 'M.', '1982-04-13', '0345678901', 'motdepasse38'),
  (null, 'Marchand', 'Pauline', '39 Rue des Océans', 'pauline.marchand@email.com', '31039', 'Toulouse', 'Mme', '1990-05-22', '0456789012', 'motdepasse39'),
  (null, 'Dupuis', 'Quentin', '40 Rue des Plaines', 'quentin.dupuis@email.com', '44040', 'Nantes', 'M.', '1987-06-15', '0567890123', 'motdepasse40'),
  (null, 'Clement', 'Sophie', '41 Rue des Îles', 'sophie.clement@email.com', '67041', 'Strasbourg', 'Mme', '1991-07-27', '0678901234', 'motdepasse41'),
  (null, 'Lemoine', 'Théo', '42 Rue des Vallées', 'theo.lemoine@email.com', '75042', 'Paris', 'M.', '1986-08-10', '0789012345', 'motdepasse42'),
  (null, 'Meyer', 'Ursule', '43 Rue des Grottes', 'ursule.meyer@email.com', '69043', 'Lyon', 'Mme', '1992-09-14', '0890123456', 'motdepasse43'),
  (null, 'Roux', 'Valentin', '44 Rue des Rochers', 'valentin.roux@email.com', '13044', 'Marseille', 'M.', '1985-10-29', '0901234567', 'motdepasse44'),
  (null, 'Fernandez', 'Wendy', '45 Rue des Vagues', 'wendy.fernandez@email.com', '31045', 'Toulouse', 'Mme', '1993-11-03', '0012345678', 'motdepasse45'),
  (null, 'Muller', 'Xavier', '46 Rue des Vallées', 'xavier.muller@email.com', '44046', 'Nantes', 'M.', '1988-12-18', '0123456789', 'motdepasse46'),
  (null, 'Lefevre', 'Yasmine', '47 Rue des Volcans', 'yasmine.lefevre@email.com', '67047', 'Strasbourg', 'Mme', '1994-01-23', '0234567890', 'motdepasse47'),
  (null, 'Robert', 'Zacharie', '48 Rue des Vents', 'zacharie.robert@email.com', '75048', 'Paris', 'M.', '1983-02-17', '0345678901', 'motdepasse48'),
  (null, 'Durand', 'Alice', '49 Rue des Arbustes', 'alice.durand@email.com', '69049', 'Lyon', 'Mme', '1991-03-24', '0456789012', 'motdepasse49'),
  (null, 'Leroux', 'Baptiste', '50 Rue des Montagnes', 'baptiste.leroux@email.com', '13050', 'Marseille', 'M.', '1984-04-09', '0567890123', 'motdepasse50'),
  (null, 'Moreau', 'Catherine', '51 Rue des Forêts', 'catherine.moreau@email.com', '31051', 'Toulouse', 'Mme', '1990-05-14', '0678901234', 'motdepasse51'),
  (null, 'Girard', 'Damien', '52 Rue des Îles', 'damien.girard@email.com', '44052', 'Nantes', 'M.', '1985-06-29', '0789012345', 'motdepasse52'),
  (null, 'Leclerc', 'Emeline', '53 Rue des Lacs', 'emeline.leclerc@email.com', '67053', 'Strasbourg', 'Mme', '1991-07-04', '0890123456', 'motdepasse53'),
  (null, 'Dupuis', 'Fabien', '54 Rue des Collines', 'fabien.dupuis@email.com', '13054', 'Marseille', 'M.', '1983-08-19', '0901234567', 'motdepasse54'),
  (null, 'Clement', 'Gabrielle', '55 Rue des Forêts', 'gabrielle.clement@email.com', '31055', 'Toulouse', 'Mme', '1993-09-23', '0012345678', 'motdepasse55'),
  (null, 'Morel', 'Henri', '56 Rue des Îles', 'henri.morel@email.com', '44056', 'Nantes', 'M.', '1988-10-08', '0123456789', 'motdepasse56'),
  (null, 'Andre', 'Isaure', '57 Rue des Plages', 'isaure.andre@email.com', '67057', 'Strasbourg', 'Mme', '1994-11-13', '0234567890', 'motdepasse57'),
  (null, 'Muller', 'Jérôme', '58 Rue des Rochers', 'jerome.muller@email.com', '75058', 'Paris', 'M.', '1983-12-28', '0345678901', 'motdepasse58'),
  (null, 'Fournier', 'Karine', '59 Rue des Vallées', 'karine.fournier@email.com', '69059', 'Lyon', 'Mme', '1992-01-02', '0456789012', 'motdepasse59'),
  (null, 'Girard', 'Luc', '60 Rue des Volcans', 'luc.girard@email.com', '13060', 'Marseille', 'M.', '1985-02-16', '0567890123', 'motdepasse60');
SET FOREIGN_KEY_CHECKS = 1;
