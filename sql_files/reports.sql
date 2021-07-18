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
