INSERT INTO `modules` (`id`, `name`, `created`, `modified`) VALUES (NULL, 'reports', current_timestamp(), current_timestamp());
INSERT INTO `role_permissions` (`id`, `role_id`, `module_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '6', '1', current_timestamp(), current_timestamp());


ALTER TABLE `users` ADD `created_by` INT(11) NOT NULL AFTER `foreman_commission_in_percent`;
ALTER TABLE `auctions` ADD `created_by` INT(11) NOT NULL AFTER `auction_group_due_date`;
ALTER TABLE `payments` ADD `created_by` INT(11) NOT NULL AFTER `money_notes`;
ALTER TABLE `payment_heads` ADD `created_by` INT(11) NOT NULL AFTER `payment_head`;
ALTER TABLE `payment_vouchers` ADD `created_by` INT(11) NOT NULL AFTER `resaon`;
ALTER TABLE `other_payments` ADD `created_by` INT(11) NOT NULL AFTER `cheque_transaction_no`;

UPDATE `payments` SET `created_by` = '1' WHERE 1 = 1;
UPDATE `payment_heads` SET `created_by` = '1' WHERE 1 = 1;
UPDATE `payment_vouchers` SET `created_by` = '1' WHERE 1 = 1;
UPDATE `other_payments` SET `created_by` = '1' WHERE 1 = 1;
============================================================================================================


SELECT p.id as pid, Auctions.auction_no, MONTHNAME(Auctions.auction_date) as instalment_month, Auctions.net_subscription_amount, @due_amount :=( CASE WHEN p.remaining_subscription_amount > 0 THEN p.remaining_subscription_amount ELSE Auctions.net_subscription_amount END) as due_amount, @due_late_fee := ( CASE WHEN (p.is_late_fee_clear <1 and p.remaining_late_fee < 1) or (remaining_late_fee IS NULL and is_late_fee_clear IS NULL ) THEN CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,Auctions.auction_group_due_date) WHEN p.is_late_fee_clear <1 and p.remaining_late_fee > 1 THEN p.remaining_late_fee ELSE 0.00 END) as due_late_fee, round((@due_amount + @due_late_fee),2) as total_amount 

FROM auctions Auctions
LEFT JOIN payments p ON p.auction_id=Auctions.id 
	AND p.id = ( SELECT MAX(id) pid FROM payments WHERE user_id = 2 and auction_id =Auctions.id GROUP BY auction_id ) 
LEFT JOIN groups g on Auctions.group_id = g.id 

GROUP BY Auctions.auction_no 

HAVING pid NOT IN ( SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 2 and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC ) or pid is null 

ORDER BY Auctions.auction_no asc 




SELECT p.id as pid, Auctions.id,Auctions.auction_no,Auctions.group_id, MONTHNAME(Auctions.auction_date) as instalment_month FROM auctions Auctions LEFT JOIN payments p ON p.auction_id=Auctions.id AND p.id IN ( 6,4 ) where Auctions.group_id in (3,4) GROUP BY Auctions.auction_no, Auctions.group_id,


SELECT p.id as pid,p.group_id, Auctions.id, Auctions.auction_no,Auctions.group_id, MONTHNAME(Auctions.auction_date) as instalment_month,
@due_amount :=( CASE WHEN p.remaining_subscription_amount > 0 THEN p.remaining_subscription_amount ELSE Auctions.net_subscription_amount END) as due_amount,
@due_late_fee := ( CASE WHEN (p.is_late_fee_clear <1 and p.remaining_late_fee  < 1) or (remaining_late_fee  IS NULL and is_late_fee_clear  IS NULL ) THEN 
                                        CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,Auctions.auction_group_due_date)   
                                      WHEN p.is_late_fee_clear <1 and p.remaining_late_fee  > 1 THEN 
                                         p.remaining_late_fee
                                      ELSE  0.00
                                END)
            as due_late_fee,
round((@due_amount + @due_late_fee),2) as total_amount

FROM auctions Auctions
LEFT JOIN payments p ON p.auction_id=Auctions.id 
	AND p.id = ( SELECT MAX(id) pid FROM payments WHERE user_id = 2 and auction_id =Auctions.id GROUP BY auction_id ) 
    LEFT JOIN groups g on Auctions.group_id = g.id 
  WHERE Auctions.group_id in (SELECT group_id  FROM members_groups WHERE user_id = 2)


GROUP BY Auctions.auction_no, Auctions.group_id

HAVING pid NOT IN ( SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 2 and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC ) or pid is null



SELECT 
g.group_code,g.chit_amount,g.total_number,g.premium,
mg.temp_customer_id,mg.ticket_no,
CONCAT_WS(', ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name)) as member,
u.customer_id,u.area_code,
p.paid_sub_amt,p.paid_instalments
FROM members_groups mg 
LEFT JOIN groups g on  g.id= mg.group_id
LEFT JOIN users u on u.id=mg.user_id
LEFT JOIN (SELECT
           id,
           group_id,
           user_id,
           SUM(subscription_amount)  paid_sub_amt,
           SUM(if(is_installment_complete = '1', 1, 0)) AS paid_instalments
         FROM payments
         GROUP BY group_id) AS p
    ON p.group_id = g.id and p.user_id=u.id 
    
WHERE g.id= 3 and g.created_by= 1
 