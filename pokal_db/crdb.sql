CREATE DATABASE pokal;

CREATE USER pokal@'%' IDENTIFIED BY 'svhpokal';
GRANT ALL PRIVILEGES ON pokal.* TO pokal@'%';
FLUSH PRIVILEGES;

USE pokal;

CREATE TABLE `dorfpokal_mannschaft` (
  `MannschaftsID` int(11) NOT NULL AUTO_INCREMENT,
  `Verein` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `KlassenID` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`MannschaftsID`),
  unique (`Verein`)
);

CREATE TABLE `dorfpokal_schuetze` (
  `MannschaftsID` int(11) NOT NULL,
  `SchuetzenID`   int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `KlassenID` int(8) NOT NULL,
  `Serie1`   int(2),
  `Serie2`   int(2),
  `Schuss11` int(2),
  `Schuss12` int(2),
  `Schuss13` int(2),
  PRIMARY KEY (`SchuetzenID`),
  unique (`Name`),
  CONSTRAINT `ref_id` 
    FOREIGN KEY (Mannschaftsid)
    REFERENCES dorfpokal_mannschaft (Mannschaftsid)
    ON DELETE CASCADE
);

CREATE TABLE `dorfpokal_klasse` (
  `KlassenID` int(11) NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`KlassenID`)
);

INSERT INTO `dorfpokal_klasse` VALUES(1,'Schützenklasse'),(2,'Damenklasse');

CREATE TABLE `admin` (
  `status` BOOL NOT NULL,
  `since` TIMESTAMP     
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO admin(status) VALUES(FALSE);

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

  select count(KlassenID) into weible from dorfpokal_schuetze where MannschaftsID=OLD.MannschaftsID and KlassenID=2;
  select count(KlassenID) into male from dorfpokal_schuetze where MannschaftsID=OLD.MannschaftsID and KlassenID=1;

  IF weible > male then
    update dorfpokal_mannschaft set KlassenID=2 where MannschaftsID=OLD.MannschaftsID;
  else
    update dorfpokal_mannschaft set KlassenID=1 where MannschaftsID=OLD.MannschaftsID;
  END IF;
END //

CREATE FUNCTION fnMaxFive (teamID INT) RETURNS INT
BEGIN
  DECLARE numSch INT;
  SELECT count(SchuetzenID) INTO numSch FROM dorfpokal_schuetze WHERE MannschaftsID=teamID;
  RETURN IF(numSch < 5, 1, 0);
END //

CREATE TRIGGER trMaxFive BEFORE INSERT ON dorfpokal_schuetze
FOR EACH ROW BEGIN
  DECLARE numSch INT;
  SELECT count(SchuetzenID) INTO numSch FROM dorfpokal_schuetze WHERE MannschaftsID=NEW.MannschaftsID;
  IF numSch = 5 then
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Schütze kann nicht zu dieser Mannschaft hinzugefügt werden, da diese schon 5 Schützen hat.';
  END IF;
END //

-- ERROR 1901 (HY000) at line 80: Function or expression '`fnMaxFive`()' cannot be used in the CHECK clause of `ckMaxFive`
-- alter table dorfpokal_schuetze add CONSTRAINT ckMaxFive CHECK (fnMaxFive(MannschaftsID) = 1);

-- instead use: 
CREATE TRIGGER trMaxFiveUpd BEFORE UPDATE ON dorfpokal_schuetze
FOR EACH ROW BEGIN
  DECLARE numSch INT;
  SELECT count(SchuetzenID) INTO numSch FROM dorfpokal_schuetze WHERE MannschaftsID=NEW.MannschaftsID;
  IF numSch = 5 and OLD.MannschaftsID != NEW.MAnnschaftsID then
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Schütze kann nicht in diese Mannschaft verlegt werden, da diese schon 5 Schützen hat.';
  END IF;
END //
DELIMITER ;

show tables;
show grants;
