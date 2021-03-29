ALTER TABLE `groups` ADD `group_code` VARCHAR(500) NOT NULL AFTER `no_of_months`;
ALTER TABLE `groups` ADD `created_by` INT(11) NOT NULL COMMENT 'user id' AFTER `group_code`;
ALTER TABLE `members_groups` ADD `temp_customer_id` VARCHAR(500) NOT NULL AFTER `group_id`;
ALTER TABLE `members_groups` ADD `ticket_no` INT(11) NOT NULL AFTER `temp_customer_id`;

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `CreateCustomerIdTrigger` BEFORE INSERT ON `users` FOR EACH ROW BEGIN   
   DECLARE serial_customer_id integer;

   CALL CreateCustomerId (New.role_id, serial_customer_id);

SET NEW.customer_id = serial_customer_id;

END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Triggers `members_groups`
--
DELIMITER $$
CREATE TRIGGER `CreateTempCustomerIdTrigger` BEFORE INSERT ON `members_groups` FOR EACH ROW BEGIN     
   SET @group_code= (SELECT g.group_code from groups g where g.id=New.group_id); 
    
   SET @total_members_in_group =  (SELECT count(mg.id) from members_groups mg where mg.group_id= New.group_id)+1; 
   
   SET New.ticket_no = @total_members_in_group;
   
   IF @total_members_in_group <10 THEN
   	SET @total_members_in_group = CONCAT('0',@total_members_in_group);
   END IF;
   
   SET NEW.temp_customer_id = CONCAT(@group_code,'/',@total_members_in_group);

END
$$
DELIMITER ;  

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
 
-- parameters: total_number	20,created_by 1, chit_amount 100000
-- BPBM01A4 
-- ============================================================================================

/** Search value in array
SET @doc = '{"A": 1, "B": 2}';
SELECT JSON_SEARCH(@doc, 'one', '2') 'Result';=> "$.B"


SELECT JSON_EXTRACT('{"1":"a", "2":"b"}', '$.2') AS 'Result' => "b"


SET @total_member_arr = '["J","A","B","C","D","E","F","G","H","I"]';
SELECT JSON_VALUE(@total_member_arr,'$[0]') result;  => J

**/

/** str split
SELECT JSON_ARRAY(1,2,3) AS 'Result'=>[1, 2, 3] 
**/
--==========================================================================
