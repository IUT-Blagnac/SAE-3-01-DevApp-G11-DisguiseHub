DELIMITER //
CREATE PROCEDURE PasserCommande 
  (
    p_idClient Client.nomClient%TYPE,
    p_idPaiement Paiement.idPaiement%TYPE,
    p_dateCommande Commande.dateCommande%TYPE,
    p_fraisLivraison Commande.fraisLivraison%TYPE,
    p_adrLivraison Commande.adrLivraison%TYPE,
    p_codePostalLivraison Commande.codePostalLivraison%TYPE,
    p_statutCommande Commande.statutCommande%TYPE,
    p_refProduit Produit.refProduit%TYPE,
  )
IS 
    v_refProduit Produit.refProduit%TYPE;
    v_idCommande Commande.idCommande%TYPE;
    v_qteCommandee DECIMAL;
    flag DECIMAL;
BEGIN
    SELECT refProduit INTO v_refProduit FROM Produit WHERE refProduit = p_refProduit;
    SELECT idCommande INTO v_idCommande FROM Commande WHERE idClient = p_idClient;
    SELECT qteCommandee INTO v_qteCommandee FROM Commander WHERE refProduit = p_refProduit AND idCommande = v_idCommande;
    IF v_refProduit IS NULL THEN
        flag := 1;
    ELSEIF v_idCommande IS NULL THEN
        flag := 2;
    ELSEIF v_qteCommandee IS NULL THEN
        flag := 3;
    ELSE
        flag := 0;
    END IF;
    CASE flag
        WHEN 1 THEN
            INSERT INTO Produit (refProduit) VALUES (p_refProduit);
        WHEN 2 THEN
            INSERT INTO Commande (idClient, idPaiement, dateCommande, fraisLivraison, adrLivraison, codePostalLivraison, statutCommande) VALUES (p_idClient, p_idPaiement, p_dateCommande, p_fraisLivraison, p_adrLivraison, p_codePostalLivraison, p_statutCommande);
        WHEN 3 THEN
            INSERT INTO Commander (refProduit, idCommande, qteCommandee) VALUES (p_refProduit, p_idCommande, 1);
        ELSE
            UPDATE Commander SET qteCommandee = qteCommandee + 1 WHERE refProduit = p_refProduit AND idCommande = p_idCommande;
    END CASE;

   

  
END //
DELIMITER ;