UPDATE `groups` SET `is_all_auction_completed` = '0' WHERE 1=1;

TRUNCATE `bnindkn8_staging`.`auctions`;
TRUNCATE TABLE `payments`;
TRUNCATE TABLE `payment_vouchers`;

SET  @num := 0;

UPDATE your_table SET id = @num := (@num+1);