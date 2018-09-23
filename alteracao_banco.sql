/*  alterações no banco de dados */
/* [2018.09.11] */

ALTER TABLE `sc_evento` ADD `pInterno` VARCHAR(120) NOT NULL AFTER `idLinguagem`;
ALTER TABLE `sc_evento` ADD `idRespAprovacao` INT(4) NOT NULL AFTER `idSuplente`;
ALTER TABLE `sc_evento` ADD `status` INT(1) NOT NULL COMMENT 'rascunho:1;planejamento:2;aprovado:3' AFTER `n_agentes_abc`;