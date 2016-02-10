-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema exercera
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `exercera` ;

-- -----------------------------------------------------
-- Schema exercera
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `exercera` DEFAULT CHARACTER SET utf8mb4 ;
USE `exercera` ;

-- -----------------------------------------------------
-- Table `exercera`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`category` ;

CREATE TABLE IF NOT EXISTS `exercera`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`user` ;

CREATE TABLE IF NOT EXISTS `exercera`.`user` (
  `id` INT NOT NULL,
  `username` VARCHAR(20) NOT NULL,
  `password` TEXT NOT NULL,
  `full_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`exercise`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`exercise` ;

CREATE TABLE IF NOT EXISTS `exercera`.`exercise` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(125) NOT NULL,
  `content` TEXT NOT NULL,
  `cat_id` INT NOT NULL,
  `user_create` TEXT NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_exercise_to_category_idx` (`cat_id` ASC),
  CONSTRAINT `fk_exercise_to_category`
    FOREIGN KEY (`cat_id`)
    REFERENCES `exercera`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`tag` ;

CREATE TABLE IF NOT EXISTS `exercera`.`tag` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`exercise_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`exercise_tag` ;

CREATE TABLE IF NOT EXISTS `exercera`.`exercise_tag` (
  `ex_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`ex_id`, `tag_id`),
  INDEX `fk_exercise_tag_to_tag_idx` (`tag_id` ASC),
  CONSTRAINT `fk_exercise_tag_to_exercise`
    FOREIGN KEY (`ex_id`)
    REFERENCES `exercera`.`exercise` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_exercise_tag_to_tag`
    FOREIGN KEY (`tag_id`)
    REFERENCES `exercera`.`tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`solution`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`solution` ;

CREATE TABLE IF NOT EXISTS `exercera`.`solution` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `is_approved` TINYINT(1) NULL DEFAULT 0,
  `ex_id` INT NOT NULL,
  `user_create` TEXT NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_solution_to_exercise_idx` (`ex_id` ASC),
  CONSTRAINT `fk_solution_to_exercise`
    FOREIGN KEY (`ex_id`)
    REFERENCES `exercera`.`exercise` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`comment` ;

CREATE TABLE IF NOT EXISTS `exercera`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `ex_id` INT NOT NULL,
  `user_create` TEXT NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_review_to_exercise_idx` (`ex_id` ASC),
  CONSTRAINT `fk_review_to_exercise`
    FOREIGN KEY (`ex_id`)
    REFERENCES `exercera`.`exercise` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`report`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`report` ;

CREATE TABLE IF NOT EXISTS `exercera`.`report` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `ex_id` INT NOT NULL,
  `user_create` TEXT NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_report_to_exercise_idx` (`ex_id` ASC),
  CONSTRAINT `fk_report_to_exercise`
    FOREIGN KEY (`ex_id`)
    REFERENCES `exercera`.`exercise` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exercera`.`exercise_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exercera`.`exercise_detail` ;

CREATE TABLE IF NOT EXISTS `exercera`.`exercise_detail` (
  `id` INT NOT NULL,
  `rating` FLOAT NOT NULL DEFAULT 0,
  `difficulty` FLOAT NOT NULL DEFAULT 0,
  `view_count` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_excercise_detail_to_exercise`
    FOREIGN KEY (`id`)
    REFERENCES `exercera`.`exercise` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
