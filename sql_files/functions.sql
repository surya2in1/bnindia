DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConvertNumberToChar`(`chit_amount` INT(11)) RETURNS varchar(500) CHARSET utf8
    NO SQL
BEGIN
	DECLARE counter INT DEFAULT 1; 
	DECLARE concatdigits VARCHAR(20);
	SET concatdigits = "";

	SET @total_member_arr = '["J","A","B","C","D","E","F","G","H","I"]';

    WHILE counter <= LENGTH(chit_amount) DO 
        SET @each_digit = (SELECT SUBSTRING(chit_amount, counter, 1)); 
        
		SET @each_digit_val = JSON_VALUE(@total_member_arr,CONCAT( '$[',@each_digit,']'));
       
        SET concatdigits = CONCAT(concatdigits,@each_digit_val); 
        
        SET counter = counter + 1;
    END WHILE;  
      return concatdigits; 
END$$
DELIMITER ;
------------------------------------------------------------------------------------------------