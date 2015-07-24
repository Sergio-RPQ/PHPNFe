CREATE TABLE nfe_di (
ordem INT(11) NOT NULL AUTO_INCREMENT,
Id VARCHAR(44) NOT NULL,
nItem INT(11) NOT NULL,
nDI VARCHAR(11),
dDI DATE,
xLocDesemb VARCHAR(60),
ufDesemb CHAR(2),
dDesemb DATE,
cExportador VARCHAR(60),
PRIMARY KEY(ordem));

CREATE TABLE nfe_di_adi (
ordem INT(11) NOT NULL AUTO_INCREMENT,
di_ordem INT(11),
Id VARCHAR(44),
nAdicao INT(3),
nSeqAdic INT(3),
cFabricante VARCHAR(60),
vDescDI DECIMAL(15,2),
xPed VARCHAR(15),
xItemPed INT(6),
PRIMARY KEY(ordem));
