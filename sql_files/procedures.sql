DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateGroupCode`(IN `total_number` INT(11), IN `created_by` INT(11), IN `chit_amount` INT(11), OUT `result` VARCHAR(500))
    NO SQL
BEGIN   
   DECLARE group_code VARCHAR(500);
   DECLARE branch_name VARCHAR(500);
   DECLARE total_member INT DEFAULT 0;

   SET branch_name= (SELECT LEFT(u.branch_name,1) from users u where u.id=created_by); 

   SET @total_member_arr = '["A","B","C","D","E","F","G","H","I"]';

   SET @total_member_first_digit = (SELECT LEFT(total_number,1))-1;

   SET @total_member_first_digit_val = JSON_VALUE(@total_member_arr,CONCAT( '$[',@total_member_first_digit,']'));

   SET @total_member_last_digit = (SELECT RIGHT(total_number,1));
  
   IF @total_member_last_digit = 0 THEN
   		SET @total_member_last_digit_val = "M";
   END IF;
 
   IF @total_member_last_digit = 5 THEN
   		SET @total_member_last_digit_val = "N";
   END IF;

   SET @concat_total_member = CONCAT(@total_member_first_digit_val,@total_member_last_digit_val);

   SET @chit_amount_in_lac = FLOOR(chit_amount/100000);

   IF @chit_amount_in_lac < 10 THEN
      SET @chit_amount_in_lac = CONCAT('0',@chit_amount_in_lac);
   END IF;

   SET @ConvertAmountInLacToChar = ConvertNumberToChar(@chit_amount_in_lac); 	
   SET @total_groups = (SELECT count(id) from groups)+1;
   SET @last_code = CONCAT(@ConvertAmountInLacToChar,@total_groups);
   SET group_code = CONCAT('B',branch_name,@concat_total_member,'/',@chit_amount_in_lac,'/',@last_code);
   SET result = group_code;

END$$
DELIMITER ;
------------------------------------------------------------------------------------------------
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateCustomerId`(IN `param_role_id` INT(11), OUT `out_customer_id` VARCHAR(500))
BEGIN
	DECLARE total_member INT DEFAULT 0;
    DECLARE role_name varchar(10);
    
    SET role_name = (SELECT r.name from roles r where r.id=param_role_id);   
    
    IF role_name = 'member' THEN
    	SET total_member = 1+ (SELECT count(u.id) FROM users u left join roles r on u.role_id = r.id where r.name="member"
); 
   END IF; 
    
    SET out_customer_id = total_member;
END$$
DELIMITER ;
------------------------------------------------------------------------------------------------

BEGIN
DECLARE month VARCHAR(20); 
DECLARE group_due_date VARCHAR(20); 
DECLARE auction_last_day INT DEFAULT 0; 
Declare  day VARCHAR(20);
SET day = param_day;

/*Calculate day as per group type - start */
IF group_type = 'fortnight'  Then
  IF DAY(auction_date) <= 15 THEN 
    SET day =  (SELECT SUBSTRING_INDEX(param_day, ',', 1));
  ELSE 
    SET day =  (SELECT SUBSTRING_INDEX(param_day, ',', 2));  
  END IF;
END IF;

IF group_type = 'weekly'  Then 
    SET @week_start_date =(SELECT day(DATE(auction_date + INTERVAL ( - WEEKDAY(auction_date)) DAY)));
    SET @week_end_date = (SELECT day(DATE(auction_date + INTERVAL (6 - WEEKDAY(auction_date)) DAY)));
    IF param_day >= @week_start_date and param_day<=@week_end_date THEN  
      SET no = @week_start_date; 
      label: LOOP
        SET no = @week_start_date +1; 
          IF no =param_day THEN
               LEAVE label;
           END IF; 
          IF no =@week_end_date THEN 
           LEAVE label;
          END IF; 
      END LOOP label; 
      SET day = no;

    ELSE
      SET day ='';  

    END IF;  
END IF;

IF group_type = 'daily'  Then 
  SET day = DAY(auction_date);
END IF;
/*Calculate day as per group type-end */

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
END

--------------------------------------Bk------------------------------------------

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
END


=======================================================

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
END