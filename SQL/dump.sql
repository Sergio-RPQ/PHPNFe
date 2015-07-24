/*
SQLyog Community Edition- MySQL GUI v7.0 RC2
MySQL - 5.1.31-community : Database - nfe
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`nfe` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `nfe`;

/*Table structure for table `nfe_duplicatas` */

DROP TABLE IF EXISTS `nfe_duplicatas`;

CREATE TABLE `nfe_duplicatas` (
  `Id` varchar(44) NOT NULL,
  `cobr_dup_nDup` varchar(60) NOT NULL DEFAULT '',
  `cobr_dup_dVenc` date DEFAULT NULL,
  `cobr_dup_vDup` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`Id`,`cobr_dup_nDup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `nfe_lotes` */

DROP TABLE IF EXISTS `nfe_lotes`;

CREATE TABLE `nfe_lotes` (
  `IdLote` bigint(20) NOT NULL AUTO_INCREMENT,
  `dataEnvio` date DEFAULT NULL,
  `recibo` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`IdLote`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `nfe_notas` */

DROP TABLE IF EXISTS `nfe_notas`;

CREATE TABLE `nfe_notas` (
  `Id` varchar(44) NOT NULL,
  `versao` varchar(4) NOT NULL,
  `ide_cUF` int(2) NOT NULL,
  `ide_cNF` int(9) NOT NULL,
  `ide_natOp` varchar(60) NOT NULL,
  `ide_indPag` enum('0','1','2') NOT NULL,
  `ide_mod` char(2) NOT NULL DEFAULT '55',
  `ide_serie` int(3) NOT NULL,
  `ide_nNF` int(9) NOT NULL,
  `ide_dEmi` date NOT NULL,
  `ide_dSaiEnt` date DEFAULT NULL,
  `ide_tpNF` enum('0','1') NOT NULL,
  `ide_cMunFG` int(7) NOT NULL,
  `ide_refNFe` varchar(44) DEFAULT NULL,
  `ide_tpImp` enum('1','2') NOT NULL,
  `ide_tpEmis` enum('1','2','3','4','5') NOT NULL DEFAULT '1',
  `ide_cDV` int(1) NOT NULL,
  `ide_tpAmb` enum('1','2') NOT NULL,
  `ide_finNFe` enum('1','2','3') NOT NULL DEFAULT '1',
  `ide_procEmi` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `ide_verProc` varchar(20) NOT NULL,
  `emit_CNPJ` varchar(14) NOT NULL,
  `emit_xNome` varchar(60) NOT NULL,
  `emit_xFant` varchar(60) DEFAULT NULL,
  `enderEmit_xLgr` varchar(60) NOT NULL,
  `enderEmit_nro` varchar(60) NOT NULL,
  `enderEmit_xCpl` varchar(60) DEFAULT NULL,
  `enderEmit_xBairro` varchar(60) NOT NULL,
  `enderEmit_cMun` int(7) NOT NULL,
  `enderEmit_xMun` varchar(60) NOT NULL,
  `enderEmit_UF` char(2) NOT NULL,
  `enderEmit_CEP` varchar(8) DEFAULT NULL,
  `enderEmit_cPais` int(4) DEFAULT NULL,
  `enderEmit_xPais` varchar(60) DEFAULT NULL,
  `enderEmit_fone` bigint(20) DEFAULT NULL,
  `emit_IE` varchar(14) NOT NULL,
  `emit_IEST` varchar(14) DEFAULT NULL,
  `emit_IM` varchar(15) DEFAULT NULL,
  `emit_CNAE` varchar(7) DEFAULT NULL,
  `dest_CNPJ` varchar(14) NOT NULL,
  `dest_xNome` varchar(60) NOT NULL,
  `enderDest_xLgr` varchar(60) NOT NULL,
  `enderDest_nro` varchar(60) NOT NULL,
  `enderDest_xCpl` varchar(60) DEFAULT NULL,
  `enderDest_xBairro` varchar(60) NOT NULL,
  `enderDest_cMun` int(7) NOT NULL,
  `enderDest_xMun` varchar(60) NOT NULL,
  `enderDest_UF` char(2) NOT NULL,
  `enderDest_CEP` varchar(8) DEFAULT NULL,
  `enderDest_cPais` int(4) DEFAULT NULL,
  `enderDest_xPais` varchar(60) DEFAULT NULL,
  `enderDest_fone` bigint(20) DEFAULT NULL,
  `dest_IE` varchar(14) NOT NULL,
  `dest_ISUF` varchar(9) DEFAULT NULL,
  `retirada_CNPJ` varchar(14) DEFAULT NULL,
  `retirada_xLgr` varchar(60) DEFAULT NULL,
  `retirada_nro` varchar(60) DEFAULT NULL,
  `retirada_xCpl` varchar(60) DEFAULT NULL,
  `retirada_xBairro` varchar(60) DEFAULT NULL,
  `retirada_cMun` int(7) DEFAULT NULL,
  `retirada_xMun` varchar(60) DEFAULT NULL,
  `retirada_UF` char(2) DEFAULT NULL,
  `entrega_CNPJ` varchar(14) DEFAULT NULL,
  `entrega_xLgr` varchar(60) DEFAULT NULL,
  `entrega_nro` varchar(60) DEFAULT NULL,
  `entrega_xCpl` varchar(60) DEFAULT NULL,
  `entrega_xBairro` varchar(60) DEFAULT NULL,
  `entrega_cMun` int(7) DEFAULT NULL,
  `entrega_xMun` varchar(60) DEFAULT NULL,
  `entrega_UF` char(2) DEFAULT NULL,
  `total_vBC` decimal(15,2) DEFAULT NULL,
  `total_vICMS` decimal(15,2) DEFAULT NULL,
  `total_vBCST` decimal(15,2) DEFAULT NULL,
  `total_vST` decimal(15,2) DEFAULT NULL,
  `total_vProd` decimal(15,2) DEFAULT NULL,
  `total_vFrete` decimal(15,2) DEFAULT NULL,
  `total_vSeg` decimal(15,2) DEFAULT NULL,
  `total_vDesc` decimal(15,2) DEFAULT NULL,
  `total_vII` decimal(15,2) DEFAULT NULL,
  `total_vIPI` decimal(15,2) DEFAULT NULL,
  `total_vPIS` decimal(15,2) DEFAULT NULL,
  `total_vCOFINS` decimal(15,2) DEFAULT NULL,
  `total_vOutro` decimal(15,2) DEFAULT NULL,
  `total_vNF` decimal(15,2) DEFAULT NULL,
  `transp_modFrete` enum('0','1') NOT NULL,
  `transp_CNPJ` varchar(14) DEFAULT NULL,
  `transp_xNome` varchar(60) DEFAULT NULL,
  `transp_IE` varchar(14) DEFAULT NULL,
  `transp_xEnder` varchar(60) DEFAULT NULL,
  `transp_xMun` varchar(60) DEFAULT NULL,
  `transp_UF` char(2) DEFAULT NULL,
  `transp_veicTransp_Placa` varchar(8) DEFAULT NULL,
  `transp_veicTransp_UF` char(2) DEFAULT NULL,
  `transp_qVol` int(15) DEFAULT NULL,
  `transp_esp` varchar(60) DEFAULT NULL,
  `transp_marca` varchar(60) DEFAULT NULL,
  `transp_nVol` varchar(60) DEFAULT NULL,
  `transp_pesoL` decimal(15,3) DEFAULT NULL,
  `transp_pesoB` decimal(13,3) DEFAULT NULL,
  `cobr_fat_nFat` varchar(60) DEFAULT NULL,
  `cobr_fat_vOrig` decimal(15,2) DEFAULT NULL,
  `cobr_fat_vDesc` decimal(15,2) DEFAULT NULL,
  `cobr_fat_vLiq` decimal(15,2) DEFAULT NULL,
  `infAdic_infAdFisco` varchar(256) DEFAULT NULL,
  `infAdic_infCpl` longtext,
  `status` char(1) DEFAULT NULL,
  `cod_ret` char(3) DEFAULT NULL,
  `msg_erro` longtext,
  `xml` longtext,
  `IdLote` bigint(20) DEFAULT NULL,
  `recibo` bigint(20) DEFAULT NULL,
  `nProt` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `nfe_produtos` */

DROP TABLE IF EXISTS `nfe_produtos`;

CREATE TABLE `nfe_produtos` (
  `Id` varchar(44) NOT NULL,
  `nItem` int(11) NOT NULL,
  `cProd` varchar(60) NOT NULL,
  `cEAN` varchar(14) NOT NULL,
  `xProd` varchar(120) NOT NULL,
  `NCM` varchar(8) DEFAULT NULL,
  `EXTIPI` char(3) DEFAULT NULL,
  `genero` char(2) DEFAULT NULL,
  `CFOP` char(4) NOT NULL,
  `uCom` varchar(6) NOT NULL,
  `qCom` decimal(12,4) DEFAULT NULL,
  `vUnCom` decimal(16,4) DEFAULT NULL,
  `vProd` decimal(15,2) DEFAULT NULL,
  `cEANTrib` varchar(14) DEFAULT NULL,
  `uTrib` varchar(6) NOT NULL,
  `qTrib` decimal(12,4) DEFAULT NULL,
  `vUnTrib` decimal(16,4) DEFAULT NULL,
  `vFrete` decimal(15,2) DEFAULT NULL,
  `vSeg` decimal(15,2) DEFAULT NULL,
  `vDesc` decimal(15,2) DEFAULT NULL,
  `orig` enum('0','1','2') NOT NULL DEFAULT '0',
  `CST` char(2) NOT NULL,
  `modBC` enum('0','1','2','3') NOT NULL DEFAULT '3',
  `pRedBC` decimal(5,2) DEFAULT NULL,
  `vBC` decimal(15,2) DEFAULT NULL,
  `pICMS` decimal(5,2) DEFAULT NULL,
  `vICMS` decimal(15,2) DEFAULT NULL,
  `modBCST` enum('','0','1','2','3','4','5') DEFAULT NULL,
  `pMVAST` decimal(5,2) DEFAULT NULL,
  `pRedBCST` decimal(5,2) DEFAULT NULL,
  `vBCST` decimal(15,2) DEFAULT NULL,
  `pICMSST` decimal(5,2) DEFAULT NULL,
  `vICMSST` decimal(15,2) DEFAULT NULL,
  `IPI_clEnq` char(5) DEFAULT NULL,
  `IPI_CNPJProd` varchar(14) DEFAULT NULL,
  `IPI_cSelo` varchar(60) DEFAULT NULL,
  `IPI_qSelo` int(12) DEFAULT NULL,
  `IPI_cEnq` char(3) DEFAULT NULL,
  `IPI_CST` char(2) DEFAULT NULL,
  `IPI_vBC` decimal(15,2) DEFAULT NULL,
  `IPI_qUnid` decimal(16,4) DEFAULT NULL,
  `IPI_vUnid` decimal(15,4) DEFAULT NULL,
  `IPI_pIPI` decimal(5,2) DEFAULT NULL,
  `IPI_vIPI` decimal(15,2) DEFAULT NULL,
  `PIS_CST` char(2) DEFAULT NULL,
  `PIS_vBC` decimal(15,2) DEFAULT NULL,
  `PIS_pPIS` decimal(5,2) DEFAULT NULL,
  `PIS_vPIS` decimal(15,2) DEFAULT NULL,
  `PIS_qBCProd` decimal(16,4) DEFAULT NULL,
  `PIS_vAliqProd` decimal(15,4) DEFAULT NULL,
  `PISST_vBC` decimal(15,2) DEFAULT NULL,
  `PISST_pPIS` decimal(5,2) DEFAULT NULL,
  `PISST_qBCProd` decimal(16,4) DEFAULT NULL,
  `PISST_vAliqProd` decimal(15,4) DEFAULT NULL,
  `PISST_vPIS` decimal(15,2) DEFAULT NULL,
  `COFINS_CST` char(2) DEFAULT NULL,
  `COFINS_vBC` decimal(15,2) DEFAULT NULL,
  `COFINS_pCOFINS` decimal(5,2) DEFAULT NULL,
  `COFINS_vCOFINS` decimal(15,2) DEFAULT NULL,
  `COFINS_qBCProd` decimal(16,4) DEFAULT NULL,
  `COFINS_vAliqProd` decimal(15,4) DEFAULT NULL,
  `COFINSST_vBC` decimal(15,2) DEFAULT NULL,
  `COFINSST_pCOFINS` decimal(5,2) DEFAULT NULL,
  `COFINSST_vCOFINS` decimal(15,2) DEFAULT NULL,
  `COFINSST_qBCProd` decimal(16,4) DEFAULT NULL,
  `COFINSST_vAliqProd` decimal(15,4) DEFAULT NULL,
  `infAdProd` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`Id`,`nItem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nfe_produtos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
