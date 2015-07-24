ALTER TABLE nfe_produtos ADD ISSQN_vBC decimal(15,2);
ALTER TABLE nfe_produtos ADD ISSQN_vAliq decimal(15,2);
ALTER TABLE nfe_produtos ADD ISSQN_vISSQN decimal(15,2);
ALTER TABLE nfe_produtos ADD ISSQN_cMunFG int(7);
ALTER TABLE nfe_produtos ADD ISSQN_cListServ char(4);

ALTER TABLE nfe_notas ADD total_ISSQN_vServ decimal(15,2);
ALTER TABLE nfe_notas ADD total_ISSQN_vBC decimal(15,2);  
ALTER TABLE nfe_notas ADD total_ISSQN_vISS decimal(15,2); 
ALTER TABLE nfe_notas ADD total_ISSQN_vPIS decimal(15,2); 
ALTER TABLE nfe_notas ADD total_ISSQN_vCOFINS decimal(15,2);