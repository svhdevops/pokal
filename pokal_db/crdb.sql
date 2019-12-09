CREATE DATABASE pokal;

CREATE USER pokal@localhost IDENTIFIED BY 'svhpokal';
GRANT ALL PRIVILEGES ON pokal.* TO pokal@'localhost';
FLUSH PRIVILEGES;

USE pokal;

CREATE TABLE `dorfpokal_mannschaft` (
  `MannschaftsID` int(11) NOT NULL AUTO_INCREMENT,
  `Verein` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `KlassenID` int(11) NOT NULL,
  PRIMARY KEY (`MannschaftsID`)
);

CREATE TABLE `dorfpokal_schuetze` (
  `MannschaftsID` int(11) NOT NULL,
  `SchuetzenID`   int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `KlassenID` int(8) NOT NULL,
  `Serie1`   int(2) NOT NULL,
  `Serie2`   int(2) NOT NULL,
  `Schuss11` int(2) NOT NULL,
  `Schuss12` int(2) NOT NULL,
  `Schuss13` int(2) NOT NULL,
  PRIMARY KEY (`SchuetzenID`)
);

alter table dorfpokal_schuetze add unique (Name);      

CREATE TABLE `dorfpokal_klasse` (
  `KlassenID` int(11) NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`KlassenID`)
);

INSERT INTO `dorfpokal_klasse` VALUES(1,'Schützenklasse'),(2,'Damenklasse');

DELIMITER //
CREATE TRIGGER trAutoTeam AFTER INSERT ON dorfpokal_schuetze
FOR EACH ROW BEGIN
  DECLARE male INT;
  DECLARE weible INT;
  select count(KlassenID) into weible from dorfpokal_schuetze where MannschaftsID=NEW.MannschaftsID and KlassenID=2;
  select count(KlassenID) into male from dorfpokal_schuetze where MannschaftsID=NEW.MannschaftsID and KlassenID=1;

  IF weible > male then
    update dorfpokal_mannschaft set KlassenID=2 where MannschaftsID=NEW.MannschaftsID;
  else
    update dorfpokal_mannschaft set KlassenID=1 where MannschaftsID=NEW.MannschaftsID;    
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER trAutoTeamUpd AFTER UPDATE ON dorfpokal_schuetze
FOR EACH ROW BEGIN
  DECLARE male INT;
  DECLARE weible INT;
  select count(KlassenID) into weible from dorfpokal_schuetze where MannschaftsID=NEW.MannschaftsID and KlassenID=2;
  select count(KlassenID) into male from dorfpokal_schuetze where MannschaftsID=NEW.MannschaftsID and KlassenID=1;

  IF weible > male then
    update dorfpokal_mannschaft set KlassenID=2 where MannschaftsID=NEW.MannschaftsID;
  else
    update dorfpokal_mannschaft set KlassenID=1 where MannschaftsID=NEW.MannschaftsID;    
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION fnMaxFive (teamID INT) RETURNS INT
BEGIN
  DECLARE numSch INT;
  SELECT count(SchuetzenID) INTO numSch FROM dorfpokal_schuetze WHERE MannschaftsID=teamID;
  RETURN IF(numSch < 5, 1, 0);
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER trMaxFive BEFORE INSERT ON dorfpokal_schuetze
FOR EACH ROW BEGIN
  DECLARE numSch INT;
  SELECT count(SchuetzenID) INTO numSch FROM dorfpokal_schuetze WHERE MannschaftsID=NEW.MannschaftsID;
  IF numSch = 5 then
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Mannschaft hat schon 5 Schützen';
  END IF;
END //
DELIMITER ;

-- ERROR 1901 (HY000) at line 80: Function or expression '`fnMaxFive`()' cannot be used in the CHECK clause of `ckMaxFive`
-- alter table dorfpokal_schuetze add CONSTRAINT ckMaxFive CHECK (fnMaxFive(MannschaftsID) = 1);

show tables;
