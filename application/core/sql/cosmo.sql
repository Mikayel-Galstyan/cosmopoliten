SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `cosmopoliten` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `cosmopoliten` ;

-- -----------------------------------------------------
-- Table `cosmopoliten`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(45) NULL DEFAULT 'unkown' ,
  `last_name` VARCHAR(45) NULL DEFAULT 'unkown' ,
  `login` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `gender` INT(2) NULL ,
  `status` VARCHAR(45) NOT NULL DEFAULT '2' ,
  `date` DATETIME NOT NULL ,
  `password_salt` VARCHAR(45) NOT NULL ,
  `oauth_uid` VARCHAR(200) NULL ,
  `oauth_provider` VARCHAR(200) NULL ,
  `twitter_oauth_token` VARCHAR(200) NULL ,
  `twitter_oauth_token_secret` VARCHAR(200) NULL ,
  `username` VARCHAR(200) NULL ,
  `path` VARCHAR(200) NULL ,
  `activate` INT(2) NULL DEFAULT 0 ,
  `send_discount_maile_status` VARCHAR(45) NULL DEFAULT 0 ,
  `activation_key` VARCHAR(200) NULL ,
  `used_last_image` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`publishers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`publishers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `order` TINYINT(1)  NOT NULL ,
  `address` VARCHAR(45) NOT NULL ,
  `phone` VARCHAR(45) NOT NULL ,
  `site` VARCHAR(45) NULL ,
  `clicks` INT NOT NULL DEFAULT 0 ,
  `user_id` INT NOT NULL ,
  `end_order_date` DATETIME NOT NULL ,
  `population` INT NOT NULL DEFAULT 0 ,
  `status` INT(2) NULL DEFAULT 1 ,
  `path` VARCHAR(255) NOT NULL DEFAULT 'defaultImages/publishers.png' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_publishers_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_publishers_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `cosmopoliten`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`objectType`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`objectType` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `path` VARCHAR(255) NOT NULL DEFAULT 'defaultImages/objectType.png' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`shopList`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`shopList` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `address` VARCHAR(45) NOT NULL ,
  `phone` VARCHAR(45) NOT NULL ,
  `description` TEXT NOT NULL ,
  `publisher_id` INT NOT NULL ,
  `population` INT NOT NULL DEFAULT 0 ,
  `name` VARCHAR(45) NOT NULL ,
  `path` VARCHAR(255) NOT NULL DEFAULT 'defaultImages/shopList.png' ,
  `site` VARCHAR(45) NULL ,
  `mapControl` VARCHAR(200) NOT NULL DEFAULT '{lat:0,long:0}' ,
  `shops_group_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_shopList_publishers1` (`publisher_id` ASC) ,
  CONSTRAINT `fk_shopList_publishers1`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `cosmopoliten`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`objects`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`objects` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `description` TEXT NULL ,
  `path` VARCHAR(155) NOT NULL DEFAULT 'defaultImages/objects.png' ,
  `name` VARCHAR(45) NULL ,
  `cost` FLOAT NULL ,
  `publisher_id` INT NOT NULL ,
  `objectType_id` INT NOT NULL ,
  `shopList_id` INT NULL ,
  `population` INT NOT NULL DEFAULT 0 ,
  `gender` INT NOT NULL DEFAULT 1 ,
  `valuta` INT NOT NULL DEFAULT 1 ,
  `brand_id` INT NULL ,
  `material_id` INT NULL ,
  `color_id` INT NULL ,
  `object_group_id` INT NULL ,
  `path_back` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_objects_publishers` (`publisher_id` ASC) ,
  INDEX `fk_objects_objectType1` (`objectType_id` ASC) ,
  INDEX `fk_objects_shopList1` (`shopList_id` ASC) ,
  CONSTRAINT `fk_objects_publishers`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `cosmopoliten`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_objects_objectType1`
    FOREIGN KEY (`objectType_id` )
    REFERENCES `cosmopoliten`.`objectType` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_objects_shopList1`
    FOREIGN KEY (`shopList_id` )
    REFERENCES `cosmopoliten`.`shopList` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`loveList`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`loveList` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `object_id` INT NULL ,
  `publisher_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_loveList_users1` (`user_id` ASC) ,
  INDEX `fk_loveList_objects1` (`object_id` ASC) ,
  INDEX `fk_loveList_publishers1` (`publisher_id` ASC) ,
  CONSTRAINT `fk_loveList_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `cosmopoliten`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loveList_objects1`
    FOREIGN KEY (`object_id` )
    REFERENCES `cosmopoliten`.`objects` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loveList_publishers1`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `cosmopoliten`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`shopImage`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`shopImage` (
  `id` INT NOT NULL ,
  `path` VARCHAR(45) NOT NULL DEFAULT 'defaultImages/shopList.png' ,
  `shopList_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_shopImage_shopList1` (`shopList_id` ASC) ,
  CONSTRAINT `fk_shopImage_shopList1`
    FOREIGN KEY (`shopList_id` )
    REFERENCES `cosmopoliten`.`shopList` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`userImage`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`userImage` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `path` VARCHAR(155) NOT NULL ,
  `parent_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_userImage_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_userImage_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `cosmopoliten`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`brand`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`brand` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `logo` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`material`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`material` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`objectsGroup`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`objectsGroup` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `path` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`imagesStatus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`imagesStatus` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `likes` INT NOT NULL DEFAULT 0 ,
  `path` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`comment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `table_name` VARCHAR(45) NOT NULL DEFAULT 'objects' ,
  `message` TEXT NOT NULL ,
  `user_id` INT NULL ,
  `subject_id` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`shopGroup`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`shopGroup` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `path` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`discount`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`discount` (
  `id` INT NOT NULL ,
  `start_date` DATETIME NOT NULL ,
  `end_date` DATETIME NOT NULL ,
  `percent` FLOAT NOT NULL ,
  `shopList_id` INT NOT NULL ,
  `objectType_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cosmopoliten`.`color`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cosmopoliten`.`color` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `code` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
