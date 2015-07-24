ALTER TABLE nfe_notas ADD ide_hSaiEnt TIME;
ALTER TABLE nfe_notas ADD ide_dhCont TIMESTAMP;
ALTER TABLE nfe_notas ADD ide_xJust VARCHAR(256);
ALTER TABLE nfe_notas ADD emit_CRT CHAR(1);
ALTER TABLE nfe_notas ADD dest_email VARCHAR(60);
ALTER TABLE nfe_notas ADD retirada_CPF varchar(11);
ALTER TABLE nfe_notas ADD entrega_CPF VARCHAR(11);

ALTER TABLE nfe_produtos ADD vOutro DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD indTot CHAR(1);
ALTER TABLE nfe_produtos ADD vBCSTRet DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD vICMSSTRet DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ISSQN_cSitTrib char(1); 