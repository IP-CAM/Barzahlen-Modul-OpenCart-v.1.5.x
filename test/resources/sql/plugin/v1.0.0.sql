SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opencart`
--

-- --------------------------------------------------------

--
-- Dumping data for table `oc_extension`
--

INSERT INTO `oc_extension` (`extension_id`, `type`, `code`) VALUES
(428, 'payment', 'barzahlen');

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_barzahlen_refund_transaction`
--

DROP TABLE IF EXISTS `oc_order_barzahlen_refund_transaction`;
CREATE TABLE IF NOT EXISTS `oc_order_barzahlen_refund_transaction` (
  `barzahlen_refund_transaction_id` int(11) NOT NULL,
  `barzahlen_transaction_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`barzahlen_refund_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_barzahlen_transaction`
--

DROP TABLE IF EXISTS `oc_order_barzahlen_transaction`;
CREATE TABLE IF NOT EXISTS `oc_order_barzahlen_transaction` (
  `barzahlen_transaction_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`barzahlen_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_barzahlen_transaction`
--

INSERT INTO `oc_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES
(134, 0, 'barzahlen', 'barzahlen_status', '1', 0),
(135, 0, 'barzahlen', 'barzahlen_shop_id', '13406', 0),
(136, 0, 'barzahlen', 'barzahlen_payment_key', 'f1bc78c3b1b20be0001070dc45ff3b3adea19725', 0),
(137, 0, 'barzahlen', 'barzahlen_notification_key', '2bd9943db87c621a8963e0f7f0897beee201d8a4', 0),
(138, 0, 'barzahlen', 'barzahlen_minimum_amount', '', 0),
(139, 0, 'barzahlen', 'barzahlen_maximum_amount', '', 0),
(140, 0, 'barzahlen', 'barzahlen_sandbox', '1', 0),
(141, 0, 'barzahlen', 'barzahlen_debug', '1', 0),
(142, 0, 'barzahlen', 'barzahlen_failed_status_id', '10', 0),
(143, 0, 'barzahlen', 'barzahlen_pending_status_id', '15', 0),
(144, 0, 'barzahlen', 'barzahlen_paid_status_id', '5', 0),
(145, 0, 'barzahlen', 'barzahlen_expired_status_id', '14', 0),
(146, 0, 'barzahlen', 'barzahlen_sort_order', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oc_order_barzahlen_transaction`
--

UPDATE `oc_user_group`
SET `permission` = 'a:2:{s:6:"access";a:123:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:14:"catalog/review";i:10;s:18:"common/filemanager";i:11;s:13:"design/banner";i:12;s:13:"design/layout";i:13;s:14:"extension/feed";i:14;s:17:"extension/manager";i:15;s:16:"extension/module";i:16;s:17:"extension/payment";i:17;s:18:"extension/shipping";i:18;s:15:"extension/total";i:19;s:16:"feed/google_base";i:20;s:19:"feed/google_sitemap";i:21;s:20:"localisation/country";i:22;s:21:"localisation/currency";i:23;s:21:"localisation/geo_zone";i:24;s:21:"localisation/language";i:25;s:25:"localisation/length_class";i:26;s:25:"localisation/order_status";i:27;s:26:"localisation/return_action";i:28;s:26:"localisation/return_reason";i:29;s:26:"localisation/return_status";i:30;s:25:"localisation/stock_status";i:31;s:22:"localisation/tax_class";i:32;s:21:"localisation/tax_rate";i:33;s:25:"localisation/weight_class";i:34;s:17:"localisation/zone";i:35;s:14:"module/account";i:36;s:16:"module/affiliate";i:37;s:13:"module/banner";i:38;s:17:"module/bestseller";i:39;s:15:"module/carousel";i:40;s:15:"module/category";i:41;s:15:"module/featured";i:42;s:13:"module/filter";i:43;s:18:"module/google_talk";i:44;s:18:"module/information";i:45;s:13:"module/latest";i:46;s:16:"module/slideshow";i:47;s:14:"module/special";i:48;s:12:"module/store";i:49;s:14:"module/welcome";i:50;s:24:"payment/authorizenet_aim";i:51;s:21:"payment/bank_transfer";i:52;s:14:"payment/cheque";i:53;s:11:"payment/cod";i:54;s:21:"payment/free_checkout";i:55;s:14:"payment/liqpay";i:56;s:20:"payment/moneybookers";i:57;s:14:"payment/nochex";i:58;s:15:"payment/paymate";i:59;s:16:"payment/paypoint";i:60;s:13:"payment/payza";i:61;s:26:"payment/perpetual_payments";i:62;s:14:"payment/pp_pro";i:63;s:17:"payment/pp_pro_uk";i:64;s:19:"payment/pp_standard";i:65;s:15:"payment/sagepay";i:66;s:22:"payment/sagepay_direct";i:67;s:18:"payment/sagepay_us";i:68;s:19:"payment/twocheckout";i:69;s:28:"payment/web_payment_software";i:70;s:16:"payment/worldpay";i:71;s:27:"report/affiliate_commission";i:72;s:22:"report/customer_credit";i:73;s:22:"report/customer_online";i:74;s:21:"report/customer_order";i:75;s:22:"report/customer_reward";i:76;s:24:"report/product_purchased";i:77;s:21:"report/product_viewed";i:78;s:18:"report/sale_coupon";i:79;s:17:"report/sale_order";i:80;s:18:"report/sale_return";i:81;s:20:"report/sale_shipping";i:82;s:15:"report/sale_tax";i:83;s:14:"sale/affiliate";i:84;s:12:"sale/contact";i:85;s:11:"sale/coupon";i:86;s:13:"sale/customer";i:87;s:20:"sale/customer_ban_ip";i:88;s:19:"sale/customer_group";i:89;s:10:"sale/order";i:90;s:11:"sale/return";i:91;s:12:"sale/voucher";i:92;s:18:"sale/voucher_theme";i:93;s:15:"setting/setting";i:94;s:13:"setting/store";i:95;s:16:"shipping/auspost";i:96;s:17:"shipping/citylink";i:97;s:14:"shipping/fedex";i:98;s:13:"shipping/flat";i:99;s:13:"shipping/free";i:100;s:13:"shipping/item";i:101;s:23:"shipping/parcelforce_48";i:102;s:15:"shipping/pickup";i:103;s:19:"shipping/royal_mail";i:104;s:12:"shipping/ups";i:105;s:13:"shipping/usps";i:106;s:15:"shipping/weight";i:107;s:11:"tool/backup";i:108;s:14:"tool/error_log";i:109;s:12:"total/coupon";i:110;s:12:"total/credit";i:111;s:14:"total/handling";i:112;s:16:"total/klarna_fee";i:113;s:19:"total/low_order_fee";i:114;s:12:"total/reward";i:115;s:14:"total/shipping";i:116;s:15:"total/sub_total";i:117;s:9:"total/tax";i:118;s:11:"total/total";i:119;s:13:"total/voucher";i:120;s:9:"user/user";i:121;s:20:"user/user_permission";i:122;s:17:"payment/barzahlen";}s:6:"modify";a:123:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:14:"catalog/review";i:10;s:18:"common/filemanager";i:11;s:13:"design/banner";i:12;s:13:"design/layout";i:13;s:14:"extension/feed";i:14;s:17:"extension/manager";i:15;s:16:"extension/module";i:16;s:17:"extension/payment";i:17;s:18:"extension/shipping";i:18;s:15:"extension/total";i:19;s:16:"feed/google_base";i:20;s:19:"feed/google_sitemap";i:21;s:20:"localisation/country";i:22;s:21:"localisation/currency";i:23;s:21:"localisation/geo_zone";i:24;s:21:"localisation/language";i:25;s:25:"localisation/length_class";i:26;s:25:"localisation/order_status";i:27;s:26:"localisation/return_action";i:28;s:26:"localisation/return_reason";i:29;s:26:"localisation/return_status";i:30;s:25:"localisation/stock_status";i:31;s:22:"localisation/tax_class";i:32;s:21:"localisation/tax_rate";i:33;s:25:"localisation/weight_class";i:34;s:17:"localisation/zone";i:35;s:14:"module/account";i:36;s:16:"module/affiliate";i:37;s:13:"module/banner";i:38;s:17:"module/bestseller";i:39;s:15:"module/carousel";i:40;s:15:"module/category";i:41;s:15:"module/featured";i:42;s:13:"module/filter";i:43;s:18:"module/google_talk";i:44;s:18:"module/information";i:45;s:13:"module/latest";i:46;s:16:"module/slideshow";i:47;s:14:"module/special";i:48;s:12:"module/store";i:49;s:14:"module/welcome";i:50;s:24:"payment/authorizenet_aim";i:51;s:21:"payment/bank_transfer";i:52;s:14:"payment/cheque";i:53;s:11:"payment/cod";i:54;s:21:"payment/free_checkout";i:55;s:14:"payment/liqpay";i:56;s:20:"payment/moneybookers";i:57;s:14:"payment/nochex";i:58;s:15:"payment/paymate";i:59;s:16:"payment/paypoint";i:60;s:13:"payment/payza";i:61;s:26:"payment/perpetual_payments";i:62;s:14:"payment/pp_pro";i:63;s:17:"payment/pp_pro_uk";i:64;s:19:"payment/pp_standard";i:65;s:15:"payment/sagepay";i:66;s:22:"payment/sagepay_direct";i:67;s:18:"payment/sagepay_us";i:68;s:19:"payment/twocheckout";i:69;s:28:"payment/web_payment_software";i:70;s:16:"payment/worldpay";i:71;s:27:"report/affiliate_commission";i:72;s:22:"report/customer_credit";i:73;s:22:"report/customer_online";i:74;s:21:"report/customer_order";i:75;s:22:"report/customer_reward";i:76;s:24:"report/product_purchased";i:77;s:21:"report/product_viewed";i:78;s:18:"report/sale_coupon";i:79;s:17:"report/sale_order";i:80;s:18:"report/sale_return";i:81;s:20:"report/sale_shipping";i:82;s:15:"report/sale_tax";i:83;s:14:"sale/affiliate";i:84;s:12:"sale/contact";i:85;s:11:"sale/coupon";i:86;s:13:"sale/customer";i:87;s:20:"sale/customer_ban_ip";i:88;s:19:"sale/customer_group";i:89;s:10:"sale/order";i:90;s:11:"sale/return";i:91;s:12:"sale/voucher";i:92;s:18:"sale/voucher_theme";i:93;s:15:"setting/setting";i:94;s:13:"setting/store";i:95;s:16:"shipping/auspost";i:96;s:17:"shipping/citylink";i:97;s:14:"shipping/fedex";i:98;s:13:"shipping/flat";i:99;s:13:"shipping/free";i:100;s:13:"shipping/item";i:101;s:23:"shipping/parcelforce_48";i:102;s:15:"shipping/pickup";i:103;s:19:"shipping/royal_mail";i:104;s:12:"shipping/ups";i:105;s:13:"shipping/usps";i:106;s:15:"shipping/weight";i:107;s:11:"tool/backup";i:108;s:14:"tool/error_log";i:109;s:12:"total/coupon";i:110;s:12:"total/credit";i:111;s:14:"total/handling";i:112;s:16:"total/klarna_fee";i:113;s:19:"total/low_order_fee";i:114;s:12:"total/reward";i:115;s:14:"total/shipping";i:116;s:15:"total/sub_total";i:117;s:9:"total/tax";i:118;s:11:"total/total";i:119;s:13:"total/voucher";i:120;s:9:"user/user";i:121;s:20:"user/user_permission";i:122;s:17:"payment/barzahlen";}}'
WHERE `user_group_id` = 1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
