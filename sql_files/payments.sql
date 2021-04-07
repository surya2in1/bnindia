ALTER TABLE `payments` CHANGE `receipt_no` `receipt_no` INT(11) NOT NULL;

ALTER TABLE `payments` ADD `auction_id` INT(11) NOT NULL AFTER `remark`;

ALTER TABLE `payments` ADD `is_installment_complete` TINYINT(2) NOT NULL DEFAULT '0' COMMENT '1-complete, 0-not complete' AFTER `auction_id`;


SELECT a.auction_no,max(p.id) as pid FROM auctions a left join payments p on a.id=p.auction_id where a.group_id = 13 group by a.auction_no having pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 2 and group_id = 13 and is_installment_complete = 1 GROUP BY group_id,user_id ASC) or pid is null

---------------------------------------------------------------------------------------------
SELECT a.auction_no,max(p.id) as pid 

	FROM auctions a 
	left join payments p on a.id=p.auction_id 

where a.group_id = 13 
group by a.auction_no 
having pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 2 and group_id = 13 and is_installment_complete = 1 GROUP BY group_id,user_id ASC) or pid is null

 

-- SELECT a.auction_no,p.id FROM auctions a left join payments p on a.id=p.auction_id where a.group_id = 13 and (p.is_installment_complete = 0 or p.is_installment_complete is null)  
-- SELECT group_id,user_id, MAX(id) AS mId FROM payments where user_id = 2 and group_id = 13 and is_installment_complete = 1 GROUP BY group_id,user_id ASC


-- SELECT p1.* FROM payments p1 INNER JOIN ( SELECT group_id,user_id, MAX(id) AS mId FROM payments where user_id = 1 and group_id=13 GROUP BY group_id,user_id ASC ) p2 ON p1.group_id = p2.group_id AND p1.user_id = p2.user_id AND p1.id = p2.mId where p1.is_installment_complete =0

-- SELECT *,max(p.is_installment_complete) FROM `payments` p group by auction_id HAVING max(p.is_installment_complete) =0

