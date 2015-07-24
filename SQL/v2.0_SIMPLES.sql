ALTER TABLE nfe_produtos CHANGE CST CST CHAR(2);
ALTER TABLE nfe_produtos CHANGE orig orig ENUM('0', '1', '2');
ALTER TABLE nfe_produtos CHANGE modBC modBC ENUM('0', '1', '2', '3');
ALTER TABLE nfe_produtos ADD ICMSSN_orig ENUM('0', '1', '2');
ALTER TABLE nfe_produtos ADD ICMSSN_CSOSN CHAR(3);
ALTER TABLE nfe_produtos ADD ICMSSN_pCredSN DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vCredICMSSN DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_modBCST ENUM('0', '1', '2', '3', '4', '5');
ALTER TABLE nfe_produtos ADD ICMSSN_pMVAST DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_pRedBCST DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vBCST DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_pICMSST DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vICMSST DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vBCSTRet DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vICMSSTRet DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_modBC ENUM('0', '1', '2', '3');
ALTER TABLE nfe_produtos ADD ICMSSN_vBC DECIMAL(15,2);
ALTER TABLE nfe_produtos ADD ICMSSN_pRedBC DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_pICMS DECIMAL(5,2);
ALTER TABLE nfe_produtos ADD ICMSSN_vICMS DECIMAL(15,2);