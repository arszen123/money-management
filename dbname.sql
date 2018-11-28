-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `budget` (`id`, `name`, `starting_balance`, `current_balance`, `from`, `to`, `user_id`) VALUES
(1,	'Food',	'30000',	'18170',	'2018-11-01',	'2018-11-30',	1),
(2,	'Transportation',	'10000',	'9515',	'2018-11-01',	'2018-11-30',	1),
(3,	'Entertainment',	'15000',	'7813',	'2018-11-01',	'2018-11-30',	1),
(4,	'Food',	'30000',	'-1912',	'2018-10-01',	'2018-10-31',	1),
(5,	'Transportation',	'10000',	'7530',	'2018-10-01',	'2018-10-31',	1),
(6,	'Entertainment',	'15000',	'12300',	'2018-10-01',	'2018-10-31',	1);

INSERT INTO `budget_category` (`budget_id`, `category_id`) VALUES
(4,	20),
(5,	21),
(6,	22),
(3,	22),
(2,	21),
(1,	20);

INSERT INTO `category` (`id`, `user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
(20,	1,	'Food',	2,	'food',	0),
(21,	1,	'Transportation',	2,	'transportation',	0),
(22,	1,	'Entertainment',	2,	'entertainment',	0),
(23,	1,	'Education',	2,	'Education',	0),
(24,	1,	'Personal Care',	2,	'personal_care',	0),
(25,	1,	'Health & Fitness (was healthcare)',	2,	'health',	0),
(26,	1,	'Kids',	2,	'Education',	0),
(27,	1,	'Gifts & Donations',	2,	'gift',	0),
(28,	1,	'Bills & Utilities',	2,	'bill',	0),
(29,	1,	'Fees & Charges',	2,	'fee',	0),
(30,	1,	'Business Services',	2,	'business',	0),
(31,	1,	'Taxes',	2,	'taxes',	0),
(32,	1,	'Paycheck',	1,	'Paycheck',	0),
(33,	1,	'Investment',	1,	'Investment',	0),
(34,	1,	'Returned Purchase',	1,	'returned_purchase',	0),
(35,	1,	'Bonus',	1,	'bonus',	0),
(36,	1,	'Interest Income',	1,	'interest_income',	0),
(37,	1,	'Reimbursement',	1,	'reimbursment',	0),
(38,	1,	'Rental Income',	1,	'rent',	0),
(39,	1,	'Salary',	1,	'salary',	0),
(40,	1,	'Other',	1,	'salary',	0),
(41,	1,	'Payback',	1,	'salary',	0),
(42,	1,	'Other',	1,	'other',	1),
(43,	1,	'Other',	2,	'other',	0),
(44,	5,	'Food',	2,	'food',	0),
(45,	5,	'Transportation',	2,	'transportation',	0),
(46,	5,	'Entertainment',	2,	'entertainment',	0),
(47,	5,	'Education',	2,	'Education',	0),
(48,	5,	'Personal Care',	2,	'personal_care',	0),
(49,	5,	'Health & Fitness (was healthcare)',	2,	'health',	0),
(50,	5,	'Kids',	2,	'Education',	0),
(51,	5,	'Gifts & Donations',	2,	'gift',	0),
(52,	5,	'Bills & Utilities',	2,	'bill',	0),
(53,	5,	'Fees & Charges',	2,	'fee',	0),
(54,	5,	'Business Services',	2,	'business',	0),
(55,	5,	'Taxes',	2,	'taxes',	0),
(56,	5,	'Paycheck',	1,	'Paycheck',	0),
(57,	5,	'Investment',	1,	'Investment',	0),
(58,	5,	'Returned Purchase',	1,	'returned_purchase',	0),
(59,	5,	'Bonus',	1,	'bonus',	0),
(60,	5,	'Interest Income',	1,	'interest_income',	0),
(61,	5,	'Reimbursement',	1,	'reimbursment',	0),
(62,	5,	'Rental Income',	1,	'rent',	0);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2018_11_15_081350_create_database',	2);


INSERT INTO `transaction` (`id`, `user_id`, `wallet_id`, `category_id`, `amount`, `comment`, `tag`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	20,	1390,	NULL,	'pizza',	'2018-10-31 20:54:46',	'2018-10-31 20:54:46'),
(2,	1,	1,	20,	130,	NULL,	'water',	'2018-10-29 08:01:54',	'2018-10-29 08:01:54'),
(3,	1,	1,	20,	2300,	NULL,	'pizza',	'2018-10-28 19:02:07',	'2018-10-28 19:02:07'),
(4,	1,	1,	20,	3415,	NULL,	'food',	'2018-10-28 09:40:13',	'2018-10-28 09:40:13'),
(5,	1,	1,	22,	2700,	NULL,	'mozi',	'2018-10-28 09:18:11',	'2018-10-28 09:18:11'),
(6,	1,	1,	20,	2360,	NULL,	'',	'2018-10-27 19:11:32',	'2018-10-27 19:11:32'),
(7,	1,	1,	20,	1400,	NULL,	'pizza',	'2018-10-26 23:27:48',	'2018-10-26 23:27:48'),
(8,	1,	1,	28,	4593,	NULL,	'lámpák ',	'2018-10-26 18:39:57',	'2018-10-26 18:39:57'),
(9,	1,	1,	20,	2250,	NULL,	'meal',	'2018-10-26 12:42:38',	'2018-10-26 12:42:38'),
(10,	1,	1,	23,	255,	NULL,	'',	'2018-10-24 18:16:36',	'2018-10-24 18:16:36'),
(11,	1,	1,	20,	200,	NULL,	'kenyer',	'2018-10-24 18:07:32',	'2018-10-24 18:07:32'),
(12,	1,	1,	21,	235,	NULL,	'határ',	'2018-10-23 15:12:26',	'2018-10-23 15:12:26'),
(13,	1,	1,	20,	3750,	NULL,	'meal',	'2018-10-19 11:59:53',	'2018-10-19 11:59:53'),
(14,	1,	1,	21,	1300,	NULL,	'attila',	'2018-10-19 00:00:00',	'2018-10-19 00:00:00'),
(15,	1,	1,	20,	1000,	NULL,	'troja',	'2018-10-17 23:31:05',	'2018-10-17 23:31:05'),
(16,	1,	1,	28,	7830,	NULL,	'net',	'2018-10-16 07:08:31',	'2018-10-16 07:08:31'),
(17,	1,	1,	20,	1100,	NULL,	'food',	'2018-10-14 16:49:32',	'2018-10-14 16:49:32'),
(18,	1,	1,	21,	235,	NULL,	'határ',	'2018-10-14 15:11:43',	'2018-10-14 15:11:43'),
(19,	1,	1,	20,	4000,	NULL,	'meal',	'2018-10-12 20:25:08',	'2018-10-12 20:25:08'),
(20,	1,	1,	20,	1400,	NULL,	'pizza',	'2018-10-11 23:41:23',	'2018-10-11 23:41:23'),
(21,	1,	1,	20,	1000,	NULL,	'troja',	'2018-10-10 19:58:55',	'2018-10-10 19:58:55'),
(22,	1,	1,	20,	325,	NULL,	'bclass',	'2018-10-10 15:49:52',	'2018-10-10 15:49:52'),
(23,	1,	1,	20,	1602,	NULL,	'food',	'2018-10-09 19:55:03',	'2018-10-09 19:55:03'),
(24,	1,	1,	28,	10040,	NULL,	'szetav',	'2018-10-07 18:33:59',	'2018-10-07 18:33:59'),
(25,	1,	1,	21,	300,	NULL,	'határ',	'2018-10-07 17:39:42',	'2018-10-07 17:39:42'),
(26,	1,	1,	21,	400,	NULL,	'határ',	'2018-10-05 17:21:48',	'2018-10-05 17:21:48'),
(27,	1,	1,	20,	3600,	NULL,	'meal',	'2018-10-05 06:45:39',	'2018-10-05 06:45:39'),
(28,	1,	1,	20,	1490,	NULL,	'troja',	'2018-10-04 17:42:17',	'2018-10-04 17:42:17'),
(29,	1,	1,	20,	490,	NULL,	'bclass',	'2018-10-01 20:24:26',	'2018-10-01 20:24:26'),
(30,	1,	1,	41,	2000,	NULL,	'mozi',	'2018-10-28 22:09:55',	'2018-10-28 22:09:55'),
(31,	1,	1,	35,	10000,	NULL,	'egyetem',	'2018-10-11 09:45:57',	'2018-10-11 09:45:57'),
(32,	1,	1,	39,	142000,	NULL,	'',	'2018-10-11 09:45:40',	'2018-10-11 09:45:40'),
(33,	1,	1,	41,	100000,	NULL,	'apa',	'2018-10-07 17:41:11',	'2018-10-07 17:41:11'),
(34,	1,	1,	22,	4500,	'Bohem: 1500 (1 kör) \r\n450 + 900\r\nBarcraft: 750\r\nJate: 2*450\r\n',	NULL,	'2018-10-19 08:25:02',	'2018-10-19 08:25:02'),
(35,	1,	1,	20,	1450,	NULL,	'troja',	'2018-11-14 19:39:30',	'2018-11-14 19:39:30'),
(36,	1,	1,	28,	387,	NULL,	'futes',	'2018-11-12 19:52:01',	'2018-11-12 19:52:01'),
(37,	1,	1,	43,	114000,	NULL,	'apa',	'2018-11-12 19:47:08',	'2018-11-12 19:47:08'),
(38,	1,	1,	20,	750,	NULL,	'',	'2018-11-12 17:41:28',	'2018-11-12 17:41:28'),
(39,	1,	1,	22,	5457,	NULL,	'alkohol',	'2018-11-10 18:07:39',	'2018-11-10 18:07:39'),
(40,	1,	1,	20,	2160,	NULL,	'meal',	'2018-11-10 11:49:26',	'2018-11-10 11:49:26'),
(41,	1,	1,	22,	1730,	NULL,	'food',	'2018-11-09 18:11:44',	'2018-11-09 18:11:44'),
(42,	1,	1,	28,	3388,	NULL,	'mobil',	'2018-11-08 18:15:33',	'2018-11-08 18:15:33'),
(43,	1,	1,	28,	7837,	NULL,	'aram',	'2018-11-08 18:14:59',	'2018-11-08 18:14:59'),
(44,	1,	1,	20,	6000,	NULL,	'meal',	'2018-11-06 18:02:27',	'2018-11-06 18:02:27'),
(45,	1,	1,	20,	140,	NULL,	'water',	'2018-11-05 08:00:11',	'2018-11-05 08:00:11'),
(46,	1,	1,	21,	250,	NULL,	'',	'2018-11-04 20:22:24',	'2018-11-04 20:22:24'),
(47,	1,	1,	20,	100,	NULL,	'water',	'2018-11-01 15:25:15',	'2018-11-01 15:25:15'),
(48,	1,	1,	21,	235,	NULL,	'',	'2018-11-01 15:25:06',	'2018-11-01 15:25:06'),
(49,	1,	1,	20,	500,	'kenyer',	'food',	'2018-11-06 17:17:58',	'2018-11-06 17:17:58'),
(50,	1,	1,	20,	730,	'2 szendvics + viz',	'food,reggeli',	'2018-11-09 08:00:21',	'2018-11-09 08:00:21'),
(51,	1,	1,	22,	2820,	'900 kancso 500 shottok 420 sor',	'',	'2018-11-30 11:35:06',	'2018-11-30 11:35:06'),
(52,	1,	1,	35,	23950,	NULL,	'osztondij',	'2018-11-12 19:46:55',	'2018-11-12 19:46:55'),
(53,	1,	1,	39,	156070,	NULL,	'',	'2018-11-09 17:55:11',	'2018-11-09 17:55:11');

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Test Elek',	'test@gmail.com',	NULL,	'$2y$10$JsJlbLdXUpGFXZI8TQuLiOYA7b5LpGnJ0Y5LcxlZKVg5p9LMpScVC',	'L3emX8SBKrmF9L6OT51lldfWBHja0gfYPv18m1UtmdOhr6uD8lJLmDkBkW8x',	NULL,	NULL),
(2,	'Dayle',	'daylee@gmail.com',	NULL,	'$2y$10$5LlMnQ11g1UWuqju.TtVAegMN3XBI9I6Ikx4GR4vSG21457UND5ty',	NULL,	NULL,	NULL),
(3,	'Test Name',	'test.name@gmail.com',	NULL,	'$2y$10$XDhy0pC7hjBuAyNuOUYVaOfK6sBbip4QxWfQ94xKbw85jlsxIBVFK',	NULL,	NULL,	NULL),
(5,	'Mary Joe',	'mary.joe@gmail.com',	NULL,	'$2y$10$QKi1iiTF1CCdhJ4m7MMEaOivzHgOu3CQQ/fx5YXPPoJjwKfB//Wiy',	NULL,	'2018-11-16 06:10:53',	'2018-11-16 06:10:53');

INSERT INTO `wallet` (`id`, `user_id`, `balance`, `name`) VALUES
(1,	1,	220496,	'Base'),
(3,	5,	0,	'Main Wallet');

-- 2018-11-24 16:45:26
