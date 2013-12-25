SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`users` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `token` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `password` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `last_login` INT NULL,
  `timezon` VARCHAR(255) NULL,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`role_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`role_types` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`role_types` (
  `role_type_id` INT NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  PRIMARY KEY (`role_type_id`),
  UNIQUE INDEX `role_type_id_UNIQUE` (`role_type_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`users_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`users_roles` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`users_roles` (
  `user_role_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `users_user_id` INT NOT NULL,
  `role_types_role_type_id` INT NOT NULL,
  PRIMARY KEY (`user_role_id`),
  UNIQUE INDEX `user_project_role_id_UNIQUE` (`user_role_id` ASC),
  INDEX `fk_users_projects_roles_users_idx` (`users_user_id` ASC),
  INDEX `fk_users_projects_roles_role_types1_idx` (`role_types_role_type_id` ASC),
  CONSTRAINT `fk_users_projects_roles_users`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_projects_roles_role_types1`
    FOREIGN KEY (`role_types_role_type_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`role_types` (`role_type_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`projects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`projects` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`projects` (
  `project_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `project_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `project_desc` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `start_date` INT NULL,
  `status` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `pm_id` INT NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE INDEX `project_id_UNIQUE` (`project_id` ASC),
  INDEX `fk_projects_users_roles1_idx` (`pm_id` ASC),
  CONSTRAINT `fk_projects_users_roles1`
    FOREIGN KEY (`pm_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`users_roles` (`user_role_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`groups` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`groups` (
  `group_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `group_desc` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `start_date` INT NULL,
  `end_date` INT NULL,
  `per_complete` INT NULL,
  `projects_project_id` INT NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE INDEX `group_id_UNIQUE` (`group_id` ASC),
  INDEX `fk_groups_projects1_idx` (`projects_project_id` ASC),
  CONSTRAINT `fk_groups_projects1`
    FOREIGN KEY (`projects_project_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`projects` (`project_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`tasks` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`tasks` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `task_desc` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `start_date` INT NULL,
  `end_date` INT NULL,
  `per_complete` INT NULL,
  `status` VARCHAR(25) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `groups_group_id` INT NOT NULL,
  `assigned_to_id` INT NOT NULL,
  PRIMARY KEY (`task_id`),
  UNIQUE INDEX `task_id_UNIQUE` (`task_id` ASC),
  INDEX `fk_tasks_groups1_idx` (`groups_group_id` ASC),
  INDEX `fk_tasks_users_roles1_idx` (`assigned_to_id` ASC),
  CONSTRAINT `fk_tasks_groups1`
    FOREIGN KEY (`groups_group_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`groups` (`group_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_users_roles1`
    FOREIGN KEY (`assigned_to_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`users_roles` (`user_role_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `p4.mahe-cscie-15.biz`.`milestones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `p4.mahe-cscie-15.biz`.`milestones` ;

CREATE TABLE IF NOT EXISTS `p4.mahe-cscie-15.biz`.`milestones` (
  `milestone_id` INT NOT NULL AUTO_INCREMENT,
  `created` INT NULL,
  `modified` INT NULL,
  `milestone_desc` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `milestone_date` INT NULL,
  `groups_group_id` INT NOT NULL,
  `assigned_to_id` INT NOT NULL,
  PRIMARY KEY (`milestone_id`),
  UNIQUE INDEX `milestone_id_UNIQUE` (`milestone_id` ASC),
  INDEX `fk_milestones_groups1_idx` (`groups_group_id` ASC),
  INDEX `fk_milestones_users_roles1_idx` (`assigned_to_id` ASC),
  CONSTRAINT `fk_milestones_groups1`
    FOREIGN KEY (`groups_group_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`groups` (`group_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_milestones_users_roles1`
    FOREIGN KEY (`assigned_to_id`)
    REFERENCES `p4.mahe-cscie-15.biz`.`users_roles` (`user_role_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
COMMENT = '	';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
