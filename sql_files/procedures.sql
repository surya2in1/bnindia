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