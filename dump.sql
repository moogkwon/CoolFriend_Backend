-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: coolfriend_admin
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `airdrop_submits`
--

DROP TABLE IF EXISTS `airdrop_submits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airdrop_submits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `note` text,
  `campaign_id` int(11) NOT NULL,
  `score` int(11) DEFAULT '0',
  `message` text,
  `status` int(11) DEFAULT NULL COMMENT '-1:Rejected 0:Pending 1:Approved.',
  `created_at` datetime DEFAULT NULL COMMENT 'created datetime',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airdrop_submits`
--

LOCK TABLES `airdrop_submits` WRITE;
/*!40000 ALTER TABLE `airdrop_submits` DISABLE KEYS */;
INSERT INTO `airdrop_submits` VALUES (1,130,'http://facebook.com','This is Awesome!',1,50,'ffdgfdg',1,'2018-06-16 17:25:25'),(2,130,'http://twiter',NULL,1,150,'ffdgfdg',1,'2018-06-16 17:25:49'),(3,132,'http://here',NULL,1,100,'adskfjsadlkfjaslkdfjlasdf\nsadf\n\ndsafasdf',-1,'2018-06-16 17:26:05'),(21,130,NULL,'Affiliate one user',0,100,NULL,1,'2018-06-18 19:35:23'),(22,130,NULL,'Affiliate one user',0,100,NULL,1,'2018-06-18 19:35:32'),(23,130,NULL,'Affiliate one user',0,100,NULL,1,'2018-06-18 19:59:55'),(27,130,'https://t.me/Blockchain_io','adsfdsf',1,50,' ',0,'2018-06-18 15:44:36'),(28,130,'https://t.me/Blockchain_io_channel','asdfasdfgggggggg\r\ndfg\r\ndf\r\ngsdfg',2,500,' adfsdfasdf\ndsaf\nasd\nf',1,'2018-06-18 16:00:56'),(29,130,'https://t.me/Blockchain_io_channel','dsaf',2,500,' ',0,'2018-06-18 16:09:14'),(30,130,'https://t.me/Blockchain_io','sdfg',1,50,' ',0,'2018-06-18 16:09:17'),(31,130,'https://www.reddit.com/r/blockchainio/comments/8fbgzo/welcome_to_the_internet_of_value/','hgf',5,50,' ',0,'2018-06-18 16:09:20'),(32,130,'https://bitcointalk.org/index.php?topic=3681257.0','asdf',8,50,' ',0,'2018-06-18 16:09:24'),(33,133,'https://t.me/Blockchain_io','adfsdfsdf',1,50,' ',0,'2018-06-18 18:21:09'),(34,133,'https://t.me/Blockchain_io_channel','gfgfg',2,500,' ',0,'2018-06-18 18:21:13'),(35,153,'https://t.me/Blockchain_io','',1,50,' ',0,'2018-06-20 07:15:36'),(36,153,'https://t.me/Blockchain_io','',1,50,' ',0,'2018-06-20 07:15:39'),(37,153,'https://t.me/Blockchain_io','',1,50,' ',0,'2018-06-20 07:15:40'),(38,153,'https://t.me/Blockchain_io','',6,500,' ',0,'2018-06-20 07:15:43'),(39,153,'https://t.me/Blockchain_io','',6,500,' ',0,'2018-06-20 07:15:45'),(40,153,'https://www.reddit.com/r/blockchainio/comments/8fbgzo/welcome_to_the_internet_of_value/','',5,50,' ',0,'2018-06-20 07:15:48');
/*!40000 ALTER TABLE `airdrop_submits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airdrop_transaction`
--

DROP TABLE IF EXISTS `airdrop_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airdrop_transaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT '0' COMMENT 'Processed Score',
  `amount` double DEFAULT '0' COMMENT 'Ethereum Amount',
  `transaction_id` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airdrop_transaction`
--

LOCK TABLES `airdrop_transaction` WRITE;
/*!40000 ALTER TABLE `airdrop_transaction` DISABLE KEYS */;
INSERT INTO `airdrop_transaction` VALUES (1,130,30,30,'123123222','2018-06-18 15:38:09');
/*!40000 ALTER TABLE `airdrop_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airdrop_user_info`
--

DROP TABLE IF EXISTS `airdrop_user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airdrop_user_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `telegram` varchar(256) DEFAULT NULL,
  `bitcointalk` varchar(256) DEFAULT NULL,
  `linkedin` varchar(256) DEFAULT NULL,
  `reddit` varchar(256) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `total_score` int(11) DEFAULT '0',
  `sent_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airdrop_user_info`
--

LOCK TABLES `airdrop_user_info` WRITE;
/*!40000 ALTER TABLE `airdrop_user_info` DISABLE KEYS */;
INSERT INTO `airdrop_user_info` VALUES (1,130,NULL,NULL,NULL,NULL,NULL,NULL,930,250),(2,132,NULL,NULL,NULL,NULL,NULL,NULL,400,100),(3,133,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(4,134,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(5,135,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(6,137,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(7,138,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(8,141,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(9,142,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(10,143,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(11,144,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(12,145,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(13,146,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(14,147,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(15,148,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(16,150,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(17,151,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(18,152,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(19,153,'123asdfasd','123555666','123555666','123asdf5555','20180620181537.jpg','123asdfasdfasdfasdf',0,NULL),(20,154,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(21,155,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(22,157,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(23,158,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(24,159,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(25,160,'','','','','20180620211022.jpg','',0,NULL),(26,161,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(27,165,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `airdrop_user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_call_history`
--

DROP TABLE IF EXISTS `tbl_call_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_call_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('random','selective') NOT NULL,
  `caller_id` int(11) NOT NULL,
  `callee_id` int(11) NOT NULL,
  `connected_at` varchar(50) NOT NULL,
  `end_at` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_call_history`
--

LOCK TABLES `tbl_call_history` WRITE;
/*!40000 ALTER TABLE `tbl_call_history` DISABLE KEYS */;
INSERT INTO `tbl_call_history` VALUES (1,'random',1,6,'2018-10-15 12:18:21','2018-10-15 12:18:21','10:00:00');
/*!40000 ALTER TABLE `tbl_call_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_config`
--

DROP TABLE IF EXISTS `tbl_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_config` (
  `config_key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_config`
--

LOCK TABLES `tbl_config` WRITE;
/*!40000 ALTER TABLE `tbl_config` DISABLE KEYS */;
INSERT INTO `tbl_config` VALUES ('2checkout_private_key','privatekey'),('2checkout_publishable_key','checkoutkey'),('2checkout_seller_id','seled id'),('2checkout_status','active'),('90D0R06YX3XCQ0ME','0'),('about_company','A breakthrough digital solution involving currency trading helps to replace the world.'),('accounting_snapshot','1'),('admin_btc_address',''),('admin_btc_email',''),('admin_btc_guid',''),('admin_btc_password',''),('admin_eth_pkey',''),('advcash_api_name',''),('advcash_api_password',''),('advcash_email',''),('advcash_sci_batch_key',''),('advcash_sci_name',''),('advcash_status','0'),('advcash_withdraw_email',''),('allowed_files','gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4'),('allow_client_registration','TRUE'),('authorize','login id'),('authorize_status','active'),('authorize_transaction_key','transfer key'),('automatic_email_on_recur','TRUE'),('bank_address','Bank Address'),('bank_cash','0'),('bank_city','Bank City'),('bank_country','Bank Country'),('bank_state_province','Bank State/Province'),('bank_wire_status','0'),('bank_zip_code','Bank Zip/Postal Code'),('beneficiary_bank_name','Beneficiary Bank Name'),('benificiary_account_number','Benificiary Account Number'),('bitcoin_address','Bitcoin Address'),('bitcoin_comments',''),('bitcoin_merchant_id',''),('bitcoin_private_key',''),('bitcoin_public_key',''),('bitcoin_selectmode','1'),('bitcoin_status','1'),('bitcoin_title','Bitcoin'),('braintree_default_account','Braintree Defual allcount'),('braintree_live_or_sandbox','Braintree Live or Sandbox'),('braintree_merchant_id','Braintree Merchant ID'),('braintree_private_key','Braintree Private Key'),('braintree_public_key','Braintree Defual allcount'),('braintree_status','active'),('btc_address',''),('btc_code','0'),('btc_link','0'),('btc_transaction_fees','0.0005'),('build','0'),('captcha_in_contact','1'),('captcha_in_login','1'),('captcha_in_reg','1'),('ccavenue_key','CCAvenue Working Key'),('ccavenue_merchant_id','CCAvenue Merchant ID'),('ccavenue_status','active'),('coin','BTC'),('coin_payments_ipn_key',''),('coin_payments_status','0'),('company_address','Address'),('company_city','3463464634563456'),('company_country','Hong Kong'),('company_domain','Dutertecoin'),('company_email','support@bitnami.network'),('company_legal_name','Dutertecoin'),('company_logo','uploads/7932101aac7b4ccd84b47a4839c3cc29.jpg'),('company_name','Dutertecoin'),('company_phone','gadfgdgsdgsdfgsdfgdfgsdgdfg'),('company_phone_2',''),('company_start','2016-06-30'),('company_vat','sdfgsdfg'),('company_zip_code','sdfgdgsdgdgsdgsdg'),('contact_person','463463463463456435634563456'),('contract_abi','[{\"constant\":true,\"inputs\":[{\"name\":\"\",\"type\":\"address\"}],\"name\":\"withdrawalRequests\",\"outputs\":[{\"name\":\"sinceTime\",\"type\":\"uint256\"},{\"name\":\"amount\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"version\",\"outputs\":[{\"name\":\"\",\"type\":\"string\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[{\"name\":\"\",\"type\":\"address\"}],\"name\":\"balanceOf\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[{\"name\":\"v\",\"type\":\"uint256\"}],\"name\":\"calculateReward\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"totalSupply\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[{\"name\":\"\",\"type\":\"address\"},{\"name\":\"\",\"type\":\"address\"}],\"name\":\"allowance\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"symbol\",\"outputs\":[{\"name\":\"\",\"type\":\"string\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"decimals\",\"outputs\":[{\"name\":\"\",\"type\":\"uint8\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"name\",\"outputs\":[{\"name\":\"\",\"type\":\"string\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"initialSupply\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"feePot\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[],\"name\":\"timeWait\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"constant\":true,\"inputs\":[{\"name\":\"v\",\"type\":\"uint256\"}],\"name\":\"calculateFee\",\"outputs\":[{\"name\":\"\",\"type\":\"uint256\"}],\"payable\":false,\"stateMutability\":\"view\",\"type\":\"function\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"amount\",\"type\":\"uint256\"}],\"name\":\"WithdrawalStarted\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"_owner\",\"type\":\"address\"},{\"indexed\":true,\"name\":\"_spender\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"_value\",\"type\":\"uint256\"}],\"name\":\"Approval\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"amount\",\"type\":\"uint256\"},{\"indexed\":false,\"name\":\"fee\",\"type\":\"uint256\"}],\"name\":\"WithdrawalQuick\",\"type\":\"event\"},{\"constant\":false,\"inputs\":[],\"name\":\"quickWithdraw\",\"outputs\":[{\"name\":\"\",\"type\":\"bool\"}],\"payable\":true,\"stateMutability\":\"payable\",\"type\":\"function\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"timeToWait\",\"type\":\"uint256\"}],\"name\":\"WithdrawalPremature\",\"type\":\"event\"},{\"constant\":false,\"inputs\":[],\"name\":\"withdrawalInitiate\",\"outputs\":[],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"amount\",\"type\":\"uint256\"},{\"indexed\":false,\"name\":\"reward\",\"type\":\"uint256\"}],\"name\":\"WithdrawalDone\",\"type\":\"event\"},{\"constant\":false,\"inputs\":[{\"name\":\"_from\",\"type\":\"address\"},{\"name\":\"_to\",\"type\":\"address\"},{\"name\":\"_value\",\"type\":\"uint256\"}],\"name\":\"transferFrom\",\"outputs\":[{\"name\":\"success\",\"type\":\"bool\"}],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"constant\":false,\"inputs\":[{\"name\":\"_spender\",\"type\":\"address\"},{\"name\":\"_value\",\"type\":\"uint256\"}],\"name\":\"approve\",\"outputs\":[{\"name\":\"success\",\"type\":\"bool\"}],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"amount\",\"type\":\"uint256\"}],\"name\":\"Deposited\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"by\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"feeRequired\",\"type\":\"uint256\"}],\"name\":\"IncorrectFee\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"name\":\"from\",\"type\":\"address\"},{\"indexed\":true,\"name\":\"to\",\"type\":\"address\"},{\"indexed\":false,\"name\":\"value\",\"type\":\"uint256\"}],\"name\":\"Transfer\",\"type\":\"event\"},{\"payable\":true,\"stateMutability\":\"payable\",\"type\":\"fallback\"},{\"constant\":false,\"inputs\":[],\"name\":\"withdrawalComplete\",\"outputs\":[{\"name\":\"\",\"type\":\"bool\"}],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"constant\":false,\"inputs\":[{\"name\":\"_spender\",\"type\":\"address\"},{\"name\":\"_value\",\"type\":\"uint256\"},{\"name\":\"_extraData\",\"type\":\"bytes\"}],\"name\":\"approveAndCall\",\"outputs\":[{\"name\":\"success\",\"type\":\"bool\"}],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"name\":\"tokenName\",\"type\":\"string\"},{\"name\":\"decimalUnits\",\"type\":\"uint8\"},{\"name\":\"tokenSymbol\",\"type\":\"string\"}],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"constructor\"},{\"constant\":false,\"inputs\":[{\"name\":\"_to\",\"type\":\"address\"},{\"name\":\"_value\",\"type\":\"uint256\"}],\"name\":\"transfer\",\"outputs\":[],\"payable\":false,\"stateMutability\":\"nonpayable\",\"type\":\"function\"}]'),('contract_address','0x3b5d497c699a05eb94380d8382b958dbf16e7be4'),('contract_live','1'),('contract_token_decimal','0'),('country','0'),('country_in_reg','0'),('cron_key','34WI2L12L87I1A65M90M9A42N41D08A26I'),('date_format','%d-%m-%Y'),('date_php_format','d-m-Y'),('date_picker_format','dd-mm-yyyy'),('decimal_separator','0'),('default_currency','0'),('default_currency_symbol','$'),('default_language','0'),('default_tax','0'),('default_terms','Thank you for <span style=\"font-weight: bold;\">your</span> business. Please process this invoice within the due date.'),('demo_mode','FALSE'),('developer','ig63Yd/+yuA8127gEyTz9TY4pnoeKq8dtocVP44+BJvtlRp8Vqcetwjk51dhSB6Rx8aVIKOPfUmNyKGWK7C/gg=='),('display_estimate_badge','0'),('display_invoice_badge','FALSE'),('email_account_details','TRUE'),('email_estimate_message','Hi {CLIENT}<br>Thanks for your business inquiry. <br>The estimate EST {REF} is attached with this email. <br>Estimate Overview:<br>Estimate # : EST {REF}<br>Amount: {CURRENCY} {AMOUNT}<br> You can view the estimate online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),('email_invoice_message','Hello {CLIENT}<br>Here is the invoice of {CURRENCY} {AMOUNT}<br>You can view the invoice online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),('email_staff_tickets','TRUE'),('enable_languages','0'),('envelope_link','sfdgdfgsdfgdfhdfhdfh'),('estimate_color','0'),('estimate_language','en'),('estimate_prefix','EST'),('estimate_terms','Hey Looking forward to doing business with you.'),('eth_address','0x746b9ad455a716c9fcc7d01ac5556466a950ea0a'),('eth_transaction_fees','0'),('exchange_disable_message','test'),('exchange_enable','1'),('facebook_link','sfgs'),('file_max_size','80000'),('gcal_api_key',''),('gcal_id',''),('google_captcha_key','6LekjVAUAAAAACql65A6NR0c4WSifQX06HpoRK6i'),('google_link','sdfgsdfgsd'),('ico_enabled','1'),('ico_message','<p>Coming soon..</p>\n'),('increment_invoice_number','TRUE'),('instagram_link','https://www.instagram.com/explore/tags/ecove/'),('installed','TRUE'),('invoices_due_after','10'),('invoice_color','#53B567'),('invoice_language','en'),('invoice_logo','uploads/thumb.png'),('invoice_prefix','INV-'),('invoice_start_no','0'),('language','english'),('languages','spanish'),('last_check','1436363002'),('last_seen_activities','0'),('linkedin_link','sdfgsdfgsdg'),('lisence_key','ooaPgynNvCtzs3ic2tIzRsMKOlaGaMn6A5aPMi0nlEejYBevadUSJDDXO6CS1Q7CWhrJAs6V7ke5WsB6GvZp9CmYIZRKQYmMgOwQgDMnY0sUt31az1AJDXHmWy7MxtzNh'),('locale','en_IN'),('login_bg','bg-login.jpg'),('logofile','0'),('logo_or_icon','0'),('medium_link','dgsdfgsdfg'),('notify_bug_assignment','TRUE'),('notify_bug_comments','TRUE'),('notify_bug_status','TRUE'),('notify_message_received','TRUE'),('notify_project_assignments','TRUE'),('notify_project_comments','TRUE'),('notify_project_files','TRUE'),('notify_task_assignments','TRUE'),('paper_plane_link','sdfgsdfgsdf'),('payeer_account',''),('payeer_api_secret',''),('payeer_api_user',''),('payeer_shop_id',''),('payeer_shop_secret_key',''),('payeer_status','0'),('paypal_cancel_url','paypal/cancel'),('paypal_email','support@bitnami.network'),('paypal_ipn_url','paypal/t_ipn/ipn'),('paypal_live','TRUE'),('paypal_status','active'),('paypal_success_url','paypal/success'),('pdf_engine','invoicr'),('perfect_money_account_id',''),('perfect_money_member_id',''),('perfect_money_phrase_hash',''),('perfect_money_status','0'),('postmark_api_key','0'),('postmark_from_address','0'),('project_prefix','PRO'),('protocol','0'),('purchase_code',''),('recurring_invoice','1'),('reddit_link','sdfgsdfgsdfg'),('ref_level_1','0.05'),('ref_level_2','0.03'),('ref_level_3','0'),('ref_level_4','0'),('ref_level_5','0'),('reminder_message','Hello {CLIENT}<br>This is a friendly reminder to pay your invoice of {CURRENCY} {AMOUNT}<br>You can view the invoice online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),('reset_key','34WI2L12L87I1A65M90M9A42N41D08A26I'),('routing_transfer_number','Routing Transfer Number (or) SWIFT Code (BIC)'),('rows_per_table','25'),('security_token','5027133599'),('settings','theme'),('show_estimate_tax','on'),('show_invoice_tax','TRUE'),('show_item_tax','0'),('show_login_image','TRUE'),('show_only_logo','FALSE'),('sidebar_theme','purple'),('site_appleicon','logo.png'),('site_author','William M.'),('site_desc','Freelancer Office is a Web based PHP application for Freelancers - buy it on Codecanyon'),('site_favicon','logo.png'),('site_icon','fa-flask'),('site_token_name','DU30'),('site_token_short_name','DU30'),('slack_link','sdfgsdfgfg'),('smtp_host','0'),('smtp_pass','Dutertecoin123'),('smtp_port','0'),('smtp_user','0'),('stripe_private_key','pk_test_ARblMczqDw61NusMMs7o1RVK'),('stripe_public_key','pk_test_ARblMczqDw61NusMMs7o1RVK'),('stripe_status','active'),('system_font','roboto_condensed'),('telegram','https://telegram.me/viccoin'),('telegram_link','sfgsdfgsdfg'),('thousand_separator',','),('timezone','America/New_York'),('twitter_link','sdfgsdfgsdfg'),('use_gravatar','TRUE'),('use_mailgun','false'),('use_postmark','0'),('valid_license','TRUE'),('webmaster_email','support@bitnami.network'),('website_name','Dutertecoin'),('withdraw_allow_month','4'),('withdraw_commission','5'),('withdraw_maximum','1000'),('withdraw_minimum','100'),('X13RMT9FRC679GIR','2018-04-04 14:20:07'),('youtube_link','sdgsdfgsdg');
/*!40000 ALTER TABLE `tbl_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_email_templates`
--

DROP TABLE IF EXISTS `tbl_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_email_templates` (
  `email_templates_id` int(11) NOT NULL,
  `email_group` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template_body` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_email_templates`
--

LOCK TABLES `tbl_email_templates` WRITE;
/*!40000 ALTER TABLE `tbl_email_templates` DISABLE KEYS */;
INSERT INTO `tbl_email_templates` VALUES (1,'registration','Registration successful','<div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Welcome to {SITE_NAME}</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">Thanks for joining {SITE_NAME}. We listed your sign in details below, make sure you keep them safe.<br>To open your {SITE_NAME} homepage, please follow this link:<br><big><b><a href=\"{SITE_URL}\">{SITE_NAME} Account!</a></b></big><br>Link doesn\'t work? Copy the following link to your browser address bar:<br><a href=\"{SITE_URL}\">{SITE_URL}</a><br>Your username: {USERNAME}<br>Your email address: {EMAIL}<br>Your password: {PASSWORD}<br>Have fun!<br>The {SITE_NAME} Team.<br><br></div></div>'),(2,'forgot_password','Forgot Password','        <div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">New Password</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">Forgot your password, huh? No big deal.<br>To create a new password, just follow this link:<br><br><big><b><a href=\"{PASS_KEY_URL}\">Create a new password</a></b></big><br>Link doesn\'t work? Copy the following link to your browser address bar:<br><a href=\"{PASS_KEY_URL}\">{PASS_KEY_URL}</a><br><br><br>You received this email, because it was requested by a <a href=\"{SITE_URL}\">{SITE_NAME}</a> user. <p></p><p>This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.</p><br>Thank you,<br>The {SITE_NAME} Team</div></div>'),(3,'change_email','Change Email','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">New email address on {SITE_NAME}</div>\r\n\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">You have changed your email address for {SITE_NAME}.<br>Follow this link to confirm your new email address:<br><big><b><a href=\"{NEW_EMAIL_KEY_URL}\">Confirm your new email</a></b></big><br>Link doesn\'t work? Copy the following link to your browser address bar:<br><a href=\"{NEW_EMAIL_KEY_URL}\">{NEW_EMAIL_KEY_URL}</a><br><br>Your email address: {NEW_EMAIL}<br><br>You received this email, because it was requested by a <a href=\"{SITE_URL}\">{SITE_NAME}</a> user. If you have received this by mistake, please DO NOT click the confirmation link, and simply delete this email. After a short time, the request will be removed from the system.<br>Thank you,<br>The {SITE_NAME} Team</div>\r\n\r\n</div>'),(4,'activate_account','Activate Account','<p>Welcome to {SITE_NAME}!</p>\r\n\r\n<p>Thanks for joining {SITE_NAME}. We listed your sign in details below, make sure you keep them safe.</p>\r\n\r\n<p>To verify your email address, please follow this link:<br />\r\n<big><strong><a href=\"{ACTIVATE_URL}\">Finish your registration...</a></strong></big><br />\r\nLink doesn&#39;t work? Copy the following link to your browser address bar:<br />\r\n<a href=\"{ACTIVATE_URL}\">{ACTIVATE_URL}</a></p>\r\n\r\n<p><br />\r\n<br />\r\n<br />\r\nYour username: {USERNAME}<br />\r\nYour email address: {EMAIL}<br />\r\nYour password: {PASSWORD}<br />\r\n<br />\r\nHave fun!<br />\r\nThe {SITE_NAME} Team</p>'),(5,'reset_password','Reset Password','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">New password on {SITE_NAME}</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>You have changed your password.<br>Please, keep it in your records so you don\'t forget it.<br></p>\r\nYour username: {USERNAME}<br>Your email address: {EMAIL}<br>Your new password: {NEW_PASSWORD}<br><br>Thank you,<br>The {SITE_NAME} Team</div>\r\n</div>'),(6,'bug_assigned','New Bug Assigned','<p>Hi there,</p>\r\n\r\n<p>A new bug &nbsp;{BUG_TITLE} &nbsp;has been assigned to you by {ASSIGNED_BY}.</p>\r\n\r\n<p>You can view this bug by logging in to the portal using the link below.</p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{BUG_URL}\">View Bug</a></strong></big><br />\r\n<br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(7,'bug_updated','Bug status changed','<p>Hi there,</p>\r\n\r\n<p>Bug {BUG_TITLE} has been marked as {STATUS} by {MARKED_BY}.</p>\r\n\r\n<p>You can view this bug by logging in to the portal using the link below.</p>\r\n\r\n<p><big><strong><a href=\"{BUG_URL}\">View Bug</a></strong></big><br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(8,'bug_comments','New Bug Comment Received','<p>Hi there,</p>\r\n\r\n<p>A new comment has been posted by {POSTED_BY} to bug {BUG_TITLE}.</p>\r\n\r\n<p>You can view the comment using the link below.</p>\r\n\r\n<p><em>{COMMENT_MESSAGE}</em></p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{COMMENT_URL}\">View Comment</a></strong></big><br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(9,'bug_attachment','New bug attachment','<p>Hi there,</p>\r\n\r\n<p>A new attachment&nbsp;has been uploaded by {UPLOADED_BY} to issue {BUG_TITLE}.</p>\r\n\r\n<p>You can view the bug using the link below.</p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{BUG_URL}\">View Bug</a></strong></big></p>\r\n\r\n<p><br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(10,'bug_reported','New bug Reported','<p>Hi there,</p>\r\n\r\n<p>A new bug ({BUG_TITLE}) has been reported by {ADDED_BY}.</p>\r\n\r\n<p>You can view the Bug using the Dashboard Page.</p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{BUG_URL}\">View Bug</a></strong></big></p>\r\n\r\n<p><br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(13,'refund_confirmation','Refund Confirmation','<p>Refund Confirmation</p>\r\n\r\n<p>Hello {CLIENT}</p>\r\n\r\n<p>This is confirmation that a refund has been processed for Invoice&nbsp; of {CURRENCY} {AMOUNT}&nbsp;sent on {INVOICE_DATE}.<br />\r\nYou can view the invoice online at:<br />\r\n<big><strong><a href=\"{INVOICE_LINK}\">View Invoice</a></strong></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(14,'payment_confirmation','Payment Confirmation','<p>Payment Confirmation</p>\r\n\r\n<p>Hello {CLIENT}</p>\r\n\r\n<p>This is a payment receipt for your invoice of {CURRENCY} {AMOUNT}&nbsp;sent on {INVOICE_DATE}.<br />\r\nYou can view the invoice online at:<br />\r\n<big><strong><a href=\"{INVOICE_LINK}\">View Invoice</a></strong></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(15,'payment_email','Payment Received','<div style=\"height: 7px; background-color: #535353;\"></div>\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Payment Received</div>\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Dear Customer</p>\n<p>We have received your payment of {INVOICE_CURRENCY} {PAID_AMOUNT}. </p>\n<p>Thank you for your Payment and business. We look forward to working with you again.</p>\n--------------------------<br>Regards<br>The {SITE_NAME} Team</div>\n</div>'),(16,'invoice_overdue_email','Invoice Overdue Notice','<p>Invoice Overdue</p>\r\n\r\n<p>INVOICE {REF}</p>\r\n\r\n<p><strong>Hello {CLIENT}</strong></p>\r\n\r\n<p>This is the notice that your invoice overdue.&nbsp;The invoice {CURRENCY} {AMOUNT}. and Due Date: {DUE_DATE}</p>\r\n\r\n<p>You can view the invoice online at:<br />\r\n<big><strong><a href=\"{INVOICE_LINK}\">View Invoice</a></strong></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(17,'invoice_message','New Invoice','<div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">INVOICE {REF}</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><span class=\"style1\"><span style=\"font-weight:bold;\">Hello {CLIENT}</span></span><br><br>Here is the invoice of {CURRENCY} {AMOUNT}.<br><br>You can view the invoice online at:<br><big><b><a href=\"{INVOICE_LINK}\">View Invoice</a></b></big><br><br>Best Regards<br><br>The {SITE_NAME} Team</div></div>'),(18,'invoice_reminder','Invoice Reminder','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Invoice Reminder</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Hello {CLIENT}</p>\r\n<br><p>This is a friendly reminder to pay your invoice of {CURRENCY} {AMOUNT}<br>You can view the invoice online at:<br><big><b><a href=\"{INVOICE_LINK}\">View Invoice</a></b></big><br><br>Best Regards,<br>The {SITE_NAME} Team</p>\r\n</div>\r\n</div>'),(19,'message_received','Message Received','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Message Received</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Hi {RECIPIENT},</p>\r\n<p>You have received a message from {SENDER}. </p>\r\n------------------------------------------------------------------<br><blockquote>\r\n{MESSAGE}</blockquote>\r\n<big><b><a href=\"{SITE_URL}\">Go to Account</a></b></big><br><br>Regards<br>The {SITE_NAME} Team</div>\r\n</div>'),(20,'estimate_email','New Estimate','<p>Estimate {ESTIMATE_REF}</p>\r\n\r\n<p>Hi {CLIENT}</p>\r\n\r\n<p>Thanks for your business inquiry.</p>\r\n\r\n<p>The estimate {ESTIMATE_REF} is attached with this email.<br />\r\nEstimate Overview:<br />\r\nEstimate # : {ESTIMATE_REF}<br />\r\nAmount: {CURRENCY} {AMOUNT}<br />\r\n<br />\r\nYou can view the estimate online at:<br />\r\n<big><strong><a href=\"{ESTIMATE_LINK}\">View Estimate</a></strong></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(21,'ticket_staff_email','New Ticket [TICKET_CODE]','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">New Ticket</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Ticket #{TICKET_CODE} has been created by the client.</p>\r\n<p>You may view the ticket by clicking on the following link <br><br>  Client Email : {REPORTER_EMAIL}<br><br> <big><b><a href=\"{TICKET_LINK}\">View Ticket</a></b></big> <br><br>Regards<br><br>{SITE_NAME}</p>\r\n</div>\r\n</div>'),(22,'ticket_client_email','Ticket [TICKET_CODE] Opened','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Ticket Opened</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Hello {CLIENT_EMAIL},<br><br></p>\r\n<p>Your ticket has been opened with us.<br><br>Ticket #{TICKET_CODE}<br>Status : Open<br><br>Click on the below link to see the ticket details and post additional comments.<br><br><big><b><a href=\"{TICKET_LINK}\">View Ticket</a></b></big><br><br>Regards<br><br>The {SITE_NAME} Team<br></p>\r\n</div>\r\n</div>'),(23,'ticket_reply_email','Ticket [TICKET_CODE] Response','<div style=\"height: 7px; background-color: #535353;\"></div>\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Ticket Response</div>\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>A new response has been added to Ticket #{TICKET_CODE}<br><br> Ticket : #{TICKET_CODE} <br>Status : {TICKET_STATUS} <br><br></p>\nTo see the response and post additional comments, click on the link below.<br><br>         <big><b><a href=\"{TICKET_LINK}\">View Reply</a> </b></big><br><br>          Note: Do not reply to this email as this email is not monitored.<br><br>     Regards<br>The {SITE_NAME} Team<br></div>\n</div>'),(24,'ticket_closed_email','Ticket [TICKET_CODE] Closed','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Ticket Closed</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">Hi {REPORTER_EMAIL}<br><br>Ticket #{TICKET_CODE} has been closed by {STAFF_USERNAME} <br><br>          Ticket : #{TICKET_CODE} <br>     Status : {TICKET_STATUS}<br><br>Replies : {NO_OF_REPLIES}<br><br>          To see the responses or open the ticket, click on the link below.<br><br>          <big><b><a href=\"{TICKET_LINK}\">View Ticket</a></b></big> <br><br>          Note: Do not reply to this email as this email is not monitored.<br><br>    Regards<br>The {SITE_NAME} Team</div>\r\n</div>'),(26,'task_updated','Task updated','<div style=\"height: 7px; background-color: #535353;\"></div>\r\n<div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Task updated</div>\r\n<div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Hi there,</p>\r\n<p>{TASK_NAME} in {PROJECT_TITLE} has been updated by {ASSIGNED_BY}.</p>\r\n<p>You can view this project by logging in to the portal using the link below.</p>\r\n-----------------------------------<br><big><b><a href=\"{PROJECT_URL}\">View Project</a></b></big><br><br>Regards<br>The {SITE_NAME} Team</div>\r\n</div>'),(27,'quotations_form','Your Quotation Request','<p>QUOTATION</p>\r\n\r\n<p><strong>Hello {CLIENT}</strong><br />\r\n&nbsp;</p>\r\n\r\n<p>Thank you for you for filling in our Quotation Request Form.<br />\r\n<br />\r\nPlease find below are our quotation:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table cellpadding=\"8\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Quotation Date</td>\r\n			<td><strong>{DATE}</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>Our Quotation</td>\r\n			<td><strong>{CURRENCY} {AMOUNT}</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>Addtitional Comments</td>\r\n			<td><strong>{NOTES}</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><br />\r\nYou can view the estimate online at:<br />\r\n<big><strong><a href=\"{QUOTATION LINK}\">View Quotation</a></strong></big></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\nThank you and we look forward to working with you.<br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(28,'client_notification','New project created','<p>Hello, <strong>{CLIENT_NAME}</strong>,<br />\r\nwe have created a new project with your account.<br />\r\n<br />\r\nProject name : <strong>{PROJECT_NAME}</strong><br />\r\nYou can login to see the status of your project by using this link:<br />\r\n<big><a href=\"{PROJECT_LINK}\"><strong>View Project</strong></a></big></p>\r\n\r\n<p><br />\r\nBest Regards<br />\r\n<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(29,'assigned_project','Assigned Project','<p>Hi There,</p>\r\n\r\n<p>A<strong> {PROJECT_NAME}</strong> has been assigned by <strong>{ASSIGNED_BY} </strong>to you.You can view this project by logging in to the portal using the link below:<br />\r\n<big><a href=\"{PROJECT_URL}\"><strong>View Project</strong></a></big><br />\r\n<br />\r\nBest Regards<br />\r\nThe {SITE_NAME} Team</p>\r\n\r\n<p>&nbsp;</p>\r\n'),(30,'complete_projects','Project Completed','<p>Hi <strong>{CLIENT_NAME}</strong>,</p>\r\n\r\n<p>Project : <strong>{PROJECT_NAME}</strong> &nbsp;has been completed.<br />\r\nYou can view the project by logging into your portal Account:<br />\r\n<big><a href=\"{PROJECT_LINK}\"><strong>View Project</strong></a></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(31,'project_comments','New Project Comment Received','<p>Hi There,</p>\r\n\r\n<p>A new comment has been posted by <strong>{POSTED_BY}</strong> to project <strong>{PROJECT_NAME}</strong>.</p>\r\n\r\n<p>You can view the comment using the link below:<br />\r\n<big><a href=\"{COMMENT_URL}\"><strong>View Project</strong></a></big><br />\r\n<br />\r\n<em>{COMMENT_MESSAGE}</em><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(32,'project_attachment','New Project  Attachment','<p>Hi There,</p>\r\n\r\n<p>A new file has been uploaded by <strong>{UPLOADED_BY}</strong> to project <strong>{PROJECT_NAME}</strong>.<br />\r\nYou can view the Project using the link below:<br />\r\n<big><a href=\"{PROJECT_URL}\"><strong>View Project</strong></a></big><br />\r\n<br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(33,'responsible_milestone','Responsible for a Milestone','<p>Hi There,</p>\r\n\r\n<p>You are a responsible&nbsp;for a project milestone&nbsp;<strong>{MILESTONE_NAME}</strong>&nbsp; assigned to you by <strong>{ASSIGNED_BY}</strong> in project <strong>{PROJECT_NAME}</strong>.</p>\r\n\r\n<p>You can view this Milestone&nbsp;by logging in to the portal using the link below:<br />\r\n<big><strong><a href=\"{PROJECT_URL}\">View Project</a></strong></big><br />\r\n<br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(34,'task_assigned','Task assigned','<p>Hi there,</p>\r\n\r\n<p>A new task <strong>{TASK_NAME}</strong> &nbsp;has been assigned to you by <strong>{ASSIGNED_BY}</strong>.</p>\r\n\r\n<p>You can view this task by logging in to the portal using the link below.</p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{TASK_URL}\">View Task</a></strong></big><br />\r\n<br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(35,'tasks_comments','New Task Comment Received','<p>Hi There,</p>\r\n\r\n<p>A new comment has been posted by <strong>{POSTED_BY}</strong> to <strong>{TASK_NAME}</strong>.</p>\r\n\r\n<p>You can view the comment using the link below:<br />\r\n<big><strong><a href=\"{COMMENT_URL}\">View Comment</a></strong></big><br />\r\n<br />\r\n<em>{COMMENT_MESSAGE}</em><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(36,'tasks_attachment','New Tasks Attachment','<p>Hi There,</p>\r\n\r\n<p>A new file has been uploaded by <strong>{UPLOADED_BY} </strong>to Task <strong>{TASK_NAME}</strong>.<br />\r\nYou can view the Task&nbsp;using the link below:</p>\r\n\r\n<p><br />\r\n<big><a href=\"{TASK_URL}\"><strong>View Task</strong></a></big><br />\r\n<br />\r\nBest Regards,<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(37,'tasks_updated','Task updated','<p>Hi there,</p>\r\n\r\n<p>{<strong>TASK_NAME</strong>} has been updated by {<strong>ASSIGNED_BY</strong>}.</p>\r\n\r\n<p>You can view this Task by logging in to the portal using the link below.</p>\r\n\r\n<p><br />\r\n<big><strong><a href=\"{TASK_URL}\">View Task</a></strong></big><br />\r\n<br />\r\nRegards<br />\r\nThe {SITE_NAME} Team</p>\r\n'),(38,'contact_email','A user has contact for you his query','<p>Hello Admin</p>\r\n\r\n<p>There is query from user at&nbsp;{SITE_NAME}.&nbsp;</p>\r\n\r\n<p>Below are the detail of user and about his comment:&nbsp;<br />\r\nEmail: {EMAIL}<br />\r\nSubject : {SUBJECT}<br />\r\nMessage: {MESSAGE}</p>\r\n\r\n<p><br />\r\nHave fun!<br />\r\nThe {SITE_NAME} Team.</p>\r\n'),(39,'withdraw_email_to_admin','A user has sent a withdrawal request of amount ${AMOUNT}.','<p>Hello Admin</p>\r\n\r\n<p>A user has sent a withdrawal request at&nbsp;{SITE_NAME}.&nbsp;</p>\r\n\r\n<p>Below are the detail of withdrawal request:&nbsp;<br />\r\nUser: {USER}<br />\r\nRequest Date: {REQUEST_DATE}<br />\r\nAmount: $ {AMOUNT}<br />\r\nComment: {COMMENT}</p>\r\n\r\n<p><br />\r\nRegards!<br />\r\nThe {SITE_NAME} Team.</p>\r\n'),(40,'withdraw_email_to_user','Admin has approved your withdrawal request of amount ${AMOUNT}.','<p>Hi {USERNAME}</p>\n\n<p>Admin has approved your withdrawal request at&nbsp;{SITE_NAME}.&nbsp; of amount ${AMOUNT}</p>\n\n\n<p><br />\nRegards!<br />\nThe {SITE_NAME} Team.</p>\n'),(41,'new_enquiry','New Enquiry Received ','<p>Hello Admin</p>\n\n<p>You have new Enquiry from {NAME}.Details as follows</p>\n\n<p>Enquiry By - {NAME}<br />\nEnquiry By Email - {EMAIL}<br />\nEnquiry Subject - {SUBJECT}<br />\nEnquiry Message - </p>\n\n<p>{MESSAGE}</p>\n\n<p><br />\nThank you,<br />\nThe {SITE_NAME} Team</p>\n'),(42,'auth_code','2 Factor Authorization Code ','<div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">2 Factor Autorization Code</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">Here following is pincode for this time login. You can use it with in 10 minutes.<br></big><br>User: {USERNAME}<br/>Pincode : {PINCODE}</p><br>Thank you,<br>The {SITE_NAME} Team</div></div>'),(43,'confirm_security_code','Confirm Security Code','<div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">Dear {USERNAME} , <br>Security Code for withdraw BTC on {SITE_NAME}</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\"><p>Please use below security code to confirm withdraw BTC.<br></p>Security Code : {SECURITYCODE}<br><br>Thank you,<br>The {SITE_NAME} Team</div></div>'),(44,'token_sale','Token Confirmation','<p>Dear {USERNAME},</p><p>You have succesfully purchased viccoin tokens. We listed your token details below, make sure you keep them safe.</p><p><br /><br />Token Amount: {TOKENAMOUNT}<br />Address	: {ADDRESS}<br />Total Amount: {TOTALAMOUNT}<br /><br />Have fun!<br />The {SITE_NAME} Team</p>'),(45,'budget_query','Someone is interested in Viccoin!!!','<p>Dear Admin,</p>\n\n<p>Someone is interested in Viccoin!!</p>\n\n<p>The details of user is as following:</p>\n\n<p>Email: {EMAIL}</p>\n\n<p>Amount : {AMOUNT}</p>\n\n<p>User hears about us from : {MEDIA}</p>\n\n<p>&nbsp;</p>\n\n<p>Regards,</p>\n\n<p>{COMPANY_NAME} Team</p>\n\n<p>&nbsp;</p>\n'),(46,'admin_auth_code','2 Factor Authorization Code ','<div style=\"height: 7px; background-color: #535353;\"></div><div style=\"background-color:#E8E8E8; margin:0px; padding:55px 20px 40px 20px; font-family:Open Sans, Helvetica, sans-serif; font-size:12px; color:#535353;\"><div style=\"text-align:center; font-size:24px; font-weight:bold; color:#535353;\">2 Factor Autorization Code</div><div style=\"border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Open Sans, Helvetica, sans-serif; font-size:13px;\">Here following is pincode for this time login.<br></big><br>User: {USERNAME}<br/>Code : {PINCODE}</p><br><br>Thank you,<br>The {SITE_NAME} Team</div></div>');
/*!40000 ALTER TABLE `tbl_email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_payment`
--

DROP TABLE IF EXISTS `tbl_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cup_count` varchar(50) NOT NULL,
  `used_cup` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_payment`
--

LOCK TABLES `tbl_payment` WRITE;
/*!40000 ALTER TABLE `tbl_payment` DISABLE KEYS */;
INSERT INTO `tbl_payment` VALUES (1,6,'50',25,'250','2018-10-15 12:13:58');
/*!40000 ALTER TABLE `tbl_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_report`
--

DROP TABLE IF EXISTS `tbl_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `report` varchar(255) NOT NULL,
  `report_image` varchar(255) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_report`
--

LOCK TABLES `tbl_report` WRITE;
/*!40000 ALTER TABLE `tbl_report` DISABLE KEYS */;
INSERT INTO `tbl_report` VALUES (1,6,1,'sdff','','2018-10-15 12:10:41');
/*!40000 ALTER TABLE `tbl_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `online_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = online 0 = offline ',
  `enable_2_auth` int(11) NOT NULL DEFAULT '0',
  `auth_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_code_time` datetime DEFAULT NULL,
  `btc_wallet` decimal(15,10) DEFAULT NULL,
  `btc_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `btc_guid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `btc_wallet_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_factor_permission` int(11) NOT NULL DEFAULT '0',
  `google_auth_code` text COLLATE utf8_unicode_ci NOT NULL,
  `eth_address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eth_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eth_pkey` text COLLATE utf8_unicode_ci,
  `eth_pubkey` text COLLATE utf8_unicode_ci,
  `eth_balance` decimal(15,10) NOT NULL DEFAULT '0.0000000000',
  `lastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photoUrl` int(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `lgbtq` int(11) NOT NULL,
  `city` int(50) NOT NULL,
  `state` int(50) NOT NULL,
  `country` int(50) NOT NULL,
  `birthday` int(50) NOT NULL,
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `social` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'leoruzin','9e6a5a5fd6ffd32127845bfe94c44f2f58f348276f98ed2e5657e0822c006720362a406b077fbf773f161b97643eb9d39733eb8edd858a898bfd2fe75041db0f','leoruzin1126@hotmail.com',1,1,0,NULL,'ef935fdddfcb1c6b3384eb2c457fbda0','2018-01-31 00:41:07',NULL,NULL,NULL,'2018-06-16 07:31:25','2018-01-10 00:00:00','2018-06-20 09:32:47',1,0,'','0000-00-00 00:00:00',NULL,NULL,NULL,NULL,0,'','0x620aeb38271c181CF3049fcD11b6C04d4d688277','ecove@123','c8df981aa481f50564037f8e9cb4535a464ece3e3321e5b77f49dec8c1862ad9',NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(6,'ecove','17ada7ce7a6a9f01f0aabbb431321d365b01a3e3474f107562e738afbfe0c13abf9ea7ee61e22c990912fd2bc5ef0e4c657b4c82f132bf8e79f6dacb14d3c466','testecove@gmail.com',2,1,0,NULL,NULL,NULL,NULL,NULL,'122.173.130.26','2018-03-29 06:23:21','2018-01-17 04:05:12','2018-03-29 20:23:21',0,0,'','0000-00-00 00:00:00',0.0000000000,'1LKWThzfM8UcW5rkNUEgYgvfGxAp3qj29s','e7bb6669-38bd-4b34-92b5-e6ac230d9a75','MTIzNDU2',0,'AZGAYL3G6VAXURGM','0x8f4E6245B110148552DcDbc18D073E416a0E1b87','ecove@123','81afaa5b02ef7326d7b79ca0b4c61331fb0feef470f2d6601587278144ce3c3e',NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(130,'leosuzin','01b0611a3c394d8ad4135ffa6883e63c7f965111543b0bc517b2a6343cf75003e1323e0429fcc12608c202110a9121a65a5cf97beb0e746ab520bf4bcb4f5591','leosuzin1126@gmail.com',2,1,0,NULL,NULL,NULL,NULL,NULL,'0','2018-06-07 11:22:14','2018-04-02 15:04:30','2018-06-08 02:13:11',1,0,NULL,NULL,0.0000000000,'14bQT1T99kiJWWYPmyt6L85a4TLDifFuXz','210c2414-78ca-4426-87b7-da72a2798460','OTg3NjU0MzIxLy4=',0,'2BUF4MSTVAJ66Z7J','0xf9C926B9a46E2EFdAC80AcB50397F6bC9d99ac55','Yml0c29uaWMxMjNRV0U=','OGIzYjVmYTRhYWU5MzI0NTExMTVmZTlhYjQyY2VhZjNjMTExZDQ2NTQ5ZjUwZmUxNzI1NTczYjZhYzdhMmU2ZQ==','MHhkODdlZmU2NzdkNTk2OTRlZjcwMzU2MzFjZTg0MGY1ZmJhYzAzN2U0MWVjM2Q4MzUyNTNiMWE3MWUyMTU2ZTEzZjUxOGMxN2RhOTM1NjZmZDY3OTIyNmNlMWY3ZmFjYmY1N2VlMzA0Yzg4OWIwNGY2ZTRkZDhjMTE2MDRjNmIyNA==',0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(132,'captainhook','bbe7b6fc269417bc6595824d0b93a41d7ee9b74671609f58f290c28095c2742b2675944231aff0772c9daf0cf5a3fc2b042d2b70e799cbe7448dca6f3b42860a','captainhook99999@gmail.com',2,0,0,NULL,NULL,NULL,NULL,'7682430b5b4b21a0f7be47a3ea44dc43','0',NULL,'2018-06-07 11:30:05','2018-06-18 16:46:19',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'WDUCAM7PJPUZMM5E',NULL,NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(133,'leo','leo1234567','leoruzin@hotmail.com',2,0,0,NULL,'4a81c63779e946fc690c63e7e5804491','2018-06-19 16:45:41',NULL,NULL,NULL,NULL,NULL,'2018-06-19 07:45:41',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','jdskalfajsdlkf',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(148,'555','bfa3df38a34c4dd8e5849718214ad87ba8f9df40549688c04b670ac5df7cfaae75ddf1bedf85f8e3e4bcb17eef306675ff411355976f207d3d8ebfdbbbfa8a40','555@555.com',2,0,0,NULL,'77b22ce6c80403d54615506663ca43e5','2018-06-19 16:39:24',NULL,NULL,NULL,NULL,NULL,'2018-06-19 07:39:24',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','555',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(150,'hehe','26723846bc5a684b1aa1c6f6c4210d4d2f4f86eb0b65123984614450b7bbc7b29008bcbabdc2aa59c4fa2139a19e548c24a423958a2e422dc711c4886cd2d7ce','leoruzin@hotmail.com',2,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-06-19 07:45:10',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','hehe',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(151,'hihi','ed2db10339fbb7c33e15be47ef7630cb2be9c404d0a4172440963f6b73b712eeeabdcb12a029a2e466159ea1af6998632f381dbd2a156f1908727e9798b88ae5','leoruzin@hotmail.com',2,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-06-19 07:45:59',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','hihi',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(154,'333','b081299adffaca47d8ca0c8553322767a4666be907a34d25aa28632ac944b346eeb9c51887167384355eced1f6ece7061302fcf4d209fba595e84257e233fce5','asdf@ee.com',2,0,0,NULL,'52ad027c22d5bfac8b27c9d103f0a76d','2018-06-20 09:35:40',NULL,NULL,NULL,NULL,NULL,'2018-06-20 00:35:40',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','333',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(159,'aaa','4690aca9192016ddbd1c10fcfb3fff25503288aa2aa726334e54f97058aaa174e594a294c63979d51ab879aa4ba08e8aedd9200743d5fd84ea9223dfab24bbce','qqq@aaa.com',2,0,0,NULL,'e7c4d763d6dc44c13be90edee9b2904c','2018-06-20 20:34:14',NULL,NULL,NULL,NULL,NULL,'2018-06-20 11:34:14',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','aaa',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(160,'111','a9ef0c895826da6a393abb5cdcbab89b33964983536fd5c0a6acd9578868989bf33fb51eff274c6cb241cfc22db4128235057f0bd710a13f2a755e57e63b5b35','yakobux123456@gmail.com',2,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-06-20 14:55:39',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','111',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(161,'222','9e6a5a5fd6ffd32127845bfe94c44f2f58f348276f98ed2e5657e0822c006720362a406b077fbf773f161b97643eb9d39733eb8edd858a898bfd2fe75041db0f','222@222.com',2,0,0,NULL,'070fa57b15f83403f5c45682dee6efd4','2018-06-21 00:36:00',NULL,NULL,NULL,NULL,NULL,'2018-06-20 15:36:00',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','c2d7cf95645d33006175b78989035c7c9061d3f9',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','',''),(165,'333','b081299adffaca47d8ca0c8553322767a4666be907a34d25aa28632ac944b346eeb9c51887167384355eced1f6ece7061302fcf4d209fba595e84257e233fce5','333@333.com',2,0,0,NULL,'ec5719d6d2a62a67c2ce80ebfa8fc08b','2018-06-21 00:40:57',NULL,NULL,NULL,NULL,NULL,'2018-06-20 15:40:57',0,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'','c2d7cf95645d33006175b78989035c7c9061d3f9',NULL,NULL,NULL,0.0000000000,'','',0,0,0,0,0,0,0,'','','');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `extid` bigint(20) DEFAULT NULL,
  `type` set('google','facebook') NOT NULL,
  `token` varchar(512) NOT NULL,
  `used` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`type`,`token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='User credentials';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_auth`
--

LOCK TABLES `user_auth` WRITE;
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` VALUES (1,1,1117740208382357,'facebook','EAAZA4zWHLDrkBALZCbttD6lBOTKB7YJ2wgyLrZA8b30wCJZAYH79iGEb7bUMtVqmWMfDFfpixMZAtwgXPR6D9WrD2ZCh3WzHyifO9V0ZAqi7d5zlQiQsru7Wm9HTije1qNiPLuxiYZAg7Nxq1J4DZBWwEgCuZCgeaBlAbgzr85iokNvPAkLgiZAkNQ0W5vTYYHL8yY2XleI6YUrrR2Q6glPlAyxel0Yb4zv8ZAYXk8Kan63nuwZDZD',NULL),(2,2,10217498740079743,'facebook','EAAZA4zWHLDrkBAEdIp5uwJKIFaNVtXwbjo4genZCgoNrQyf6e3LQrmW5GBWZCC93BApUQo1wjw9kHkp9qoUMGZCKZA8ZBu0ZBt1vNiL8bsZC8PrBjJ00ZBVxJpHavjjoEmKvgFnwStkkPZCt9zXuA65AbGZAHwkxb8Ahv8whLm5utkxtEjZAi3SmlSBN1sMIj4ougEvAAOk0yXZBtuZCTiS6lTU8YT',NULL),(3,3,1499938580107358,'facebook','EAAZA4zWHLDrkBACXNL4oYk67ACheIYvZCVWuPg7AWvqiRqhZBlAOUrM7i0zd7a0OwY4g04KmsRxPMcw4nozufISddPyzt4PhGoyeggIZBDwGDsXcju21sEHKC4ZAT7YKGbkA6QKj1shRkqE3uFiSrvhf0N9zsPJByNy4ZB1nK8yjT8QYzeifkqSiivpf1xYMlZCxVZAkjXdAeKTwDwYXPfrH',NULL),(4,4,9223372036854775807,'google','ya29.GlsrBi8MVxaK2HNGORuMJx8TomaFtDI7CXs-HmgKVAu3ZZ0YdpZO7H2vIydXmeLX3pSHvGbcQToNyoLQBSAB_YUAJTW0L2lXWlMcwiNI7JN_4XVJvEnBcTYEpAS2',NULL),(5,5,0,'google','ya29%2EGls5BlGPDGXbP1LvOa%5Fqg12widxmYp0ucTuQqddF2itd%5FO3%2DsaR%2DbvsH4LemT%5Frdkkp7WgrhWMoEkRxyzzahsDrjYWAKaWzGlVRZXmSE1ZBj5WoRY1v0uzbVwJGv',NULL);
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_friend_requests`
--

DROP TABLE IF EXISTS `user_friend_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_friend_requests` (
  `user` bigint(20) unsigned NOT NULL,
  `friend` bigint(20) unsigned NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`user`,`friend`) USING BTREE,
  KEY `friend` (`friend`),
  CONSTRAINT `user_friend_requests_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_friend_requests_ibfk_2` FOREIGN KEY (`friend`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Friend requests';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_friend_requests`
--

LOCK TABLES `user_friend_requests` WRITE;
/*!40000 ALTER TABLE `user_friend_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_friend_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_friends` (
  `a` bigint(20) unsigned NOT NULL,
  `b` bigint(20) unsigned NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`a`,`b`) USING BTREE,
  KEY `b` (`b`),
  CONSTRAINT `user_friends_ibfk_1` FOREIGN KEY (`a`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_friends_ibfk_2` FOREIGN KEY (`b`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User friends';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_friends`
--

LOCK TABLES `user_friends` WRITE;
/*!40000 ALTER TABLE `user_friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_hashes`
--

DROP TABLE IF EXISTS `user_hashes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_hashes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `hash` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `used` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `used` (`used`),
  CONSTRAINT `user_hashes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COMMENT='User auth tokens';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_hashes`
--

LOCK TABLES `user_hashes` WRITE;
/*!40000 ALTER TABLE `user_hashes` DISABLE KEYS */;
INSERT INTO `user_hashes` VALUES (1,1,'f7045940282c617348672d7ad916cab7c1bea2d0f35e8f602d309a4a77a05e17ab81473ea86847bea1e98787d5a3a722ede0ad501aa0fe503946594f397efefc','2018-10-01 04:47:04',NULL),(2,1,'6774e185f6c4c1472d611cf3f8e690db1501b141091a3f09eaf0c4b2ea001ff48ee50bbdf9ec27747992de8774e05505f22906036edea5bf141a17e783f1047b','2018-10-01 04:49:51',NULL),(3,1,'9757e28c79535f0fe81e4ef135adb791cd03c71797a4b007658a0cb4ac0ce1ea0abac40eb2bec8cf638874999b52e39cb686af8fb8c56e5a5316f38b5ceb157a','2018-10-01 04:56:53',NULL),(4,1,'e1d391f5d46718f527bdcfd12940a3ced4242a090547fdcce97dbfa071b2c77ab746c4e43856a8fa627ece9c1e4ee6d78aaba5452eedf6ed813cbbb5b860bd2c','2018-10-01 04:58:25',NULL),(5,1,'e23d7400526902ea7da05b1151d28e7851d3453553c25e1df94dbe9b82a4c7bde57a42c3b02e985d327e17c5dc37899ed23ee6e6ae61b1c493b6f4cc780d102a','2018-10-01 05:01:25',NULL),(6,1,'fac85897659e13de7eddd4e8a688799a627b2fa90838069af430ea3e286a17d9c6f1b7c2330751a732a0f6bb005c62e621914a4aa16925f552c3e5791e613933','2018-10-01 05:02:07',NULL),(7,1,'f6329c85f71684792d4f19461b7c08cbbe1cdce42856befb84a0b34d287e799e52b5feb59650fede2a3507b664bfd257ee15e9f16939ac3890d9f851d0c18a54','2018-10-01 05:56:41',NULL),(8,1,'51ad6a5d17202deb96acb284665b1cf60428fd3a924f536e630ec9903724d12ae420de184da40433b056feaa1501035bf1508e50cddc6c8ca0aa4580b3edc3e9','2018-10-01 05:58:20',NULL),(9,1,'6b82318bf68e98b2fbc1185021c7a2b9376903ce10679aed8fdfa384d471dc23043212248f8e59623d40983ab82c0224b03b93416e97fe3c1bd495c61f326e13','2018-10-01 06:44:29',NULL),(10,1,'f68a3e595680fa92a21f10b867978f59e67a10f90fe2eaaa928ebf5dce507910a25337b5dacaa79f45c15114d1ceb06a64817bef90ac252993143c9e23ed9e7e','2018-10-01 06:51:04',NULL),(11,1,'3ddca78a247d23162ad9e32eadf5d62ac89307392d187ee1ddbb4ccc023896c161f0e518b5331e8fe5e27ae16761c3a735167c1f796c2a599b00a0bf846e00c5','2018-10-01 06:52:46',NULL),(12,1,'71be7f564cd9d29718fff70bed369492a3d87d5acd085975fc0256dfa2509082347f68e960cbb42f702a75d3a06dfc83b9769691e11b60ad1a350181118ff7b6','2018-10-01 07:02:13',NULL),(13,1,'ecfb05b72e28c15d4ffb78dd0bf407f6869b9b424b3deb29f1e8c881178598afc1bf0f8f9ff55a9318da6d6ba7d0f7887adca0b0176fe39c507d54f05f6d4534','2018-10-01 07:05:34',NULL),(14,1,'2b0ea93df21dc88f2d7d1cac365480e4cfc1f29509e9584089a33aa19183cee16b4a94bdcdf3cd85aef3c1a2dc07b020e50e74eb8543cb616627396f1cee8ab4','2018-10-01 07:06:54',NULL),(15,1,'0f0c871f0984323bbcf4a81a2abf1f9fff79d11d9fd1114e5cd805cd4e74d53de61af7d47aee904f83ab1d17b48872980fb213d90c829316cc6ed44d435df0e0','2018-10-01 07:07:04',NULL),(16,1,'51aa8cf612e1bc5245322fb8b8b09e8a06048128dc1c7d8b05c0862b5389487dd48c8b59b591eeea6216e9a8f3fd706fb7e2c9516162034bc3e89e8b87f2073e','2018-10-01 07:13:47',NULL),(17,1,'b2d7ad22c8ec38f4c253a67b382c9be00154886a810c4488be4953488680e2f7ba0148b4ef6b68c0e584c2d22a729cb4623c562e21b4eac908143f9a1ad7ac9c','2018-10-01 07:15:30',NULL),(18,1,'ae465743b0535c296cfee2bcc5b3bac346d596e2d2ae1006c3608493456d49ca7a20fe712f43b1dbff67d4fd0a0760c597b67f8f10b125c8ce553f16bd61ce04','2018-10-01 07:15:57',NULL),(19,2,'30752ba3c1bfe275706cd6dbcb5c656d9c42d8141476b44aec6d4cd8468ab85ea6fe342e713cb8aac1ba7e31031086161d3ddc8bbec7bfc1344c7bd6c77d8eab','2018-10-01 09:45:03',NULL),(20,2,'bc0f4c3d6168567eba0e0f7727d01d07285b73ea2e40f1e7484692a3e02c3fd69158103fd0c9d18d8ba736ddc11fcb2330493fd79efab8a71a07fc137fa35458','2018-10-01 09:45:12',NULL),(21,2,'6c54300ab65f75605c9b48b0b18d91baf1d5fb1b39d5baa7d17891e828d15749afc43e111f20ee061d8f32dc850dadbe201e82a40c112c9c60c4c1baaa4789d8','2018-10-01 09:45:51',NULL),(22,1,'23f526a2521de2abd7e4b6cdfaffa0426af220792460bc24b3d8f77967d4962b1c9a720598f0c2ce665be946d213569107b75cd541b1f5b4e17801698df7a52a','2018-10-01 09:48:17',NULL),(23,1,'7d0ddfb8dc7b183f01179de1ff3b6ffc2ba4a9a7e940fea60185dea2d9a9724a70d12efe8c901116c5119814cd5a7971c49e725a76d83f3fa611b2ba77e9b606','2018-10-01 09:49:00',NULL),(24,1,'89d4f19463ebcbdcd95df77e1dbc3c966c428677ad17ced1e8d526e2fd3c733562caeeaa700f0b0079557729aa4ab73a542093090d028a0ce16b4e544ec07987','2018-10-01 09:49:04',NULL),(25,2,'a97ed8ab0d3b19c5ee1abec5b94a6a176af7b9f0664a83dddbd381642146c3099ed9e63c00dd805dfa7c5b56184427b5dc62786c5e2600401f62ef51c4f4cab3','2018-10-01 09:49:05',NULL),(26,2,'911e18c428e267a41fcc68b44db8257b067e4ed95ccca3568f1f78373647837500413751b2c4036e4a99bd38c5062e0bb6bd10108463abe232fcb46fe388d708','2018-10-01 10:14:32',NULL),(27,2,'68e2927a7dd486f0f528781076f06ff8f4daef5c00af9e5fcf1a473340b6decc4173cc20acbbc35536451827ccacb0223b21cdfe2cffe8a6f161cccf0ecb9598','2018-10-01 10:21:59',NULL),(28,1,'1f4fe1809dcf52f793e897e43db92bde19023e827452a066975c7e1056130251a256d7cd1094bbd26563369d29971a184ac8596e9eb977a88f8dbf9d34fde05f','2018-10-01 10:44:27',NULL),(29,1,'3000b9180cbe1bff251e34cd978075ec70888e1a55299f410ee565b40e917fa9e9d3a9b597079ee1b977ce08daaba2755f2ae736fd21b2d3de8882633fe23a70','2018-10-02 04:15:19',NULL),(35,3,'3329cdbc4cb9e46f672b971c2d90a58af56e9ad10ac2542ef7e19088954323ae18c239606f5889108628dfefa81b20ee2558efcfa4c3831ab5a82c83896465bf','2018-10-03 07:34:30',NULL),(36,3,'e6031a186d4b6620504e4d6a678dc1b9fb10188ee355d821bed3cf05f92977e73f1f7843b65c4fb7781001675cfa9757226a6fde7a93015cfb503ba465bfcc24','2018-10-03 07:34:31',NULL),(37,3,'5f2ad245ee857f0d053bad0d31a8ec016076df96cf0dda8008f3db10537c8a4e61ed22b84a52afff2085b483c8a7c031a044a142af01a94b9ff5919a55cd3497','2018-10-03 07:34:31',NULL),(38,3,'57dbcc5191daeeae9a0e8b43c26c47dd1cfd868d7ef50364de5aeb415fd25aa47cfbaa2b72d417433f41e337ccc0807062a68bbf46f30863b34f78bbe21b74e7','2018-10-03 07:54:58','2018-10-17 07:26:14'),(39,2,'26f778d0132c9078178e63deb6d902d1028f1451473d15ff974889bfde57aea50822a607f9a0cffd35752836c42d8f6f2c681739bf078ba4484cef21a935b2de','2018-10-08 07:59:25','2018-10-17 02:27:44'),(41,1,'a180a92c1d1cd51fb69c755e787e64089f5901f9574546328249144cf11330c1cfbedbbe97a8e74120a751d569212b729fa307bc151fd70b7408fa6ba981a4e4','2018-10-10 06:45:03','2018-10-15 04:14:59'),(42,1,'9b27eca0e7bd1cf65c83d747d8d90969c8e7c7117d997907e43ca81b6282f39717d2d7b55d0b795187f4335ab4d593f477ba61fbe17e8392e5c2bedb725b947e','2018-10-15 04:28:08','2018-10-15 04:55:30'),(43,1,'1e784a3bd0b002c20a1eacb608f920a891b8902f964851ec95068b9e2d59141db739037f1f9ffaf612dc8f06368f0bea0dcb180b776834d2c714fc5be02503ea','2018-10-15 05:02:34','2018-10-16 08:51:29'),(44,1,'453586b6c6aaf7da841c08463369f259b92b61c2cf949f68e988d6a29aa8eb419a040b641acd94685dc51553e227d48fdf86ee776cacebf9af6cb53dc4136f5b','2018-10-16 09:40:09','2018-10-17 07:27:27'),(55,2,'0a457cd7d8f3ec4b18cdc2fe43e72ff9489530d8ef4b6e388095b037213c4519b931078c2daec91bb558fa439c8d41bae26835d031dc1f8658e80dff146ad7f0','2018-10-17 06:52:25','2018-10-17 06:53:00'),(64,4,'dbed74bb8675fa05e4ba4c2eb3fb14f63ad23c0472398cf9f1f3788be21e18777392746e7315e2e0b69cbb2357f5c7a74bf1380982f305c6c0615469d0e4b282','2018-10-17 07:08:16','2018-10-17 07:29:26'),(73,2,'3d5f35a757e9bee92419f570a2dc67a5da0e426cf3c1078381e338c4203cf52edccc1dc4db3d603f54f6febe9137397b3b2a541bbb72aff51a4d180cb74673a3','2018-10-17 07:42:04','2018-10-17 08:50:06'),(74,1,'72b48e28e04fd225bd35ae455d16912bfd1bee87d5a28aa563270087dbb2a9f19e14d45c6515c018be7cfec9e1a9f3487d18240245fd835925c7efe3fc2b796f','2018-10-17 07:56:24','2018-10-17 08:03:55'),(83,5,'b2e52f65c4a091815f85868b240c0e9c104305af4cb8a6a4b3beea607100cd54bb5c4b0e619455f6dd37dfb920517afac274cd4ac9d2c7491378dd34c6f155cf','2018-10-17 08:30:06',NULL),(84,1,'e210e5150edcc9c729a14c17407401f3c5b6327d153a7c12f6ea6fb583fba448b3c85f898456fe471357f187f5188b50482ca9f18ccd4ef9ec7919ff8d09206d','2018-10-17 08:43:04','2018-10-17 08:50:02');
/*!40000 ALTER TABLE `user_hashes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_videos`
--

DROP TABLE IF EXISTS `user_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `video` varchar(4096) NOT NULL,
  `uploaded` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='User videos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_videos`
--

LOCK TABLES `user_videos` WRITE;
/*!40000 ALTER TABLE `user_videos` DISABLE KEYS */;
INSERT INTO `user_videos` VALUES (1,1,'profile/1538370361.6799-24181.avi','2018-10-01 05:06:01',1),(2,1,'profile/1538376710.9639-73529.avi','2018-10-01 06:51:51',1),(3,1,'profile/1538376834.9705-78771.avi','2018-10-01 06:53:55',1),(4,1,'profile/1538378043.9179-79490.avi','2018-10-01 07:14:04',1),(5,2,'profile/1538388923.4057-31135.avi','2018-10-01 10:15:23',1),(6,2,'profile/1538389353.4251-79092.avi','2018-10-01 10:22:33',1),(7,1,'profile/1538451278.9187-30129.avi','2018-10-02 03:34:39',1),(8,1,'profile/1538452108.2774-30973.avi','2018-10-02 03:48:28',1),(9,1,'profile/1538453742.2561-50584.avi','2018-10-02 04:15:42',1),(10,1,'profile/1538471156.6164-13062.avi','2018-10-02 09:05:56',1),(11,2,'profile/1538482489.3917-19255.avi','2018-10-02 12:14:49',1),(12,3,'profile/1538549441.4926-31696.avi','2018-10-03 06:50:41',1),(13,3,'profile/1538549900.9834-70589.avi','2018-10-03 06:58:21',1),(14,3,'profile/1538549996.3484-82269.avi','2018-10-03 06:59:56',1),(15,3,'profile/1538551023.4954-55093.avi','2018-10-03 07:17:03',1),(16,3,'profile/1538553336.3605-49622.avi','2018-10-03 07:55:36',1),(17,2,'profile/1538985611.0687-23871.avi','2018-10-08 08:00:11',1),(18,1,'profile/1539579330.8136-48395.avi','2018-10-15 04:55:30',1),(19,1,'profile/1539579812.628-76688.avi','2018-10-15 05:03:32',1),(20,2,'profile/1539762884.2906-55583.avi','2018-10-17 07:54:44',1),(21,2,'profile/1539762898.811-94018.avi','2018-10-17 07:54:59',1);
/*!40000 ALTER TABLE `user_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  `gender` set('male','female') DEFAULT NULL,
  `lgbtq` tinyint(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `location_city` varchar(255) DEFAULT NULL,
  `location_country` varchar(255) DEFAULT NULL,
  `location_country_code` varchar(3) DEFAULT NULL,
  `location_lat` float DEFAULT NULL,
  `location_lng` float DEFAULT NULL,
  `instagram` varchar(4096) DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `busy` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `online_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `age` (`age`),
  KEY `location_lat` (`location_lat`,`location_lng`),
  KEY `online` (`online`),
  KEY `gender` (`gender`) USING BTREE,
  KEY `birthday` (`birthday`) USING BTREE,
  KEY `busy` (`busy`),
  KEY `lgbtq` (`lgbtq`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='User list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test name','Test surname',NULL,NULL,'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=1117740208382357&height=50&width=50&ext=1540961224&hash=AeTDXFcCgGt8Is54',NULL,'male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hoanhca',1,0,'2018-10-01 04:47:04','2018-10-01 04:47:04','2018-10-01 04:47:04'),(2,'Moog Kwon','',NULL,NULL,'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10217498740079743&height=50&width=50&ext=1540979103&hash=AeSLETJKMvvEtFkw',NULL,'female',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Moog',1,0,'2018-10-01 09:45:03','2018-10-01 09:45:03','2018-10-01 09:45:03'),(3,'Chad Lee','',NULL,NULL,'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=1499938580107358&height=50&width=50&ext=1541141409&hash=AeRBYFmYJMZJuHOd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'chad',1,0,'2018-10-03 06:50:09','2018-10-03 06:50:09','2018-10-03 06:50:09'),(4,'hoanh','nguyen','hoanhnv1@gmail.com',NULL,'https://lh4.googleusercontent.com/-E_eDpycYj6M/AAAAAAAAAAI/AAAAAAAAAAA/AAN31DUqDUEAcGBLiXXcTRQ631_tfdQpRQ/mo/photo.jpg?sz=50',NULL,'male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'he’d',0,0,'2018-10-03 07:22:03','2018-10-03 07:22:03','2018-10-03 07:22:03'),(5,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2018-10-17 08:30:06','2018-10-17 08:30:06','2018-10-17 08:30:06');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-17  8:59:26
