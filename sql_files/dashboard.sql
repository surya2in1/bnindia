DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CalculateMoneyNotes`(IN `received_by_param` INT(11), IN `created_by_param` INT(11))
    NO SQL
BEGIN  
 IF received_by_param =1
 THEN
 SELECT 
         (IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5".val')),0)
) as total_notes,
               IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000".val')),0) AS two_thousand_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000".val')),0) AS one_thousand_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500".val')),0) AS five_hundred_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100".val')),0) AS hundred_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50".val')),0) AS fifty_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20".val')),0) AS twenty_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10".val')),0) AS ten_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5".val')),0) AS five_notes,

IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1c".val')),0) AS one_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2c".val')),0) AS two_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5c".val')),0) AS five_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10c".val')),0) AS ten_c,

(
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10c".val')),0)
) as total_coins,

IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000r".val')),0) AS two_thousandr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000r".val')),0) AS one_thousandr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500r".val')),0) AS five_hundredr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100r".val')),0) AS hundredr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50r".val')),0) AS fiftyr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20r".val')),0) AS twentyr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10r".val')),0) AS tenr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5r".val')),0) AS fiver_notes,

(IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5r".val')),0)
) as total_reverse_notes,

SUM(total_amount) as total_cash
               from payments 
               WHERE received_by=1 and created_by= created_by_param;
  END IF;
  
 IF received_by_param =2
 THEN
 SELECT COUNT(id) as no_of_cheques,SUM(total_amount) as total_cheque_amount FROM payments WHERE received_by= 2 and created_by= created_by_param;
 END IF; 
 
 IF received_by_param =3
 THEN
 SELECT COUNT(id) as no_of_dd,SUM(total_amount) as total_dd_amount FROM payments WHERE received_by= 3 and created_by= created_by_param;
 END IF; 
 
 IF received_by_param =0
 THEN
 SELECT SUM(total_amount) as total_amount FROM payments WHERE created_by= created_by_param;
 END IF; 
END$$
DELIMITER ;
--------------------------------------------------------------------------------------------

SELECT SUM(JSON_EXTRACT(money_notes,'$."2000".val')) AS name FROM payments;
    
SELECT 
(IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10".val')),0)+
 IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5".val')),0)
) as total_notes,

IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000".val')),0) AS two_thousand_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000".val')),0) AS one_thousand_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500".val')),0) AS five_hundred_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100".val')),0) AS hundred_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50".val')),0) AS fifty_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20".val')),0) AS twenty_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10".val')),0) AS ten_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5".val')),0) AS five_notes,

IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1c".val')),0) AS one_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2c".val')),0) AS two_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5c".val')),0) AS five_c,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10c".val')),0) AS ten_c,

(
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5c".val')),0)+
  IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10c".val')),0)
) as total_coins,

IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000r".val')),0) AS two_thousandr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000r".val')),0) AS one_thousandr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500r".val')),0) AS five_hundredr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100r".val')),0) AS hundredr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50r".val')),0) AS fiftyr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20r".val')),0) AS twentyr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10r".val')),0) AS tenr_notes,
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5r".val')),0) AS fiver_notes,

(IFNULL(SUM(JSON_EXTRACT(money_notes,'$."2000r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."1000r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."500r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."100r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."50r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."20r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."10r".val')),0)+
IFNULL(SUM(JSON_EXTRACT(money_notes,'$."5r".val')),0)
) as total_reverse_notes
FROM payments

        