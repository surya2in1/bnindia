ALTER TABLE `members_groups` ADD `is_transfer_user` TINYINT(2) NOT NULL AFTER `ticket_no`, ADD `old_user_id` INT(11) NOT NULL AFTER `is_transfer_user`;
ALTER TABLE `members_groups` ADD `new_user_id` INT(11) NOT NULL AFTER `old_user_id`;
-- get new member --
-- SELECT * FROM `users` WHERE `status` = 1 AND `role_id` = 2 and id not in(SELECT user_id from members_groups WHERE user_id= users.id)
-- get all available members 
-- SELECT u.id AS u__id, CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name)) AS member FROM users u LEFT JOIN members_groups mg ON mg.user_id = u.id INNER JOIN Roles ON Roles.id = u.role_id WHERE u.id not in (SELECT Payments.user_id AS Payments__user_id FROM payments Payments WHERE group_id = 9) AND (mg.is_transfer_user = 0 OR mg.is_transfer_user IS NULL) AND u.status = 1 AND u.id not in (3,4,5,6) AND Roles.name = 'member' group by u.id


get group id not in existing group 