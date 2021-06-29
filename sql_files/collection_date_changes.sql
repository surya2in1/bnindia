ALTER TABLE `groups` CHANGE `date` `date` VARCHAR(20) NOT NULL;
ALTER TABLE `auctions	` add `auction_group_due_date` VARCHAR(20) NOT NULL;
========================================================================================

DELIMITER $$
CREATE DEFINER=`bnindkn8_staging`@`localhost` FUNCTION `SPLIT_STRING`(str VARCHAR(255), delim VARCHAR(12), pos INT) RETURNS varchar(255) CHARSET utf8
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(str, delim, pos),
       CHAR_LENGTH(SUBSTRING_INDEX(str, delim, pos-1)) + 1),
       delim, '')$$
DELIMITER ;
---------------------------------------------------------------------------------------------------
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `CreateDateFromDay`(`param_day` VARCHAR(20), `auction_date` DATE, `group_type` VARCHAR(500)) RETURNS varchar(500) CHARSET utf8
    NO SQL
BEGIN
DECLARE month VARCHAR(20); 
DECLARE group_due_date VARCHAR(20); 
DECLARE auction_last_day INT DEFAULT 0; 
Declare  day VARCHAR(20);
Declare  week_day VARCHAR(20);
DECLARE no INT;
SET day = param_day;

IF group_type = 'fortnight'  Then
  IF DAY(auction_date) <= 15 THEN 
    SET day =  (SELECT SPLIT_STRING(param_day, ',', 1));
  ELSE 
    SET day =  (SELECT SPLIT_STRING(param_day, ',', 2));  
  END IF;
  IF day = '' THEN  SET day =  DAY(auction_date); END IF;
END IF;

IF group_type = 'weekly'  Then 
   SET @check_week_day = (SELECT FIND_IN_SET(param_day,'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday')); 
   
  IF  @check_week_day > 0  AND @check_week_day <=7 THEN  
      SET @week_start_date =(SELECT day(DATE(auction_date + INTERVAL ( - WEEKDAY(auction_date)) DAY)));
      SET @week_end_date = (SELECT day(DATE(auction_date + INTERVAL (6 - WEEKDAY(auction_date)) DAY)));
      SET no = @week_start_date; 
        label: LOOP 
            SET week_day = DAYNAME(CONCAT(YEAR(auction_date),'-',MONTH(auction_date),'-',no));
            IF week_day = param_day THEN
                 LEAVE label;
             END IF; 
            IF no =@week_end_date THEN 
             LEAVE label;
            END IF; 
            SET no = no +1; 
        END LOOP label; 
      SET day = no;  
  ELSE
     SET day =  DAY(auction_date);   
  END IF;
END IF;

IF group_type = 'daily'  Then 
  SET day = DAY(auction_date);
END IF;

SET month = MONTH(auction_date);

IF month<10 
 THEN SET month = CONCAT('0',month); 
END IF;

IF day<10 
THEN SET day = CONCAT('0',day); 
END IF; 

SET auction_last_day = DAY(LAST_DAY(auction_date));
 
IF day>auction_last_day
  THEN SET day = auction_last_day;
END IF;

SET group_due_date = CONCAT(YEAR(auction_date),'-',month,'-',day);

RETURN group_due_date;
END$$
DELIMITER ;

========================================================================================

CREATE TRIGGER `CheckIfAuctionDone` BEFORE UPDATE ON `groups`
 FOR EACH ROW BEGIN   
   DECLARE auction_count INT;
   
   IF NEW.date <> OLD.date OR NEW.group_type <> OLD.group_type THEN 
   
   SET auction_count = (SELECT COUNT(id) from auctions WHERE group_id= New.id);
   
   	IF  auction_count > 0 THEN
 		SET NEW.date = OLD.date;
        SET NEW.group_type = OLD.group_type;
   	END IF;
   END IF;
   
END

CREATE TRIGGER `CreateGroupDueDateBeforeInsert` BEFORE INSERT ON `auctions`
 FOR EACH ROW BEGIN   
   DECLARE g_type VARCHAR(20);
   DECLARE group_due_date VARCHAR(20);
   
   SET g_type = (SELECT group_type from groups WHERE id= New.group_id);
   
   SET group_due_date= (SELECT date from groups WHERE id= New.group_id);
   -- SET NEW.auction_group_due_date = group_due_date;
 SET NEW.auction_group_due_date = CreateDateFromDay(group_due_date,New.auction_date,g_type);

END

CREATE TRIGGER `CreateGroupDueDateBeforeUpdate` BEFORE UPDATE ON `auctions`
 FOR EACH ROW BEGIN   
   DECLARE g_type VARCHAR(20);
   DECLARE group_due_date VARCHAR(20);
   
   IF NEW.group_id <> OLD.group_id OR NEW.auction_date <> OLD.auction_date THEN 
   
   SET g_type = (SELECT group_type from groups WHERE id= New.group_id);
   
   SET group_due_date= (SELECT date from groups WHERE id= New.group_id); 
   
 SET NEW.auction_group_due_date = CreateDateFromDay(group_due_date,New.auction_date,g_type);

   END IF;
   
END
--------------------------------------------------------------------------------

-- for all rows update
UPDATE auctions SET auction_group_due_date = '' WHERE 1 = 1;
