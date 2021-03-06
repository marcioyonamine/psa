/*  alterações no banco de dados */
/* [2018.10.05] */

ALTER TABLE `sc_evento` ADD `pInterno` VARCHAR(120) NOT NULL AFTER `idLinguagem`;
ALTER TABLE `sc_evento` ADD `idRespAprovacao` INT(4) NOT NULL AFTER `idSuplente`;
ALTER TABLE `sc_evento` ADD `status` INT(1) NOT NULL COMMENT 'rascunho:1;planejamento:2;aprovado:3' AFTER `n_agentes_abc`;
ALTER TABLE `sc_atividade` ADD `status` INT(1) NOT NULL AFTER `publicado`;
ALTER TABLE `sc_evento` ADD `previsto` INT NOT NULL AFTER `revisado`;
ALTER TABLE `sc_evento` ADD `descricao` LONGTEXT NOT NULL AFTER `sinopse`;
ALTER TABLE `sc_ocorrencia` ADD `descricao` VARCHAR(255) NOT NULL AFTER `idOcorrencia`;