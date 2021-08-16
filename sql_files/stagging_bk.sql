DELIMITER $$
CREATE DEFINER=`bnindkn8`@`localhost` FUNCTION `CalculateLateFee`(`net_subscription_amount` DECIMAL(10,2), `group_late_fee` DECIMAL(10,2), `group_due_date` VARCHAR(20)) RETURNS varchar(500) CHARSET utf8
    NO SQL
BEGIN 
 DECLARE late_fee DECIMAL(10,2) DEFAULT 0;
 DECLARE total_due_months INT DEFAULT 0; 
 DECLARE inc INT DEFAULT 0;
 DECLARE total_late_fee DECIMAL(10,2) DEFAULT 0;
 
 IF group_due_date < CURDATE()
 	THEN 
    
    SET total_due_months = (SELECT TIMESTAMPDIFF(month, group_due_date, CURDATE()));
 
  label: 
 WHILE inc <= total_due_months DO
    
    IF (inc=0) THEN
       SET late_fee =(net_subscription_amount*group_late_fee)/100;
    ELSE
    	SET late_fee = late_fee+((late_fee*group_late_fee)/100);
    END IF;
    
    SET total_late_fee = total_late_fee+late_fee;
    SET inc = inc + 1;
    
  END 
 WHILE label;

 END IF;

  RETURN total_late_fee;
  -- RETURN total_due_months; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`bnindkn8`@`localhost` FUNCTION `ConvertNumberToChar`(`chit_amount` INT(11)) RETURNS varchar(500) CHARSET utf8
    NO SQL
BEGIN
  DECLARE counter INT DEFAULT 1; 
  DECLARE concatdigits VARCHAR(20);
  SET concatdigits = "";

  SET @total_member_arr = '["J","A","B","C","D","E","F","G","H","I"]';

    WHILE counter <= LENGTH(chit_amount) DO 
        SET @each_digit = (SELECT SUBSTRING(chit_amount, counter, 1)); 
        
        -- SET @each_digit_val = JSON_VALUE(@total_member_arr,CONCAT( '$[',@each_digit,']'));
        
        SET @each_digit_val = REPLACE(JSON_EXTRACT(@total_member_arr, CONCAT( '$[',@each_digit,']')), '"', '' );

        SET concatdigits = CONCAT(concatdigits,@each_digit_val); 
        
        SET counter = counter + 1;
    END WHILE;  
      return concatdigits; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`bnindkn8`@`localhost` FUNCTION `CreateDateFromDay`(`day` VARCHAR(20), `auction_date` DATE) RETURNS varchar(500) CHARSET utf8
    NO SQL
BEGIN
DECLARE month VARCHAR(20); 
DECLARE group_due_date VARCHAR(20); 
DECLARE auction_last_day INT DEFAULT 0; 

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
