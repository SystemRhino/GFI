-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema bd_gfi
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bd_gfi
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_gfi` DEFAULT CHARACTER SET latin1 ;
USE `bd_gfi` ;

-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_categoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_categoria` VARCHAR(45) NOT NULL,
  `img_categoria` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_forma_pagto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_forma_pagto` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_forma_pagto` VARCHAR(45) NOT NULL,
  `img_pagto` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_responsavel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_responsavel` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_responsa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_status` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_status` VARCHAR(45) NULL DEFAULT NULL,
  `class` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_nivel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_nivel` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_nivel` VARCHAR(45) NOT NULL,
  `cd_nivel` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_user` VARCHAR(45) NULL DEFAULT NULL,
  `ds_login` VARCHAR(100) NULL DEFAULT NULL,
  `ds_senha` VARCHAR(100) NULL DEFAULT NULL,
  `id_nivel` INT(11) NULL DEFAULT NULL,
  `id_responsa` INT(11) NULL DEFAULT NULL,
  `ds_not` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 50
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_lancamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_lancamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_lancamento` VARCHAR(45) NULL DEFAULT NULL,
  `dt_lancamento` DATE NULL DEFAULT NULL,
  `id_responsa` INT(11) NULL DEFAULT NULL,
  `id_forma_pagto` INT(11) NULL DEFAULT NULL,
  `id_categoria` INT(11) NULL DEFAULT NULL,
  `vl_lancamento` DECIMAL(10,2) NULL DEFAULT NULL,
  `nr_parcela_atual` INT(11) NULL DEFAULT NULL,
  `nr_parcela_final` INT(11) NULL DEFAULT NULL,
  `id_user` INT(11) NULL DEFAULT NULL,
  `id_status` INT(11) NULL DEFAULT NULL,
  `nm_credor` VARCHAR(45) NULL DEFAULT NULL,
  `nm_devedor` VARCHAR(45) NULL DEFAULT NULL,
  `dt_lancamento_final` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_not`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_not` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_not` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_gfi`.`tb_not_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_gfi`.`tb_not_user` (
  `id_user` INT(11) NULL DEFAULT NULL,
  `id_not` INT(11) NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Alter Tables `bd_gfi`.`tb_user`
-- -----------------------------------------------------
ALTER TABLE tb_user
ADD CONSTRAINT id_nivel_user
FOREIGN KEY (id_nivel) REFERENCES tb_nivel(id);

ALTER TABLE tb_user
ADD CONSTRAINT id_responsa_user
FOREIGN KEY (id_responsa) REFERENCES tb_user(id);


-- -----------------------------------------------------
-- Alter Tables `bd_gfi`.`tb_lancamento`
-- -----------------------------------------------------
ALTER TABLE tb_lancamento
ADD CONSTRAINT id_responsa_lancamento
FOREIGN KEY (id_responsa) REFERENCES tb_responsavel(id);

ALTER TABLE tb_lancamento
ADD CONSTRAINT id_forma_pagto_lancamento
FOREIGN KEY (id_forma_pagto) REFERENCES tb_forma_pagto(id);

ALTER TABLE tb_lancamento
ADD CONSTRAINT id_categoria_lancamento
FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id);

ALTER TABLE tb_lancamento
ADD CONSTRAINT id_user_lancamento
FOREIGN KEY (id_user) REFERENCES tb_user(id);

ALTER TABLE tb_lancamento
ADD CONSTRAINT id_status_lancamento
FOREIGN KEY (id_status) REFERENCES tb_status(id);


-- -----------------------------------------------------
-- Alter Tables `bd_gfi`.`tb_not_user`
-- -----------------------------------------------------
ALTER TABLE tb_not_user
ADD CONSTRAINT id_user_not_user
FOREIGN KEY (id_user) REFERENCES tb_user(id);

ALTER TABLE tb_not_user
ADD CONSTRAINT id_not_not_user
FOREIGN KEY (id_not) REFERENCES tb_not(id);


-- -----------------------------------------------------
-- Insert `bd_gfi`.`tb_nivel`
-- -----------------------------------------------------
INSERT INTO tb_nivel (id,nm_nivel,cd_nivel) VALUES(1,'Admin',1);


-- -----------------------------------------------------
-- Insert `bd_gfi`.`tb_status`
-- -----------------------------------------------------
INSERT INTO tb_status (id,nm_status,class) VALUES(1,'Saida','pe');
INSERT INTO tb_status (id,nm_status,class) VALUES(2,'Entrada','de');


-- -----------------------------------------------------
-- Insert `bd_gfi`.`tb_categoria`
-- -----------------------------------------------------
INSERT INTO tb_categoria (nm_categoria,img_categoria) VALUES('Casa', 'fa fa-home');
INSERT INTO tb_categoria (nm_categoria,img_categoria) VALUES('Conta de luz', 'fa fa-boult');


-- -----------------------------------------------------
-- Insert `bd_gfi`.`tb_forma_pagto`
-- -----------------------------------------------------
INSERT INTO tb_forma_pagto (nm_forma_pagto,img_pagto) VALUES('Boleto', 'fa fa-barcode');
INSERT INTO tb_forma_pagto (nm_forma_pagto,img_pagto) VALUES('Cartao de Credito', 'fa fa-credit-card-alt');
INSERT INTO tb_forma_pagto (nm_forma_pagto,img_pagto) VALUES('TED', 'fa fa-bank');


-- -----------------------------------------------------
-- Insert `bd_gfi`.`tb_user`
-- -----------------------------------------------------
INSERT INTO tb_user (nm_user,ds_login,ds_senha,id_nivel) VALUES('System Rhino','systemrhino@gmail.com','systemrhino@gmail.com',1);