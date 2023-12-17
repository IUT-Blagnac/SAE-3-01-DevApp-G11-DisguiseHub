CREATE PROCEDURE PasserCommande(
    IN p_idClient INT,
    IN p_refProduit INT,
    IN p_qteCommandee INT,
    IN p_idPaiement INT,
    IN p_adrLivraison TEXT,
    IN p_codePostalLivraison DECIMAL(5),
    IN p_fraisLivraison DECIMAL(6,2)
)
BEGIN
    DECLARE v_qteProduit DECIMAL(4);

    SELECT qteProduit INTO v_qteProduit
    FROM Produit
    WHERE refProduit = p_refProduit;

    IF v_qteProduit IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le produit spécifié n''existe pas.';
    ELSE
        IF p_qteCommandee <= 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La quantité commandée doit être supérieure à 0.';
        ELSE
            IF p_qteCommandee > v_qteProduit THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La quantité commandée ne peut pas être supérieure à la quantité en stock.';
            ELSE
                INSERT INTO Commande (idClient, idPaiement, dateCommande, fraisLivraison, adrLivraison, codePostalLivraison, statutCommande)
                VALUES (p_idClient, p_idPaiement, NOW(), p_fraisLivraison, p_adrLivraison, p_codePostalLivraison, 'En cours de préparation');

                SET @lastCommandeId = LAST_INSERT_ID();

                INSERT INTO Commander (refProduit, idCommande, qteCommandee)
                VALUES (p_refProduit, @lastCommandeId, p_qteCommandee);

            END IF;
        END IF;
    END IF;
END;
//


CREATE PROCEDURE MettreAJourPrixProduit(
    IN p_refProduit INT,
    IN p_nouveauPrix DECIMAL(6,2)
)
BEGIN
    DECLARE v_qteProduit DECIMAL(4);

    SELECT qteProduit INTO v_qteProduit
    FROM Produit
    WHERE refProduit = p_refProduit;

    IF v_qteProduit IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le produit spécifié n''existe pas.';
    ELSE
        IF p_nouveauPrix <= 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le nouveau prix doit être supérieur à 0.';
        ELSE
            UPDATE Produit
            SET prixProduit = p_nouveauPrix
            WHERE refProduit = p_refProduit;
        END IF;
    END IF;
END;
//

CREATE PROCEDURE AjouterProduitsSoldes(
    IN p_reduc DECIMAL(5,2) -- Exemple : 0,20 pour 20%
)
BEGIN
    UPDATE Produit
    SET prixProduit = prixProduit * (1 - p_reduc), -- Avec l'exemple, le prix sera réduit de 20% (prixProduit * (1 - 0,20 = 0,80))
        idCategorie = 1
    WHERE idCategorie <> 1; 
END //
