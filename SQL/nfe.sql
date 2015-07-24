CREATE TABLE nfe_lotes (
    IdLote bigint not null AUTO_INCREMENT,
    dataEnvio date,
    recibo bigint,
    primary key(IdLote)
);

CREATE TABLE nfe_notas (
	Id varchar(44) not null primary key,
	versao varchar(4) not null,

	ide_cUF int(2) not null, #codigo UF
	ide_cNF int(9) not null, #Número aleatório
	ide_natOp varchar(60) not null, # Naturaza Operação
	ide_indPag enum('0', '1', '2') not null, #Forma de pagamento - 0:� vista, 1:a prazo, 2:outros
	ide_mod char(2) not null default '55', #sempre 55
	ide_serie int(3) not null, #s�rie nf - 0 para �nica
	ide_nNF int(9) not null, #n�mero nf
	ide_dEmi date not null, #data emiss�o
	ide_dSaiEnt date, #data entrada/sa�da
	ide_tpNF enum('0', '1') not null, #0-Entrada, 1-Sa�da
	ide_cMunFG int(7) not null, #código ibge município
	ide_refNFe varchar(44), #Nfe referente
	ide_tpImp enum('1', '2') not null, #formato impress�o danfe 1-retrato,2-paisagem
	ide_tpEmis enum('1', '2', '3', '4', '5') not null default '1', #1 � Normal � emiss�o normal; 2 � Conting�ncia FS � emiss�o em conting�ncia com impress�o do DANFE em Formul�rio de Seguran�a; 3 � Conting�ncia SCAN � emiss�o em conting�ncia no Sistema de Conting�ncia do Ambiente Nacional � SCAN; 4 � Conting�ncia DPEC  emiss�o em conting�ncia com envio da Declara��o Pr�via de Emiss�o em Conting�ncia � DPEC; 5 � Conting�ncia FSDA  emiss�o em conting�ncia com impress�o do DANFE em Formul�rio de Seguran�a para Impress�o de Documento Auxiliar de Documento Fiscal Eletr�nico (FSDA).
	ide_cDV int(1) not null,
	ide_tpAmb enum('1', '2') not null, #ambiente 1-Produ��o/ 2-Homologa��o
	ide_finNFe enum('1', '2', '3') not null default '1', #finalidade 1 - NF-e normal/ 2- NF-e complementar / 3 � NF-e de ajuste
	ide_procEmi enum('0', '1', '2', '3') not null default '0', #Identificador do processo de emiss�o da NFe: 0  emiss�o de NFe com aplicativo do contribuinte; 1  emiss�o de NFe avulsa pelo Fisco; 2  emiss�o de NFe avulsa, pelo contribuinte com seu certificado digital, atrav�s do site do Fisco; 3 emiss�o NFe pelo contribuinte com aplicativo fornecido pelo Fisco.
	ide_verProc varchar(20) not null, #vers�o do programa emissor

	emit_CNPJ varchar(14) not null, #cnpj ou cpf emitente
	emit_xNome varchar(60) not null, #razão social
	emit_xFant varchar(60), #nome fantasia
	enderEmit_xLgr varchar(60) not null, #endere�o
	enderEmit_nro varchar(60) not null, #n�mero
	enderEmit_xCpl varchar(60), #complemento
	enderEmit_xBairro varchar(60) not null,
	enderEmit_cMun int(7) not null, #Nº IBGE município
	enderEmit_xMun varchar(60) not null, #nome município
	enderEmit_UF char(2) not null,
	enderEmit_CEP varchar(8),
	enderEmit_cPais int(4),
	enderEmit_xPais varchar(60),
	enderEmit_fone bigint,
	emit_IE varchar(14) not null, #inscrição estadual
	emit_IEST varchar(14), #inscri��o estadual ST
	emit_IM varchar(15), #incri��o municipal
	emit_CNAE varchar(7),

	dest_CNPJ varchar(14) not null, #cnpj ou cpf destinat�rio
	dest_xNome varchar(60) not null, #raz�o social
	enderDest_xLgr varchar(60) not null, #endere�o
	enderDest_nro varchar(60) not null, #n�mero
	enderDest_xCpl varchar(60), #complemento
	enderDest_xBairro varchar(60) not null,

	enderDest_cMun int(7) not null, #N� IBGE munic�pio
	enderDest_xMun varchar(60) not null, #nome munic�pio
	enderDest_UF char(2) not null,
	enderDest_CEP varchar(8),
	enderDest_cPais int(4),
	enderDest_xPais varchar(60),
	enderDest_fone bigint,
	dest_IE varchar(14) not null, #inscri��o estadual
	dest_ISUF varchar(9),

	retirada_CNPJ varchar(14),
	retirada_xLgr varchar(60),
	retirada_nro varchar(60),
	retirada_xCpl varchar(60),
	retirada_xBairro varchar(60),
	retirada_cMun int(7),
	retirada_xMun varchar(60),
	retirada_UF char(2),

	entrega_CNPJ varchar(14),
	entrega_xLgr varchar(60),
	entrega_nro varchar(60),
	entrega_xCpl varchar(60),
	entrega_xBairro varchar(60),
	entrega_cMun int(7),
	entrega_xMun varchar(60),
	entrega_UF char(2),

	total_vBC decimal(15,2),
	total_vICMS  decimal(15,2),
	total_vBCST decimal(15,2),
	total_vST decimal(15,2),
	total_vProd decimal(15,2),
	total_vFrete decimal(15,2),
	total_vSeg decimal(15,2),
	total_vDesc decimal(15,2),
	total_vII decimal(15,2),
	total_vIPI decimal(15,2),
	total_vPIS decimal(15,2),
	total_vCOFINS decimal(15,2),
	total_vOutro decimal(15,2),
	total_vNF decimal(15,2),

	transp_modFrete enum('0', '1') not null, #modalidade do frete
	transp_CNPJ varchar(14), #CNPJ ou CPF transportadora
	transp_xNome varchar(60),
	transp_IE varchar(14),
	transp_xEnder varchar(60),
	transp_xMun varchar(60),
	transp_UF char(2),
	transp_veicTransp_Placa varchar(8),
	transp_veicTransp_UF char(2),
	transp_qVol int(15), #quantidade de volumes
	transp_esp varchar(60), #espécie de volumes
	transp_marca varchar(60),
	transp_nVol varchar(60), #numeração dos volumes
	transp_pesoL decimal(15,3),
	transp_pesoB decimal(13,3),

	cobr_fat_nFat varchar(60), #número da fatura
	cobr_fat_vOrig decimal(15,2), #valor original de fatura
	cobr_fat_vDesc decimal(15,2), #valor do desconto
	cobr_fat_vLiq decimal(15,2), #valor líquido

	infAdic_infAdFisco varchar(256), #informações para o fisco
	infAdic_infCpl longtext,

        status char(1),
        cod_ret char(3),
        msg_erro longtext,
        xml longtext,
        IdLote bigint,
        recibo bigint,
        nProt bigint,
        digVal varchar(50),
        xJust varchar(255),
        dhRecbto varchar(20) DEFAULT NULL,
        verAplic varchar(20) DEFAULT NULL,
);

CREATE TABLE nfe_produtos (
    Id varchar(44) not null,
    nItem int(11) not null, #ordem do produto
    cProd varchar(60) not null, #código do produto
    cEAN varchar(14) not null, #código de barras
    xProd varchar(120) not null, #descrição do produto
    NCM varchar(8), #código NCM
    EXTIPI char(3), #codigo EX da TIPI
    genero char(2), #código do genêro de acordo com a NCM
    CFOP char(4) not null,
    uCom varchar(6) not null, #unidade comercial
    qCom decimal(12,4), #quantidade comercial
    vUnCom decimal(16,4), #valor unitário
    vProd decimal(15,2), #valor bruto do produto
    cEANTrib varchar(14), #codigo de barras
    uTrib varchar(6) not null, #unidade
    qTrib decimal(12,4), #quantidade a ser tributada
    vUnTrib decimal(16,4), #valor a ser tributada
    vFrete decimal(15,2),
    vSeg decimal(15,2), #seguro
    vDesc  decimal(15,2), #desconto
    #ICMS
    orig enum('0', '1', '2') not null default '0', #origem 0-nacional, 1-estrangeira-importação direta, 2-estrangeira-adquirida no mercado interno
    CST char(2) not null, #código de tributação do ICMS
    modBC enum('0', '1', '2', '3') not null default '3', #modalidade para determinação da base de cálculo do ICMS 0-Margem de valor agregado, 1-Pauta, 2-Preço tabelado Máx., 3-Valor da Operação
    pRedBC decimal(5,2), #percentual de redução da báse de cálculo
    vBC decimal(15,2), #base de calculo do ICMS
    pICMS decimal(5,2), #aliquota do ICMS
    vICMS decimal(15,2), #valor do ICMS
    #ST
    modBCST enum('', '0', '1', '2', '3', '4', '5'), #modalidade para determinação da base de cálculo do ICMS Substituição Tributária, 0-Preco tabelado ou maximo sugerido, 1-Lista Negativa, 2-Lista positiva, 3-Lista neutra, 4-Margem de valor agregado, 5-Pauta
    pMVAST decimal(5,2), #percentual da margem de valor adicionado ao ICMS ST
    pRedBCST decimal(5,2), #percentual da redução de base de calculo do ICMS ST
    vBCST decimal(15,2), #base de calculo do icms substituicao tributaria
    pICMSST decimal(5,2), #aliquota do ICMS ST
    vICMSST decimal(15,2), #valor do icms st
    #IPI
    IPI_clEnq char(5), #classe para enquadramento
    IPI_CNPJProd varchar(14), #CNPJ do produtor da mercadoria, quando diferente do emitente
    IPI_cSelo varchar(60), #código do selo do controle do IPI
    IPI_qSelo int(12), #quantidade de selo de controle
    IPI_cEnq char(3), #codigo de enquadramento legal do IPI
    IPI_CST char(2), #codigo situacao tribuataria do IPI
    IPI_vBC decimal(15,2), #base de calculo
    IPI_qUnid decimal(16,4), #quantidade tributada
    IPI_vUnid decimal(15,4), #valor tributável
    IPI_pIPI decimal(5,2), #aliquota do IPI
    IPI_vIPI decimal(15,2),
    #PIS
    PIS_CST char(2), #codigo de situação tribuatária do PIS
    PIS_vBC decimal(15,2), #valor da base de calculo do PIS
    PIS_pPIS decimal(5,2), #aliquota ICMS
    PIS_vPIS decimal(15,2), #valor do PIS
    PIS_qBCProd decimal(16,4), #quantidade vendida
    PIS_vAliqProd decimal(15,4), #aliquota do PIS em valor
    #PIS ST
    PISST_vBC decimal(15,2), #base calculo PIS ST
    PISST_pPIS decimal(5,2),
    PISST_qBCProd decimal(16,4),
    PISST_vAliqProd decimal(15,4),
    PISST_vPIS decimal(15,2),
    #COFINS
    COFINS_CST char(2),
    COFINS_vBC  decimal(15,2),
    COFINS_pCOFINS  decimal(5,2),
    COFINS_vCOFINS  decimal(15,2),
    COFINS_qBCProd  decimal(16,4),
    COFINS_vAliqProd  decimal(15,4),
    #COFINS ST
    COFINSST_vBC decimal(15,2),
    COFINSST_pCOFINS decimal(5,2),
    COFINSST_vCOFINS decimal(15,2),
    COFINSST_qBCProd decimal(16,4),
    COFINSST_vAliqProd decimal(15,4),

    infAdProd varchar(500),
    primary key(Id, nItem)
);

create table nfe_duplicatas (
    Id varchar(44) not null,
    cobr_dup_nDup varchar(60),
    cobr_dup_dVenc date,
    cobr_dup_vDup decimal(15,2),
    primary key(Id, cobr_dup_nDup)
);
