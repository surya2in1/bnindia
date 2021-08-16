SELECT concat(g.group_code,'-',mg.ticket_no) AS gr_code_ticket, 
g.chit_amount AS g__chit_amount, 
g.no_of_months AS g__no_of_months, g.premium AS g__premium,
 mg.ticket_no AS mg__ticket_no,
  CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name)) AS member,
   (SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id) AS no_of_installments,
   (SELECT SUM(net_subscription_amount) FROM auctions WHERE group_id = mg.group_id) AS total_amt_payable, 
   (SELECT SUM(subscriber_dividend) FROM auctions WHERE group_id = mg.group_id) AS total_dividend, 
   (SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id AND auction_winner_member =mg.user_id) AS auction_winner,
    mg.group_id AS mg__group_id, mg.user_id AS mg__user_id, 

    Pending_Installments(mg.group_id,mg.user_id) AS pi 

    FROM members_groups mg 
    INNER JOIN groups g ON g.id = mg.group_id 
    INNER JOIN users u ON mg.user_id = u.id 

    WHERE 
    (g.created_by = 1 AND 
    	mg.group_id in (SELECT Auctions.group_id AS Auctions__group_id FROM auctions Auctions
    	 WHERE auction_group_due_date <  CURRENT_DATE() GROUP BY group_id  ORDER BY group_id ASC)
    )
    	  
   HAVING (pi >= 3 AND auction_winner = 0)  ORDER BY mg.group_id ASC, mg.user_id ASC

   =============================================================================================
(SELECT COUNT(*) painding_installments FROM
(SELECT  p.id as pid, Auctions.auction_no,Auctions.group_id,Auctions.auction_group_due_date
        FROM   auctions Auctions
            LEFT JOIN payments p ON p.auction_id=Auctions.id AND
            p.id = (SELECT MAX(id) pid FROM payments WHERE user_id = param_user_id and group_id = param_group_id  and auction_id =Auctions.id    GROUP BY auction_id )

            LEFT JOIN groups g on Auctions.group_id = g.id
        WHERE Auctions.auction_group_due_date < CURRENT_DATE() and Auctions.group_id = param_group_id 
        GROUP BY Auctions.auction_no
        HAVING pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = param_user_id and group_id = pa

=============================================================================================
SELECT (user_id), group_id FROM members_groups mg WHERE group_id in(3,4,9,12,14,16,20,23) ORDER by group_id ASC=>50
=>3 - 2,5,6,4,3=>3,4!

SELECT COUNT(user_id), group_id FROM members_groups mg WHERE group_id in(3,4,9,12,14,16,20,23) group by group_id
=============================================================================================        	
   -- transfer user module
   --  1. Get list of users which has 3 months pending instalments
   --  2. After transfer click show pop up with group selected, old user and suggest new user
   --  3. After submit warning and submit 
   --  4. After submit first members groups old user change status and enter new user with status and old user
   --  5. Add all paymnets till now
   --  6. Check all places to is_transfer_user = 0 for members_groups table wherever used
   --  7. Check wherever payments table used to is_transfer_user = 0
  

   -- Payments data--- not needed
   -- Get all group by installment no where group and old user
   -- Copy field: receipt_no,due_date, group_id, subscriber_ticket_no,user_id,instalment_no,instalment_month,subscription_amount,total_amount,received_amount,remark,pending_amount ,auction_id,created_by
   -- change fields : date as due_date, direct_debit_date as due_date
   -- 0 field value: late_fee,remaining_subscription_amount,cash_received_date,cheque_no all
   -- 1 : is_late_fee_clear,is_installment_complete
   -- received_by 3
   --- sample direct_debit_transaction_no

   -- is_transfer_user=1 ,old_user_id,new_user_id