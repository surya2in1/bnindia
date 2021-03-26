ALTER TABLE `groups` ADD `group_code` VARCHAR(500) NOT NULL AFTER `no_of_months`;
ALTER TABLE `groups` ADD `created_by` INT(11) NOT NULL COMMENT 'user id' AFTER `group_code`;

----------------------------------------------------------------------------------------
/* BKBM/08/A20 
B => as Bnindia 
K => as branch name save in profile
BM=> Total members in group, total member second digit always 0 or 5
	First digists  -> A-Z 1-9
    Second digits  -> In between 2 character no,
			 M as 0 and N - 5		
     
   e.g BM => 20, AM => 10, BN => 25, AN => 15
08=> lac/ chit amount
A20 => 1 lac A, 2 lac B/total group no any digits, group auto id
*/
----------------------------------------------------------------------------------------
-- call CreateGroupCode(20,1)

-- BEGIN   
--    DECLARE group_code VARCHAR(500);
--    DECLARE branch_name VARCHAR(500);
--    DECLARE total_member INT DEFAULT 0;

--    SET branch_name= (SELECT LEFT(u.branch_name,1) from users u where u.id=created_by); 

--    SET @total_member_arr = '["A","B"]';

--    SET @total_member_first_digits = (SELECT LEFT(total_number,1))-1;

-- SET @total_member_last_digits = (SELECT RIGHT(total_number,1));
  
 
--    SET group_code = JSON_VALUE(@total_member_arr,CONCAT( '$[',@total_member_first_digits,']'));
   
--    SELECT group_code;

-- END
-- parameters: total_number	20,created_by 1, chit_amount 100000
-- BPBM01A4
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

   SET @total_groups = (SELECT count(id) from groups);
   SET group_code = CONCAT('B',branch_name,@concat_total_member,@chit_amount_in_lac,@total_groups);
   SELECT group_code;

END