SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema eco_trak6162
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eco_trak6162` DEFAULT CHARACTER SET utf8 ;
USE `eco_trak6162` ;

-- -----------------------------------------------------
-- Table Cliente
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Cliente` (
  `id_cliente` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_cliente` VARCHAR(100) NOT NULL,
  `email_cliente` VARCHAR(100) NOT NULL,
  `cpf_cliente` VARCHAR(11) NOT NULL,
  `telefone_cliente` VARCHAR(20) NOT NULL,
  `dt_nasc_cliente` DATE NOT NULL,
  `endereco_cliente` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE INDEX `cpf_cliente_UNIQUE` (`cpf_cliente` ASC),
  UNIQUE INDEX `email_cliente_UNIQUE` (`email_cliente` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table Tarifa
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Tarifa` (
  `id_tarifa` INT NOT NULL AUTO_INCREMENT,
  `tipo_consumo` VARCHAR(20) NOT NULL,
  `valor_unitario` DECIMAL(7,2) NOT NULL,
  `data_vigencia` DATE NULL,
  PRIMARY KEY (`id_tarifa`)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table Leitura (CASCADE)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Leitura` (
  `id_leitura` INT NOT NULL AUTO_INCREMENT,
  `valor_medidor` DECIMAL(10,3) NOT NULL,
  `dt_registro` DATE NOT NULL,
  `id_cliente` INT UNSIGNED NOT NULL,
  `id_tarifa` INT NOT NULL,
  PRIMARY KEY (`id_leitura`),

  INDEX `fk_Leitura_Cliente_idx` (`id_cliente` ASC),
  INDEX `fk_Leitura_Tarifa_idx` (`id_tarifa` ASC),

  -- CASCADE: apaga leituras automaticamente ao deletar cliente ou tarifa
  CONSTRAINT `fk_Leitura_Cliente`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `Cliente` (`id_cliente`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT `fk_Leitura_Tarifa`
    FOREIGN KEY (`id_tarifa`)
    REFERENCES `Tarifa` (`id_tarifa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
