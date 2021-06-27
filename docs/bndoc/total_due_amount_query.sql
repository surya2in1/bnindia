SELECT SUM(total_amount) total_amount,GROUP_CONCAT(auction_no) auction_no from (

 SELECT p.id as pid, 
 	Auctions.auction_no, 
 	MONTHNAME(Auctions.auction_date) as instalment_month, 
 	Auctions.net_subscription_amount,
   @due_amount :=( CASE WHEN p.remaining_subscription_amount > 0 THEN p.remaining_subscription_amount ELSE Auctions.net_subscription_amount END) as due_amount, 
   @due_late_fee := ( 
   				CASE WHEN (p.is_late_fee_clear <1 and p.remaining_late_fee < 1) or (remaining_late_fee IS NULL and is_late_fee_clear IS NULL ) 
   						THEN CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,CreateDateFromDay(g.date,Auctions.auction_date))

   					 WHEN p.is_late_fee_clear <1 and p.remaining_late_fee > 1 
   					 	THEN p.remaining_late_fee ELSE 0.00 END
   					) as due_late_fee, 
   	round((@due_amount + @due_late_fee),2) as total_amount

  FROM auctions Auctions 

  LEFT JOIN payments p ON p.auction_id=Auctions.id AND p.id = (
  			SELECT MAX(id) pid FROM payments WHERE user_id = 6 and group_id = 4 and auction_id =Auctions.id GROUP BY auction_id 
  		) 

  LEFT JOIN groups g on Auctions.group_id = g.id WHERE Auctions.group_id = 4 

  GROUP BY Auctions.auction_no HAVING pid NOT IN (
  			SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 6 and group_id = 4 and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC
  		) or pid is null ORDER BY Auctions.auction_no asc

  ) t