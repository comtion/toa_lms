-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2020 at 01:27 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isuzu_motor`
--

-- --------------------------------------------------------

--
-- Table structure for table `LMS_ABOUT`
--

CREATE TABLE `LMS_ABOUT` (
  `da_id` int(50) NOT NULL,
  `da_wctitle_th` varchar(255) NOT NULL,
  `da_wctitle_en` varchar(255) NOT NULL,
  `da_wcmessage_th` text NOT NULL,
  `da_wcmessage_en` text NOT NULL,
  `da_title_th` varchar(250) NOT NULL,
  `da_title_en` varchar(250) NOT NULL,
  `da_privacy_policy_th` text NOT NULL,
  `da_privacy_policy_en` text NOT NULL,
  `da_privacy_policy_jp` text NOT NULL,
  `da_company_th` varchar(250) NOT NULL,
  `da_company_en` varchar(250) NOT NULL,
  `da_address_th` text NOT NULL,
  `da_address_en` text NOT NULL,
  `da_contact_main` varchar(250) NOT NULL,
  `da_contact_fax` varchar(250) NOT NULL,
  `da_website` varchar(250) NOT NULL,
  `da_email_a` varchar(250) NOT NULL,
  `da_email_b` varchar(250) NOT NULL,
  `da_copyright` varchar(250) NOT NULL,
  `da_facebook` varchar(250) NOT NULL,
  `da_twitter` varchar(250) NOT NULL,
  `da_logo_top` varchar(255) NOT NULL,
  `da_logo_footer` varchar(255) NOT NULL,
  `da_footer_background` varchar(255) NOT NULL COMMENT 'พื้นหลัง Footer',
  `da_modifiedby` varchar(50) NOT NULL,
  `da_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_ABOUT`
--

INSERT INTO `LMS_ABOUT` (`da_id`, `da_wctitle_th`, `da_wctitle_en`, `da_wcmessage_th`, `da_wcmessage_en`, `da_title_th`, `da_title_en`, `da_privacy_policy_th`, `da_privacy_policy_en`, `da_privacy_policy_jp`, `da_company_th`, `da_company_en`, `da_address_th`, `da_address_en`, `da_contact_main`, `da_contact_fax`, `da_website`, `da_email_a`, `da_email_b`, `da_copyright`, `da_facebook`, `da_twitter`, `da_logo_top`, `da_logo_footer`, `da_footer_background`, `da_modifiedby`, `da_modifieddate`) VALUES
(1, '', '', '', '', 'ระบบการจัดการเรียนรู้', 'Learning Management System', '<p align=\"justify\">เว็บไซต์นี้บริหารโดย Verztec Consulting Pte Ltd.</p>\r\n<p align=\"justify\">ข้อมูลภาพรวมเกี่ยวกับวิธีการปกป้องความเป็นส่วนตัวของคุณในระหว่างการเยี่ยมชมเว็บไซต์ของเรามีดังต่อไปนี้</p>\r\n<p align=\"justify\">&nbsp;</p>\r\n<p align=\"justify\"><strong>เรารวบรวมข้อมูลใดบ้าง?</strong>&nbsp;<br />ข้อมูลบน verztec.com มีการรวบรวมในสองรูปแบบ คือ&nbsp;<br />(1) แบบโดยอ้อม (ตัวอย่างเช่น ผ่านเทคโนโลยีของไซต์ของเรา) และ&nbsp;<br />(2) แบบโดยตรง (ตัวอย่างเช่น เมื่อคุณให้ข้อมูลในหน้าต่างๆของ verztec.com)</p>\r\n<p align=\"justify\">ตัวอย่างหนึ่งของข้อมูลที่เรารวบรวมแบบโดยอ้อมคือ ผ่านบันทึกการเข้าถึง<br />อินเทอร์เน็ตของเรา เมื่อคุณเข้าถึง verztec.com ที่อยู่อินเทอร์เน็ตของคุณ<br />จะถูกรวบรวมโดยอัตโนมัติและนำไปวางไว้ในบันทึกการเข้าถึงอินเทอร์เน็ตของเรา</p>\r\n<p align=\"justify\">เรารวบรวมข้อมูลจากคุณโดยตรงในหลายวิธีด้วยกัน ซึ่งเราจะยกเพียงบางตัวอย่างในประกาศความเป็นส่วนตัวนี้ วิธีหนึ่งก็คือผ่านการใช้คุกกี้ คุกกี้เป็นไฟล์ข้อมูล<br />ขนาดเล็กที่บันทึกและเรียกข้อมูลเกี่ยวกับการเยี่ยมชม verztec.com ของคุณ<br />ตัวอย่างเช่น วิธีการเข้าสู่ไซต์ของเรา วิธีการที่คุณนำทางไปมาทั่วทั้งไซต์ และ<br />ข้อมูลใดที่เป็นที่สนใจสำหรับคุณ คุกกี้ที่เราใช้ระบุตัวตนคุณเป็นเพียงตัวเลขเท่านั้น<br />(ถ้าคุณไม่สะดวกใจกับการใช้คุกกี้ โปรดจำไว้ว่า คุณสามารถปิดใช้งานคุกกี้บนเครื่องคอมพิวเตอร์ของคุณโดยการเปลี่ยนการตั้งค่าในเมนูการกำหนดลักษณะหรือตัวเลือกในเบราว์เซอร์ของคุณ)</p>\r\n<p align=\"justify\">เราจะรวบรวมข้อมูลที่คุณสมัครใจส่งมาให้เราด้วยเช่นกัน ทั่วทั้งไซต์ เราจะเปิดโอกาสให้คุณลงทะเบียนกิจกรรมหรือการประชุม สั่งเอกสารรายงานข้อเท็จจริง หรือเข้าร่วมในการสำรวจออนไลน์ เมื่อเรารวบรวมข้อมูลชนิดนี้ เราจะแจ้งให้คุณทราบว่าเหตุใดเราจึงขอข้อมูลดังกล่าวและเราจะนำข้อมูลดังกล่าวไปใช้อย่างไร ทั้งนี้ขึ้นอยู่กับคุณคนเดียวว่าคุณต้องการจะให้ข้อมูลดังกล่าวแก่เราหรือไม่</p>\r\n<p align=\"justify\">&nbsp;</p>\r\n<p align=\"justify\"><strong>เรานำ้ข้อมูลนี้ไปใช้้อย่างไร?<br /></strong>เราจะนำข้อมูลมาวิเคราะห์เพื่อหาว่าสิ่งใดมีประสิทธิภาพที่สุดสำหรับไซต์ของเรา<br />เพื่อช่วยให้เราค้นหาหนทางปรับปรุงไซต์และเพื่อหาวิธีปรับแต่ง verztec.com<br />เพื่อทำให้ไซต์ของเรา้มีประสิทธิภาพมากยิ่งขึ้น เราอาจใช้ข้อมูลเพื่อจุดประสงค์อื่นด้วยเ่ช่นกัน ซึ่งเราจะอธิบายให้คุณทราบในจุดที่เราทำการรวบรวมข้อมูล</p>\r\n<p align=\"justify\">&nbsp;</p>\r\n<p><strong>เราจะแบ่งปันข้อมูลกับบุคคลภายนอกหรือไม่?<br /></strong>ในฐานะองค์กรระดับโลก ข้อมูลที่เรารวบรวมได้อาจได้รับการถ่ายโอนระหว่างประเทศผ่านองค์กรของ Verztec ที่มีอยู่ทั่วโลก เราจะไม่ขายข้อมูลส่วนบุคคล<br />และจะแบ่งปันข้อมูลกับที่ปรึกษาของเราเท่านั้น อาจมีบางครั้งที่เราจำเป็นต้อง<br />แบ่งปันข้อมูล เช่น คุกกี้ในกรณีมีการจัดกิจกรรมซึ่งเราจำเป็นต้องให้ข้อมูลลักษณะอาหารที่ต้องการแก่ผู้ให้บริการจัดเลี้ยงนอกสถานที่ของเรา แต่ก็เช่นเดิม ก่อนที่เราจะส่งข้อมูลใดๆ เราจะแจ้งให้คุณทราบว่าเหตุใดเราจึงขอข้อมูลนั้น ทั้งนี้ขึ้นอยู่กับคุณคนเดียวว่าคุณต้องการจะให้ข้อมูลดังกล่าวแก่เราหรือไม่</p>\r\n<p>&nbsp;</p>\r\n<p><strong>แล้วข้อมูลส่วนบุคคลที่ละเอียดอ่อนล่ะ?&nbsp;<br /></strong>โดยทั่วไป เราจะไม่ขอรวบรวมข้อมูลส่วนบุคคลที่ละเอียดอ่อนผ่านไซต์นี้ ถ้าเราจะขอรวบรวมข้อมูลดังกล่าว เราจะขอให้คุณเห็นชอบในจุดประสงค์ของการนำข้อมูลไปใช้ก่อน</p>\r\n<p>&nbsp;</p>\r\n<p><strong>แล้วความปลอดภัยของข้อมูลเป็นอย่างไร?<br /></strong>เราดำเนินการตามขั้นตอนที่เหมาะสมเพื่อรักษาความปลอดภัยข้อมูลของคุณบน verztec.com คุณควรเข้าใจว่าลักษณะที่เปิดกว้างของอินเทอร์เน็ตอาจทำให้ข้อมูลดังกล่า่วไหลผ่านไปยังเครือข่ายต่างๆ โดยไม่มีมาตรการรักษาความปลอดภัย<br />และอาจมีบุคคลอื่น นอกเหนือจากที่ได้กำหนดไว้ เข้าถึงและนำข้อมูลของคุณไปใช้</p>\r\n<p>ถ้ามีข้อสงสัยในตอนนี้หรือระหว่างการเยี่ยมชมเว็บไซต์ กรุณาติดต่อหาเรา</p>', '<p>This website is administered by Verztec Consulting Pte Ltd.</p>\r\n<p>The following provides an overview of how we protect your privacy during your visit.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>What information do we gather?</strong></p>\r\n<p>Information on verztec.com is gathered in two ways: (1) indirectly (for example, through our site\'s technology); and (2) directly (for example, when you provide information on various pages of verztec.com).</p>\r\n<p>One example of information we collect indirectly is through our Internet access logs. When you access verztec.com, your Internet address is automatically collected and is placed in our Internet access logs.</p>\r\n<p>We collect information directly from you in a number of ways, some of which we describe in this Privacy Statement. One way is through the use of cookies. Cookies are small files of information which save and retrieve information about your visit to verztec.com&mdash;for example, how you entered our site, how you navigated through the site, and what information was of interest to you. The cookies we use identify you merely as a number. (If you are uncomfortable regarding cookies use, please keep in mind you can disable cookies on your computer by changing the settings in preferences or options menu in your browser.)</p>\r\n<p>We also collect information when you voluntarily submit it to us. Throughout our site, we provide the opportunity to register for an event or conference, order a white paper, or participate in an online survey. When we collect this type of information, we will notify you as to why we are asking for information and how this information will be used. It is completely up to you whether or not you want to provide it.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>How do we use this information?</strong></p>\r\n<p>We analyze it to determine what is most effective about our site, to help us identify ways to improve it, and eventually, to determine how we can tailor verztec.com to make it more effective. We may also use data for other purposes, which we would describe to you at the point we collect the information.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Will we share this with outside parties?</strong></p>\r\n<p>As a global organization, data we collect may be transferred internationally throughout Verztec\'s worldwide organization. We will not sell individual information and will share it only with our advisors. There will be other times when we need to share information, for example, in the case of an event where we need to provide our caterer with meal preference information. But again, before you submit any information, we will notify you as to why we are asking for specific information and it is completely up to you whether or not you want to provide it.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>What about sensitive personal data?</strong></p>\r\n<p>We do not generally seek to collect sensitive personal data through this site. If we do seek to collect such data, we will ask you to consent to our proposed uses of the data.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>What about data security?</strong></p>\r\n<p>We take appropriate steps to maintain the security of your data on verztec.com. You should understand that the open nature of the Internet is such that data may flow over networks without security measures and may be accessed and used by people other than those for whom the data is intended.</p>\r\n<p>If you have any questions now or during your visit, please contact us.</p>', '<p align=\"justify\">このWebサイトは Verztec Consulting Pte Ltd によって管理されています。</p>\r\n<p align=\"justify\">本サイトのアクセス中にプライバシーを保護する方法に関する概要を以下で説明します。</p>\r\n<p align=\"justify\">&nbsp;</p>\r\n<p align=\"justify\"><strong>収集する情報は?</strong></p>\r\n<p>verztec.com の情報は次の2つの方法で収集されます。(1) 間接的 (例えば、当社サイトのテクノロジーを介して)、(2) 直接的 (例えば、verztec.com の前のページに情報を提供する場合)。</p>\r\n<p align=\"justify\">間接的に収集する情報の1つの例はインターネットアクセスログからです。verztec.com にアクセスする場合に、インターネットアドレスは自動的の収集されてインターネットアクセスログに保存されます。</p>\r\n<p align=\"justify\">このプライバシーに関する声明で説明しているような多数の方法で直接情報を収集します。1つの方法はクッキーの使用からです。クッキーは、verztec.com のアクセスに関する情報を保存および取得する情報の小さなファイルです、例えば、サイトにどのように入ったか、サイトでどのように操作したか、興味のある情報は何か。使用するクッキーは番号としてユーザーを識別します。(クッキーを使用したくない場合は、ブラウザのオプションメニューで設定を変更してコンピュータのクッキーを無効にすることができます。)</p>\r\n<p align=\"justify\">自発的に送信する場合でも情報を収集します。当社サイトから、イベントや会議、ホワイトペーパーの注文、またはオンライン調査の参加への登録を行なうことができます。このタイプの情報を収集する場合に、情報を収集する理由とその使用方法について通知します。提供するかどうかはご自身次第です。</p>\r\n<p align=\"justify\">&nbsp;</p>\r\n<p align=\"justify\"><strong>この情報の使用方法は?</strong></p>\r\n<p>それを分析して、当社サイトで最も効果的なものを決定して改善する方法を識別して、verztec.com をより効果的にするのに使用します。また他の目的にデータを使用する場合もあります。これに関しては情報を収集する時点で説明します。</p>\r\n<p>&nbsp;</p>\r\n<p align=\"justify\"><strong>外部のパートナーとこれを共有しますか?</strong></p>\r\n<p>全体的な組織として、収集するデータは Verztec の世界的な組織を通して内部的に転用される場合があります。個人情報を販売することはなく、当社アドバイザーのみと共有することになります。他の場合に情報を共有する場合があります。例えば、仕出屋に好みの食事情報を提供する必要がある場合。但し情報を提供する前に、特定の情報を要求している理由を通知します。情報を提供するかどうかはご自身の判断によります。</p>\r\n<p>&nbsp;</p>\r\n<p align=\"justify\"><strong>極秘個人データとは?</strong></p>\r\n<p>このサイトを通して極秘個人データを収集することを通常は求めていません。このようなデータを収集する必要がある場合は、データの提案した使用に対する承認を要求します。</p>\r\n<p>&nbsp;</p>\r\n<p align=\"justify\"><strong>データセキュリティとは?</strong></p>\r\n<p>verztec.com のデータのセキュリティを維持するために適切な処理を行なっています。インターネットのオープンネイチャによって、セキュリティ対策なしでのネットワーク上ではデータがフローする可能性があるので、データを必要とする以外の人によってアクセスおよび使用される可能性があります。</p>\r\n<p align=\"justify\">ご質問がございましたら当社までご連絡ください。</p>', 'บริษัท อีซูซุมอเตอร์สเอเซีย (ประเทศไทย) จำกัด', 'Isuzu Motors Asia (Thailand) Co., Ltd.', '90 อาคารซีดับเบิ้ลยู ทาวเวอร์ เอ ชั้น 40 ห้องเลขที่ เอ 4001-2 ถ.รัชดาภิเษก แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10310 (รถไฟฟ้าใต้ดิน สถานีศูนย์วัฒนธรรมแห่งประเทศไทย ทางออกที่ 1 หรือ 4)', '90 CW Tower A, 40th Floor, Unit 4001-2, Ratchadaphisek Rd, Huai Khwang, Bangkok 10310 (MRT Thailand Cultural Center Station, Exit no. 1 or 4)', '02-168-3390', '02-168-3390', 'https://www.isuzu.co.th/', 'info@isuzu.or.th', 'info@isuzu.or.th', 'Learning Management System by Isuzu Motors Asia (Thailand) Co., Ltd.', '', '', '', '', 'C:\\xampp\\tmp\\php6A3C.tmp', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_ABOUT_BAN`
--

CREATE TABLE `LMS_ABOUT_BAN` (
  `id` bigint(10) NOT NULL,
  `banner` text NOT NULL,
  `time_created` datetime NOT NULL,
  `hidden` int(1) NOT NULL DEFAULT '1',
  `emp_c` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_ABOUT_BAN`
--

INSERT INTO `LMS_ABOUT_BAN` (`id`, `banner`, `time_created`, `hidden`, `emp_c`) VALUES
(1, 'banner_20200130145211.jpg', '2020-01-30 14:52:11', 1, '1229900480178'),
(3, 'banner_20200130145337.jpg', '2020-01-30 14:53:37', 1, '1229900480178');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_BAD`
--

CREATE TABLE `LMS_BAD` (
  `badges_id` bigint(10) UNSIGNED NOT NULL,
  `courses_id` bigint(10) UNSIGNED NOT NULL,
  `badges_name` varchar(100) NOT NULL,
  `badges_desc` text NOT NULL,
  `badges_img` text NOT NULL,
  `badges_condition` mediumtext NOT NULL,
  `time_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_BAD`
--

INSERT INTO `LMS_BAD` (`badges_id`, `courses_id`, `badges_name`, `badges_desc`, `badges_img`, `badges_condition`, `time_create`) VALUES
(1, 1, 'ทดสอบใบประกาศนีย์บัตร', 'ฟหหฟกฟหก', 'cog_20200131140737.jpg', 'pass', '2020-02-06 18:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_BAN`
--

CREATE TABLE `LMS_BAN` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `banner` text NOT NULL,
  `time_created` datetime NOT NULL,
  `hidden` int(2) NOT NULL DEFAULT '1',
  `emp_c` varchar(50) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_BAN`
--

INSERT INTO `LMS_BAN` (`id`, `banner`, `time_created`, `hidden`, `emp_c`, `com_id`) VALUES
(8, '20200124053401.jpg', '0000-00-00 00:00:00', 1, '', 18),
(9, '20200124053409.jpg', '0000-00-00 00:00:00', 1, '', 18),
(10, '20200124053443.jpg', '0000-00-00 00:00:00', 1, '', 18),
(11, '20200124124529.jpg', '0000-00-00 00:00:00', 1, '', 3),
(12, '20200124124536.jpg', '0000-00-00 00:00:00', 1, '', 3),
(13, '20200124124546.jpg', '0000-00-00 00:00:00', 1, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_BAN_COS`
--

CREATE TABLE `LMS_BAN_COS` (
  `bc_id` bigint(50) NOT NULL,
  `bc_name` varchar(255) NOT NULL,
  `bc_image` varchar(255) NOT NULL,
  `bc_type` int(1) NOT NULL DEFAULT '1' COMMENT '1 = คอร์สทั้งหมด,2 = คอร์สของฉัน',
  `bc_status` int(1) NOT NULL DEFAULT '1',
  `bc_isDelete` int(1) NOT NULL DEFAULT '0',
  `bc_createby` varchar(50) NOT NULL,
  `bc_createdate` datetime NOT NULL,
  `bc_modifiedby` varchar(50) NOT NULL,
  `bc_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_CERTIFICATE`
--

CREATE TABLE `LMS_CERTIFICATE` (
  `cert_id` bigint(10) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `cert_file` varchar(250) NOT NULL,
  `cert_date` date NOT NULL,
  `cert_createtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COG`
--

CREATE TABLE `LMS_COG` (
  `cg_id` int(11) NOT NULL,
  `cgcode` varchar(100) DEFAULT NULL,
  `cgtitle_th` varchar(255) NOT NULL,
  `cgdesc_th` text,
  `cgtitle_en` varchar(255) NOT NULL,
  `cgdesc_en` text NOT NULL,
  `cgtitle_jp` varchar(255) NOT NULL,
  `cgdesc_jp` text NOT NULL,
  `cg_approve_by` varchar(50) NOT NULL,
  `cgthumb` varchar(255) DEFAULT NULL,
  `c_date` datetime NOT NULL,
  `c_by` varchar(50) NOT NULL,
  `u_date` datetime DEFAULT NULL,
  `u_by` varchar(50) DEFAULT NULL,
  `cg_status` int(1) NOT NULL DEFAULT '1',
  `cg_approve` int(1) NOT NULL DEFAULT '0',
  `cg_isDelete` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COG`
--

INSERT INTO `LMS_COG` (`cg_id`, `cgcode`, `cgtitle_th`, `cgdesc_th`, `cgtitle_en`, `cgdesc_en`, `cgtitle_jp`, `cgdesc_jp`, `cg_approve_by`, `cgthumb`, `c_date`, `c_by`, `u_date`, `u_by`, `cg_status`, `cg_approve`, `cg_isDelete`) VALUES
(1, NULL, 'เทคโนโลยีสารสนเทศ', '', 'IT', '', 'IT', '', '1', 'cog_20200130164930.jpg', '2020-01-30 16:49:30', '1229900480178', '2020-02-06 17:37:10', '1', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COMPANY`
--

CREATE TABLE `LMS_COMPANY` (
  `com_id` bigint(50) NOT NULL,
  `com_code` varchar(5) NOT NULL COMMENT 'อักษรย่อ',
  `com_name_th` varchar(250) NOT NULL,
  `com_name_eng` varchar(250) NOT NULL,
  `com_emaildomain` varchar(255) NOT NULL,
  `com_add_th` text NOT NULL,
  `com_add_eng` text NOT NULL,
  `com_tel` varchar(200) NOT NULL,
  `com_fax` varchar(200) NOT NULL,
  `com_mail` varchar(200) NOT NULL,
  `com_admin` varchar(50) NOT NULL COMMENT 'com_central,com_associated',
  `com_bgpic_user` varchar(255) NOT NULL,
  `com_logo_top` varchar(255) NOT NULL,
  `com_logo_footer` varchar(255) NOT NULL,
  `com_status` int(1) NOT NULL DEFAULT '1',
  `com_isDelete` int(1) NOT NULL DEFAULT '0',
  `com_createby` varchar(50) NOT NULL,
  `com_createdate` datetime NOT NULL,
  `com_modifiedby` varchar(50) NOT NULL,
  `com_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COMPANY`
--

INSERT INTO `LMS_COMPANY` (`com_id`, `com_code`, `com_name_th`, `com_name_eng`, `com_emaildomain`, `com_add_th`, `com_add_eng`, `com_tel`, `com_fax`, `com_mail`, `com_admin`, `com_bgpic_user`, `com_logo_top`, `com_logo_footer`, `com_status`, `com_isDelete`, `com_createby`, `com_createdate`, `com_modifiedby`, `com_modifieddate`) VALUES
(2, '', 'Verztec', 'Verztec', '', 'Bangkok', '', '024501121', '0625142995', 'comtion35@gmail.com', 'com_central', '', '20190618073059.png', '', 1, 0, '', '2018-11-20 13:46:42', '', '0000-00-00 00:00:00'),
(3, 'IMAT', 'บริษัท อีซูซุมอเตอร์สเอเซีย (ประเทศไทย) จำกัด', 'Isuzu Motors Asia (Thailand) Co., Ltd.', '', '90 อาคารซีดับเบิ้ลยู ทาวเวอร์ เอ ชั้น 40 ห้องเลขที่ เอ 4001-2 ถ.รัชดาภิเษก แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10310 (รถไฟฟ้าใต้ดิน สถานีศูนย์วัฒนธรรมแห่งประเทศไทย ทางออกที่ 1 หรือ 4)', '90 CW Tower A, 40th Floor, Unit 4001-2, Ratchadaphisek Rd, Huai Khwang, Bangkok 10310 (MRT Thailand Cultural Center Station, Exit no. 1 or 4)', '02-168-3390', '02-168-3390', '', 'com_central', '', '', '', 1, 0, '1', '2020-01-24 10:29:06', '1', '2020-01-29 15:27:34'),
(5, 'ITA', 'บริษัท อีซูซุเทคนิคัลเซ็นเตอร์เอเซีย จำกัด', 'Isuzu Technical Center of Asia Co., Ltd.', '', '38 ถ.ปู่เจ้าสมิงพราย ต.สำโรงใต้ อ.พระประแดง จ.สมุทรปราการ 10130', '38 Poochaosamingprai Rd., Samrongtai, Phrapradaeng, Samutprakarn 10130', '02-394-2541', '02-394-2541', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:43:45', '1', '2020-01-29 15:27:22'),
(6, 'IGCE', 'บริษัท อีซูซุ โกลบอล ซีวี เอ็นจิเนียริ่ง เซ็นเตอร์ จำกัด', 'Isuzu Global CV Engineering Center Co., Ltd.', '', '90 อาคารซีดับเบิ้ลยู ทาวเวอร์ เอ ชั้นที่ 37, 40 ถ.รัชดาภิเษก แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10310', '90 CW Tower A, 37th and 40th Floor, Ratchadapisek Rd., Huai Khwang, Bangkok 10310 THAILAND', '02-168-3340', '02-168-3340', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:47:01', '1', '2020-01-29 15:27:14'),
(7, 'IMCT', 'บริษัท อีซูซุมอเตอร์ (ประเทศไทย) จำกัด', 'Isuzu Motors Co., (Thailand) Ltd.', '', '38 ก. หมู่ 9 ถ.ปู่เจ้าสมิงพราย ต.สำโรงใต้ อ.พระประแดง จ.สมุทรปราการ 10130', '38 Kor., Moo 9, Poochaosamingprai Rd., Samrongtai, Phrapradaeng, Samutprakarn 10130', ' 02-394-2541 -50', ' 02-394-2541 -50', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:47:50', '1', '2020-01-29 15:27:06'),
(8, 'IEMT', 'บริษัท อีซูซุเอ็นยิ่น แมนูแฟคเจอริ่ง (ประเทศไทย) จำกัด', 'Isuzu Engine Manufacturing Co., (Thailand) Ltd.', '', '131, 133 ซ.ฉลองกรุง 31 ถ.ฉลองกรุง แขวงลำปลาทิว เขตลาดกระบัง กรุงเทพฯ 10520', '131, 133 Soi Chalongkrung 31, Chalongkrung Rd., Lamplatew, Ladkrabang, Bangkok 10520', '02-326-1190', '02-326-1190', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:48:44', '1', '2020-01-29 15:26:58'),
(9, 'TID', 'บริษัท ไทยอินเตอร์เนชั่นแนล ได เมคกิ้ง จำกัด', 'Thai International Die Making Co., Ltd.', '', 'นิคมอุตสาหกรรมบางปู 331 หมู่ 4 ถ.สุขุมวิท ต.แพรกษา อ.เมือง จ.สมุทรปราการ 10280', '331 Moo 4, Bangpoo Industrial Estate, Sukhumvit Rd., Praksa, Muang, Samutprakarn 10280', '02-709-6500', '02-709-6500', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:49:29', '1', '2020-01-29 15:26:48'),
(10, 'ITF', 'บริษัท ไอที ฟอร์จิ้ง (ประเทศไทย) จำกัด', 'IT Forging (Thailand) Co., Ltd.', '', 'นิคมอุตสาหกรรม สยามอีสเทิร์น อินดัสเตรียล ปาร์ค 60/7 หมู่ 3 ต.มาบยางพร อ.ปลวกแดง จ.ระยอง 21140', 'Siam Eastern Industrial Park 60/7 Moo 3, Mabyangporn, Pluakdaeng, Rayong 21140', '038-891380-90', '038-891380-90', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:50:22', '1', '2020-01-29 15:26:40'),
(11, 'SUTT', 'บริษัท โชนัน ยูนิเทค (ประเทศไทย) จำกัด', 'Shonan Unitec (Thailand) Co., Ltd.', '', '3 หมู่ 7 ถ.กิ่งแก้ว-ลาดกระบัง ต.ราชเทวะ อ.บางพลี จ.สมุทรปราการ 10540', '3 Moo 7, Kingkaew-Ladkrabang Rd., Rachathewa, Bangplee, Samutprakarn 10540', '02-738-4551-4', '02-738-4551-4', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:51:06', '1', '2020-01-29 15:26:32'),
(12, 'IJTT', 'บริษัท ไอเจทีที (ประเทศไทย) จำกัด', 'IJTT (Thailand) Co., Ltd.', '', 'นิคมอุตสาหกรรมอมตะนคร 700/14 หมู่ 6 กม.ที่ 57 ถ.บางนาตราด ต.หนองไม้แดง อ.เมือง จ.ชลบุรี 20000', 'Amata Nakorn Industrial Estate 700/14 Moo 6, KM. 57th, Bangna-Trad Rd., Nongmaidaeng, Muang Chonburi 20000', '038-213-027-9', '038-213-027-9', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:51:51', '1', '2020-01-29 15:26:25'),
(13, 'HCAT', 'บริษัท ฮิตาชิ เคมีคัล ออโตโมทีฟ โปรดักส์ (ประเทศไทย) จำกัด', 'Hitachi Chemical Automotive Products (Thailand) Co.,Ltd.', '', 'เขตประกอบการสยามอีสเทิร์น อินดัสเตรียลพาร์ค 60/11 หมู่ 3 ต.มาบยางพร อ.ปลวกแดง จ.ระยอง 21140', 'Siam Eastern Industrial Park 60/11 Moo 3, Soi 4, T.Mabyangporn A.Pluakdaeng, Rayong 21140', '038-015-020', '038-015-020', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:52:41', '1', '2020-01-29 15:26:16'),
(14, 'KDI', 'บริษัท เคดีไอ เซอร์วิส แอนด์ เทคโนโลยี จำกัด', 'KDI Services & Technologies Co., Ltd.', '', '300/154 หมู่ 1 ต.ตาสิทธิ์ อ.ปลวกแดง จ.ระยอง 21140', '300/154 Moo 1, Tasit, Pluakdaeng, Rayong 21140', '033-012-541', '033-012-541', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:53:36', '1', '2020-01-29 15:26:08'),
(15, 'ILAT', 'บริษัท อีซูซุโลจิสติกส์เอเซีย (ประเทศไทย) จำกัด', 'Isuzu Logistics Asia (Thailand) Co.,Ltd.', '', '38 ก ถนน ปู่เจ้าสมิงพราย ตำบล สำโรงใต้ อำเภอ พระประแดง จังหวัด สมุทรปราการ', '38 Kor.,Moo 9, Poochaosamingprai Rd., Samrongtai, Phrapradaeng, Samutprakarn 10130', '02-380-6414', '02-380-6414', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:54:23', '1', '2020-01-29 15:25:59'),
(16, 'IMIT', 'บริษัท อีซูซุมอเตอร์ อินเตอร์เนชั่นแนล โอเปอเรชั่น (ประเทศไทย) จำกัด', 'Isuzu Motors International Operations (Thailand) Co.,Ltd.', '', '1010 อาคารชินวัตรทาวเวอร์ 3 ชั้น 24-25 ถ.วิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '1010 Shinawatra Tower III, 24th - 25th floor, Vibhavadi Rangsit road, Chatuchak, Bangkok 10900', '02-966-2626', '02-966-2626', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:55:16', '1', '2020-01-29 15:25:51'),
(17, 'ICLT', 'บริษัท ไอซีแอล (ประเทศไทย) จำกัด', 'ICL (Thailand) Co., Ltd.', '', '555/51 หมู่ 10 อาคารบุษยมาส 2 ชั้น 4 ถ.ปู่เจ้าสมิงพราย ต.สำโรงใต้ อ.พระประแดง จ.สมุทรปราการ 10131', '555/51 Moo 10, Busayamas Tower II 4th Floor Poochaosamingprai Rd., Samrongtai, Phrapradaeng, Samutprakarn 10131', '02-380-5086', '02-380-5086', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:55:57', '1', '2020-01-29 15:25:40'),
(18, 'IBCT', 'บริษัท อีซูซุ บอดี้ คอร์ปอเรชั่น (ประเทศไทย) จำกัด', 'Isuzu Body Corporation (Thailand) Ltd.', 'ibct.isuzu.co.th', 'นิคมอุตสาหกรรมเกตเวย์ซิตี้ 214/1 หมู่ 7 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190', 'Gateway City Industrial Estate 214/1 Moo 7, Huasamrong, Plaeng-Yao, Chachoengsao 24190', '038-086-195-98', '038-086-195-98', '', 'com_associated', '', '', '', 1, 0, '1', '2020-01-24 10:56:41', '1', '2020-02-06 17:46:09'),
(19, 'ITT', 'บริษัท อีซูซุ เทคโน (ประเทศไทย) จำกัด', 'Isuzu Techno (Thailand) Co., Ltd. ', 'itt.isuzu.co.th', '', '', '', '', '', 'com_associated', '', '', '', 1, 0, '1', '2020-02-06 18:50:05', '1', '2020-02-06 18:50:05'),
(20, 'KICT', 'บริษัท โคเกอิ อินเทค (ประเทศไทย) จำกัด', 'Kogei Intec (Thailand) Co., Ltd.', 'kict.isuzu.co.th', '', '', '', '', '', 'com_associated', '', '', '', 1, 0, '1', '2020-02-06 18:50:36', '1', '2020-02-06 18:50:36'),
(21, 'LNXI', 'บริษัท ไลเน็กซ์ อินเตอร์เนชั่นแนล (ประเทศไทย) จำกัด', 'Linex International (Thailand) Co., Ltd.', 'lnxi.isuzu.co.th', '', '', '', '', '', 'com_central', '', '', '', 1, 0, '1', '2020-02-06 18:50:59', '1', '2020-02-06 18:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_CONTENT`
--

CREATE TABLE `LMS_CONTENT` (
  `con_id` bigint(50) NOT NULL,
  `con_title_th` varchar(255) NOT NULL,
  `con_title_en` varchar(255) NOT NULL,
  `con_detail_th` text NOT NULL,
  `con_detail_en` text NOT NULL,
  `con_datestart` datetime NOT NULL,
  `con_dateend` datetime NOT NULL,
  `con_status` int(1) NOT NULL DEFAULT '1',
  `con_IsDelete` int(1) NOT NULL DEFAULT '0',
  `con_createby` varchar(50) NOT NULL,
  `con_createdate` datetime NOT NULL,
  `con_modifiedby` varchar(50) NOT NULL,
  `con_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS`
--

CREATE TABLE `LMS_COS` (
  `cos_id` bigint(50) UNSIGNED NOT NULL,
  `ccode` varchar(15) NOT NULL,
  `cos_lang` varchar(50) NOT NULL COMMENT 'รองรับภาษา',
  `com_id` bigint(50) DEFAULT NULL,
  `cname_th` varchar(250) DEFAULT NULL,
  `cdesc_th` text,
  `cname_eng` varchar(250) DEFAULT NULL,
  `cdesc_eng` text,
  `sub_description_th` text COMMENT 'คำอธิบายย่อย',
  `sub_description_eng` text COMMENT 'คำอธิบายย่อย',
  `cname_jp` varchar(250) DEFAULT NULL,
  `cdesc_jp` text,
  `sub_description_jp` text,
  `cos_pic` varchar(200) DEFAULT 'default_profile.jpg',
  `max_score` decimal(10,0) DEFAULT NULL,
  `goal_score` decimal(10,0) DEFAULT NULL,
  `seat_count` int(50) NOT NULL,
  `condition` varchar(50) DEFAULT NULL,
  `cos_typegrading` int(1) NOT NULL COMMENT '1 = grade,2 = pass',
  `tc_id` bigint(50) DEFAULT NULL,
  `cos_rating` int(5) NOT NULL,
  `cos_public` int(1) NOT NULL,
  `cos_hour` int(3) DEFAULT NULL,
  `cos_approve` int(1) NOT NULL DEFAULT '0',
  `cos_status` int(1) NOT NULL DEFAULT '1',
  `cos_isDelete` int(1) NOT NULL DEFAULT '0',
  `cos_createby` varchar(50) NOT NULL,
  `cos_createdate` datetime NOT NULL,
  `cos_modifiedby` varchar(50) NOT NULL,
  `cos_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COS`
--

INSERT INTO `LMS_COS` (`cos_id`, `ccode`, `cos_lang`, `com_id`, `cname_th`, `cdesc_th`, `cname_eng`, `cdesc_eng`, `sub_description_th`, `sub_description_eng`, `cname_jp`, `cdesc_jp`, `sub_description_jp`, `cos_pic`, `max_score`, `goal_score`, `seat_count`, `condition`, `cos_typegrading`, `tc_id`, `cos_rating`, `cos_public`, `cos_hour`, `cos_approve`, `cos_status`, `cos_isDelete`, `cos_createby`, `cos_createdate`, `cos_modifiedby`, `cos_modifieddate`) VALUES
(1, '', 'th,jp', 3, 'ทดสอบการเพิ่มรายวิชา', '', '', '', 'ทดสอบการเพิ่ม', '', 'Test Create course', '', '', 'cog_20200131123217.jpg', NULL, '70', 100, '1', 2, 10, 0, 1, 60, 1, 1, 0, '1', '2020-01-31 12:32:17', '1', '2020-02-06 18:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COSINCG`
--

CREATE TABLE `LMS_COSINCG` (
  `course_id` bigint(10) UNSIGNED DEFAULT NULL,
  `cg_id` int(11) DEFAULT NULL,
  `status_cg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COSINCG`
--

INSERT INTO `LMS_COSINCG` (`course_id`, `cg_id`, `status_cg`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_DETAIL`
--

CREATE TABLE `LMS_COS_DETAIL` (
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `cosde_status` int(1) NOT NULL DEFAULT '1',
  `cosde_isDelete` int(1) NOT NULL DEFAULT '0',
  `cosde_id` bigint(50) NOT NULL,
  `get_point` int(50) NOT NULL,
  `point_redeem` int(50) NOT NULL,
  `cosde_createby` varchar(50) NOT NULL,
  `cosde_createdate` datetime NOT NULL,
  `cosde_modifiedby` varchar(50) NOT NULL,
  `cosde_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COS_DETAIL`
--

INSERT INTO `LMS_COS_DETAIL` (`cos_id`, `date_start`, `date_end`, `cosde_status`, `cosde_isDelete`, `cosde_id`, `get_point`, `point_redeem`, `cosde_createby`, `cosde_createdate`, `cosde_modifiedby`, `cosde_modifieddate`) VALUES
(1, '2020-02-10 11:30:00', '2020-02-28 05:30:00', 1, 1, 3, 0, 0, '1', '2020-02-03 12:57:23', '1', '2020-02-03 17:14:32'),
(1, '2020-02-11 10:27:00', '2020-02-27 05:25:00', 1, 1, 4, 0, 0, '1', '2020-02-03 12:58:48', '1', '2020-02-03 13:04:00'),
(1, '2020-02-11 14:31:00', '2020-02-27 14:31:00', 1, 1, 5, 0, 0, '1', '2020-02-03 14:31:48', '1', '2020-02-03 17:14:04'),
(1, '2020-02-17 07:00:00', '2020-02-28 07:00:00', 0, 0, 6, 0, 0, '1', '2020-02-03 14:34:08', '1', '2020-02-04 14:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_DETAIL_UG`
--

CREATE TABLE `LMS_COS_DETAIL_UG` (
  `cosde_id` bigint(50) DEFAULT NULL,
  `posi_id` bigint(50) DEFAULT NULL,
  `cosdepos_id` bigint(50) NOT NULL,
  `cosdepos_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COS_DETAIL_UG`
--

INSERT INTO `LMS_COS_DETAIL_UG` (`cosde_id`, `posi_id`, `cosdepos_id`, `cosdepos_date`) VALUES
(6, 27, 366, '2020-02-04 14:35:24'),
(6, 29, 367, '2020-02-04 14:35:24'),
(6, 30, 368, '2020-02-04 14:35:24'),
(6, 37, 369, '2020-02-04 14:35:24'),
(6, 38, 370, '2020-02-04 14:35:24'),
(6, 39, 371, '2020-02-04 14:35:24'),
(6, 40, 372, '2020-02-04 14:35:24'),
(6, 49, 373, '2020-02-04 14:35:24'),
(6, 50, 374, '2020-02-04 14:35:24'),
(6, 59, 375, '2020-02-04 14:35:24'),
(6, 60, 376, '2020-02-04 14:35:24'),
(6, 61, 377, '2020-02-04 14:35:24'),
(6, 62, 378, '2020-02-04 14:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_ENROLL`
--

CREATE TABLE `LMS_COS_ENROLL` (
  `cosen_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `cosen_score` decimal(10,2) DEFAULT NULL,
  `cosen_grade` varchar(10) DEFAULT NULL,
  `cosen_reward` decimal(10,2) NOT NULL COMMENT 'Course Reward',
  `cosen_pfm` decimal(10,2) NOT NULL COMMENT 'Points from manager',
  `cosen_timerequest` datetime NOT NULL,
  `emp_approver_a` int(50) NOT NULL,
  `cosen_enroll_status_a` int(1) NOT NULL DEFAULT '0',
  `emp_approver_b` int(50) NOT NULL,
  `cosen_enroll_status_b` int(1) NOT NULL DEFAULT '0',
  `cosen_status` int(1) NOT NULL DEFAULT '0' COMMENT '0 = รอการอนุมัติ,1 = ผู้เรียนปัจจุบัน,2=ยกเลิก',
  `cosen_status_sub` int(1) NOT NULL DEFAULT '0' COMMENT '0 = ยังไม่เริ่ม,1 = เสร็จสมบูรณ์,2 = กำลังเรียน',
  `cosen_cancelnote` text NOT NULL,
  `cosen_firsttime` datetime NOT NULL,
  `cosen_finishtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cosen_modtime` datetime NOT NULL,
  `cosen_rating` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_FIL`
--

CREATE TABLE `LMS_COS_FIL` (
  `fil_cos_id` bigint(10) NOT NULL,
  `cos_id` bigint(10) UNSIGNED NOT NULL,
  `fil_lang` varchar(50) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `name_file` varchar(255) NOT NULL,
  `fil_status` int(1) NOT NULL DEFAULT '1',
  `fil_isDelete` int(1) DEFAULT '0',
  `fil_createby` varchar(50) NOT NULL,
  `fil_createdate` datetime NOT NULL,
  `fil_modifiedby` varchar(50) NOT NULL,
  `fil_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_COS_FIL`
--

INSERT INTO `LMS_COS_FIL` (`fil_cos_id`, `cos_id`, `fil_lang`, `path_file`, `name_file`, `fil_status`, `fil_isDelete`, `fil_createby`, `fil_createdate`, `fil_modifiedby`, `fil_modifieddate`) VALUES
(1, 1, 'th', 'cosdoc_20200131155243.pptx', 'ทดสอบการเพิ่มไฟล์เอกสารเพิ่มเติม', 1, 0, '', '0000-00-00 00:00:00', '1', '2020-01-31 15:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_SORT`
--

CREATE TABLE `LMS_COS_SORT` (
  `coss_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `coss_num` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_COS_VIDEO`
--

CREATE TABLE `LMS_COS_VIDEO` (
  `cosv_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `cosv_type` varchar(50) NOT NULL,
  `cosv_video` varchar(255) NOT NULL,
  `cosv_thumbnail` varchar(255) NOT NULL,
  `cosv_th` varchar(255) NOT NULL,
  `cosv_en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_CUG`
--

CREATE TABLE `LMS_CUG` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `course_id` bigint(10) UNSIGNED NOT NULL,
  `mina` decimal(10,0) UNSIGNED NOT NULL,
  `minb` decimal(10,0) UNSIGNED NOT NULL,
  `minc` decimal(10,0) UNSIGNED NOT NULL,
  `mind` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Grade';

--
-- Dumping data for table `LMS_CUG`
--

INSERT INTO `LMS_CUG` (`id`, `course_id`, `mina`, `minb`, `minc`, `mind`) VALUES
(1, 1, '70', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_DEPART`
--

CREATE TABLE `LMS_DEPART` (
  `dep_id` bigint(50) NOT NULL,
  `dep_name_th` varchar(250) NOT NULL,
  `dep_name_en` varchar(250) NOT NULL,
  `com_id` bigint(50) NOT NULL,
  `dep_remark` text NOT NULL,
  `dep_status` int(1) NOT NULL DEFAULT '1',
  `dep_isDelete` int(1) NOT NULL DEFAULT '0',
  `dep_createdate` datetime NOT NULL,
  `dep_createby` varchar(50) NOT NULL,
  `dep_modifiedby` varchar(50) NOT NULL,
  `dep_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_DEPART`
--

INSERT INTO `LMS_DEPART` (`dep_id`, `dep_name_th`, `dep_name_en`, `com_id`, `dep_remark`, `dep_status`, `dep_isDelete`, `dep_createdate`, `dep_createby`, `dep_modifiedby`, `dep_modifieddate`) VALUES
(9, 'Programmer', '', 2, 'ทดสอบบันทึกข้อมูล', 0, 0, '2018-11-20 14:35:05', '', '', '0000-00-00 00:00:00'),
(17, 'PROGRAMMER', 'PROGRAMMER', 2, '', 1, 0, '2019-06-18 14:59:15', '', '', '0000-00-00 00:00:00'),
(20, 'HR', 'HR', 5, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(21, 'HR13', 'HR13', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(22, 'HR23', 'HR23', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(23, 'HR33', 'HR33', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(24, 'HR43', 'HR43', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(25, 'HR53', 'HR53', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(26, 'HR63', 'HR63', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(27, 'HR73', 'HR73', 3, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(28, 'HR16', 'HR16', 6, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(29, 'HR26', 'HR26', 6, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(30, 'HR36', 'HR36', 6, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(31, 'HR46', 'HR46', 6, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(32, 'HR56', 'HR56', 6, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(33, 'HR17', 'HR17', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(34, 'HR27', 'HR27', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(35, 'HR37', 'HR37', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(36, 'HR47', 'HR47', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(37, 'HR57', 'HR57', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(38, 'HR67', 'HR67', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(39, 'HR77', 'HR77', 7, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(40, 'HR18', 'HR18', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(41, 'HR28', 'HR28', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(42, 'HR38', 'HR38', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(43, 'HR48', 'HR48', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(44, 'HR58', 'HR58', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(45, 'HR68', 'HR68', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(46, 'HR78', 'HR78', 8, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(47, 'HR19', 'HR19', 9, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(48, 'HR29', 'HR29', 9, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(49, 'HR39', 'HR39', 9, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(50, 'HR49', 'HR49', 9, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(51, 'HR59', 'HR59', 9, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(52, 'HR110', 'HR110', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(53, 'HR210', 'HR210', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(54, 'HR310', 'HR310', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(55, 'HR410', 'HR410', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(56, 'HR510', 'HR510', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(57, 'HR610', 'HR610', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24'),
(58, 'HR710', 'HR710', 10, '', 1, 0, '2020-01-24 15:57:55', '', '1', '2020-01-31 11:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_EMP`
--

CREATE TABLE `LMS_EMP` (
  `emp_id` int(50) NOT NULL,
  `emp_c` varchar(100) NOT NULL,
  `prefix_th` varchar(50) NOT NULL,
  `fname_th` varchar(255) NOT NULL,
  `lname_th` varchar(255) NOT NULL,
  `fullname_th` varchar(250) NOT NULL,
  `prefix_en` varchar(50) NOT NULL,
  `fname_en` varchar(255) NOT NULL,
  `lname_en` varchar(255) NOT NULL,
  `fullname_en` varchar(250) NOT NULL,
  `address_en` text,
  `gender` varchar(100) NOT NULL,
  `birthdate` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `work_phone` varchar(20) DEFAULT NULL,
  `address_th` text,
  `employ_date` date DEFAULT NULL,
  `depart_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT '1',
  `email` varchar(255) DEFAULT NULL,
  `is_manager` int(11) DEFAULT '0',
  `lang` varchar(100) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `c_date` datetime NOT NULL,
  `u_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_EMP`
--

INSERT INTO `LMS_EMP` (`emp_id`, `emp_c`, `prefix_th`, `fname_th`, `lname_th`, `fullname_th`, `prefix_en`, `fname_en`, `lname_en`, `fullname_en`, `address_en`, `gender`, `birthdate`, `phone`, `work_phone`, `address_th`, `employ_date`, `depart_date`, `status`, `email`, `is_manager`, `lang`, `com_id`, `c_date`, `u_date`) VALUES
(1, '1229900480178', 'นาย', 'เจษฎา', 'ดีศิริพรชัย', 'นายเจษฎา ดีศิริพรชัย', 'Mr.', 'Jetsada', 'Deesiripronchai', 'Mr.Jetsada Deesiripronchai', '1 Empire Tower, 45th Floor, Unit 4505, River Wing West\r\nSouth Sathorn Road, Yannawa, Sathorn, Bangkok 10120\r\n', 'Male', '1992-07-30', '0625142995', '026700461-224', '1 ตึกเอ็มไพร์ทาวเวอร์ ชั้น 45 ห้อง 4505 ถนนสาธรใต้ แขวงยานนาวา เขตสาธร กรุงเทพมหานคร 10120', '2018-10-01', '2019-01-31', '1', 'jetsada.d@verztec.com', 1, 'thai', 3, '2018-11-21 09:25:00', '2020-01-27 09:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_FAQ`
--

CREATE TABLE `LMS_FAQ` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `time_created` datetime NOT NULL,
  `time_edit` datetime NOT NULL,
  `emp_c` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_FAQ`
--

INSERT INTO `LMS_FAQ` (`id`, `title`, `lang`, `time_created`, `time_edit`, `emp_c`) VALUES
(2, 'การเข้าใช้งานระบบ', 'thai', '0000-00-00 00:00:00', '2020-01-24 08:57:22', '1229900480178');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_FAQ_Q`
--

CREATE TABLE `LMS_FAQ_Q` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `tid` bigint(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `time_created` datetime NOT NULL,
  `time_edit` datetime NOT NULL,
  `emp_c` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_FAQ_Q`
--

INSERT INTO `LMS_FAQ_Q` (`id`, `tid`, `question`, `answer`, `time_created`, `time_edit`, `emp_c`) VALUES
(2, 2, 'รหัสผู้ใช้งานระบบคืออะไร?', '<p>○ รหัสผ่านตั้งต้น คือ Init1234<br />○ หลังจาก Log in ครั้งแรกแล้วให้ท่านเปลี่ยนรหัสเป็นรหัสที่ท่านต้องการ</p>', '0000-00-00 00:00:00', '2019-01-17 10:05:34', '1229900480178'),
(3, 2, 'กรณีรับพนักงานใหม่ จะสามารถเพิ่มชื่อพนักงานใหม่ในระบบ e-Learning ได้อย่างไร?', '<p>○ สามารถทำได้ แต่จำเป็นต้องให้ผู้ดูแลระบบของท่านเป็นผู้ดำเนินการ</p>', '0000-00-00 00:00:00', '2019-01-17 10:06:43', '1229900480178'),
(4, 2, 'รหัสผ่าน (Password) ตั้งต้นสำหรับเข้าใช้งานครั้งแรกของทุกคนคือ?', '<p>○ รหัสผ่านสำหรับการเข้าใช้งานครั้งแรกของทุกท่านคือ Init1234</p>\r\n<p>○ เมื่อเข้าใช้งานครั้งแรก ระบบจะบังคับให้เปลี่ยนรหัสผ่านใหม่เพื่อความปลอดภัย</p>\r\n<p>○ โดยรหัสผ่านใหม่จะต้องมีความยาวตั้งแต่ 8 ตัวอักษรขึ้นไป และต้องประกอบไปด้วยตัวอักษรภาษาอังกฤษตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว และตัวเลขอย่างน้อย 1 ตัว</p>\r\n<p>○ รหัสผ่านใหม่ จะมีอายุ 6 เดือน ระบบจะแจ้งให้เปลี่ยนรหัสผ่านใหม่อีกครั้งเมื่อครบกำหนด</p>', '0000-00-00 00:00:00', '2019-01-17 10:08:28', '1229900480178'),
(5, 2, 'กรณีลืมรหัสผ่าน จะต้องทำอย่างไร?', '<p>○ แจ้งผู้ดูแลระบบภายในกลุ่มบริษัท/สาขาของท่าน เพื่อให้รีเซ็ตรหัสผ่านใหม่ให้อีกครั้ง ○ กรณีที่ท่านใส่รหัสผ่านผิดครบ 5 ครั้ง ระบบจะล็อคบัญชีผู้ใช้งานของท่านโดยอัตโนมัติ กรณีนี้ ท่านต้องส่งอีเมลมายังบริษัท เพื่อปลดล็อคบัญชีผู้ใช้งานให้</p>', '0000-00-00 00:00:00', '2019-01-17 10:02:10', '1229900480178'),
(6, 2, 'หากต้องการเรียนรู้วิชาต่างๆ ในระบบต้องทำอย่างไร?', '<p>○ เมื่อลงชื่อเข้าใช้งานเรียบร้อยแล้ว ท่านสามารถเข้าไปดูรายละเอียดหลักสูตร/วิชาต่างๆ จากเมนู &ldquo;ระบบการเรียนรู้&rdquo; โดยสามารถเลือก กลุ่มงาน, กลุ่มวิชา, หรือรายวิชา ตามสิทธิ์การใช้งาน หลังจากนั้น คลิก &ldquo;ลงทะเบียน&rdquo; เพื่อเข้าเรียนรู้ในหลักสูตร/วิชาที่ต้องการ</p>', '0000-00-00 00:00:00', '2019-01-17 10:02:33', '1229900480178'),
(7, 2, 'เข้าเรียนครบทุกบทเรียนในหลักสูตรแล้ว ทำไมระบบถือว่ายังไม่เสร็จสมบูรณ์?', '○ กรณีหลักสูตร/วิชาที่ลงทะเบียนเรียนมีเนื้อหาเฉพาะบทเรียน เมื่อเรียนรู้ครบทุกบทเรียนแล้ว ระบบจะถือว่าการเรียนรู้ในหลักสูตร/วิชานั้นๆ เสร็จสมบูรณ์แล้ว แต่หากในหลักสูตร/วิชานั้นๆ มีแบบทดสอบก่อนหรือหลังบทเรียนด้วย ผู้เรียนจะต้องทำแบบทดสอบให้ผ่านตามเกณฑ์ที่สถาบันฯ กำหนดก่อน ระบบจึงจะถือว่าการเรียนรู้ในหลักสูตร/วิชานั้นๆ เสร็จสมบูรณ์', '0000-00-00 00:00:00', '2018-11-26 08:47:41', '1229900480178'),
(8, 2, 'เข้าเรียนและทำแบบทดสอบในหลักสูตรแล้ว ทำไมถึงไม่มีใบประกาศนียบัตรแสดงในหน้าหลักผู้ใช้งาน?', '○ ใบประกาศนียบัตรหลักสูตร/วิชา จะมีในบางหลักสูตร/วิชาเท่านั้น โดยหลักสูตร/วิชาที่มีใบประกาศนียบัตรจะมีสัญลักษณ์แสดงที่หน้ารายละเอียดหลักสูตร/วิชา หากท่านเรียนและสอบผ่านตามเกณฑ์ที่สถาบันฯ กำหนด ท่านจะได้รับใบประกาศนียบัตรของหลักสูตร/วิชานั้นๆ', '0000-00-00 00:00:00', '2018-11-26 08:47:57', '1229900480178');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_FIL`
--

CREATE TABLE `LMS_FIL` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `lessons_id` bigint(10) UNSIGNED NOT NULL,
  `path_file` text NOT NULL,
  `name_fileth` varchar(255) NOT NULL,
  `name_fileen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_FIL_LOG`
--

CREATE TABLE `LMS_FIL_LOG` (
  `id_log` bigint(50) DEFAULT NULL,
  `fil_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `fil_log_id` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_FUNC_DASHBOARD`
--

CREATE TABLE `LMS_FUNC_DASHBOARD` (
  `fd_id` bigint(50) NOT NULL,
  `fd_name` varchar(255) NOT NULL,
  `fd_detail` text NOT NULL,
  `fd_createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_FUNC_DASHBOARD`
--

INSERT INTO `LMS_FUNC_DASHBOARD` (`fd_id`, `fd_name`, `fd_detail`, `fd_createdate`) VALUES
(1, 'Banner', '', '2020-01-27 14:49:00'),
(2, 'หลักสูตรที่เปิดอยู่', '', '2020-01-27 14:49:00'),
(3, 'หลักสูตรที่กำลังจะเปิด', '', '2020-01-27 14:49:00'),
(4, 'การเข้าใช้งานระบบ', '', '2020-01-27 14:49:00'),
(5, 'กราฟสถานะการเรียน', '', '2020-01-27 14:49:00'),
(6, 'แบบสอบถาม', '', '2020-02-07 10:01:00'),
(7, 'รายงานบริษัท', '', '2020-02-07 10:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_LES`
--

CREATE TABLE `LMS_LES` (
  `les_id` bigint(10) UNSIGNED NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `les_lang` varchar(50) NOT NULL,
  `les_name` varchar(255) NOT NULL,
  `les_info` text NOT NULL,
  `les_type` int(1) NOT NULL COMMENT '1=media, 2=scorm',
  `scm_type` int(1) NOT NULL DEFAULT '0',
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL,
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL,
  `les_status` int(1) NOT NULL DEFAULT '1',
  `les_isDelete` int(1) NOT NULL DEFAULT '0',
  `les_sequences` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_LES_TC`
--

CREATE TABLE `LMS_LES_TC` (
  `id_log` bigint(50) DEFAULT NULL,
  `lestc_id` bigint(10) UNSIGNED NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `les_id` bigint(10) UNSIGNED DEFAULT NULL,
  `learn_status` varchar(50) NOT NULL COMMENT '0 = not_start,1 = inProgress,2 = done,3=fail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_LG`
--

CREATE TABLE `LMS_LG` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `log_type` text NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `massage` mediumtext NOT NULL,
  `ip` varchar(45) NOT NULL,
  `device` varchar(250) NOT NULL,
  `log_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_LG`
--

INSERT INTO `LMS_LG` (`id`, `log_type`, `emp_id`, `massage`, `ip`, `device`, `log_time`) VALUES
(1, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:17'),
(2, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:20'),
(3, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:20'),
(4, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:20'),
(5, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:20'),
(6, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:06:20'),
(7, 'home', 1, 'user id 1229900480178logged out.', '127.0.0.1', 'PC : windows', '2020-02-07 09:11:48'),
(8, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:11'),
(9, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:12'),
(10, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:13'),
(11, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:13'),
(12, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:13'),
(13, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:13'),
(14, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:16'),
(15, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:17'),
(16, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:17'),
(17, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:17'),
(18, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:17'),
(19, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:17'),
(20, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:20'),
(21, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:21'),
(22, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:21'),
(23, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:21'),
(24, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:21'),
(25, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:21'),
(26, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:23'),
(27, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:24'),
(28, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:24'),
(29, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:24'),
(30, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:24'),
(31, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 09:15:24'),
(32, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:48'),
(33, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:49'),
(34, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:49'),
(35, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:50'),
(36, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:50'),
(37, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:06:50'),
(38, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:57'),
(39, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:58'),
(40, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:58'),
(41, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:58'),
(42, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:58'),
(43, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:58'),
(44, 'home', 1, 'user id 1229900480178logged out.', '127.0.0.1', 'PC : windows', '2020-02-07 10:19:59'),
(45, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:30'),
(46, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:31'),
(47, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:32'),
(48, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:32'),
(49, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:32'),
(50, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:20:32'),
(51, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:10'),
(52, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:10'),
(53, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:10'),
(54, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:11'),
(55, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:11'),
(56, 'Certificate', 1, 'enter create certificate', '127.0.0.1', 'PC : windows', '2020-02-07 10:24:11'),
(57, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:29'),
(58, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:31'),
(59, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:31'),
(60, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:31'),
(61, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:31'),
(62, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:34:31'),
(63, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:23'),
(64, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:24'),
(65, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:25'),
(66, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:25'),
(67, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:25'),
(68, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 10:49:25'),
(69, 'home', NULL, 'user id logged out.', '127.0.0.1', 'PC : windows', '2020-02-07 12:34:08'),
(70, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:42'),
(71, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:44'),
(72, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:45'),
(73, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:45'),
(74, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:45'),
(75, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:45'),
(76, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:55'),
(77, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:57'),
(78, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:57'),
(79, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:57'),
(80, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:57'),
(81, 'dashboard', 1, 'enter dashboard.', '127.0.0.1', 'PC : windows', '2020-02-07 14:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_LOG_ENROLL`
--

CREATE TABLE `LMS_LOG_ENROLL` (
  `id_log` bigint(50) NOT NULL,
  `cosen_id` bigint(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_MAINMENU`
--

CREATE TABLE `LMS_MAINMENU` (
  `mm_id` bigint(50) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `mm_icon` varchar(250) NOT NULL,
  `mm_status` int(1) NOT NULL DEFAULT '1',
  `mm_txt_th1` varchar(250) NOT NULL,
  `mm_txt_th2` varchar(250) NOT NULL,
  `mm_txt_en1` varchar(250) NOT NULL,
  `mm_txt_en2` varchar(250) NOT NULL,
  `mm_modifiedby` varchar(50) NOT NULL,
  `mm_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_MED`
--

CREATE TABLE `LMS_MED` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `lessons_id` bigint(10) UNSIGNED NOT NULL,
  `med_name` varchar(255) NOT NULL,
  `thumbnail_med` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_MED_TC`
--

CREATE TABLE `LMS_MED_TC` (
  `med_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `medtc_id` bigint(50) NOT NULL,
  `medtc_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_MENU`
--

CREATE TABLE `LMS_MENU` (
  `mu_id` int(50) NOT NULL,
  `mu_name_th` varchar(250) NOT NULL,
  `mu_name_en` varchar(250) NOT NULL,
  `mu_path` varchar(255) NOT NULL,
  `mu_customer` int(1) NOT NULL DEFAULT '0',
  `mu_num` int(50) NOT NULL,
  `mu_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_MENU`
--

INSERT INTO `LMS_MENU` (`mu_id`, `mu_name_th`, `mu_name_en`, `mu_path`, `mu_customer`, `mu_num`, `mu_status`) VALUES
(4, 'การจัดการหลักสูตร : ข้อมูลวิชา/กลุ่มวิชา', 'Manage Courses : Course/All Course Group', 'managecourse/course_groups', 1, 27, 1),
(5, 'การจัดการหลักสูตร : ข้อมูลวิชา/ประเภทรายวิชา', 'Manage Courses : Course/Course Type', 'coursetype/loadCourseType', 1, 28, 1),
(6, 'ระบบการเรียนรู้ : ข้อมูลวิชา/รายวิชา', 'Learning System : Course/All Courses', 'course/available', 1, 1, 1),
(7, 'ระบบการเรียนรู้ : ข้อมูลวิชา/รายวิชาของฉัน', 'Learning System : Course/My Course', 'course/loadCourse', 1, 2, 1),
(8, 'ระบบการเรียนรู้ : ออกใบประกาศนียบัตร', 'Learning System : Certificate', 'certificate/certificateall', 1, 3, 1),
(9, 'จัดการผู้ใช้งาน : ข้อมูลบริษัท', 'Manage Users : Company', 'manage/companydata', 0, 6, 1),
(10, 'จัดการผู้ใช้งาน : ข้อมูลแผนก', 'Manage Users : Department', 'manage/departmentdata', 1, 7, 1),
(11, 'ตั้งค่าทั่วไป : จัดการผู้ใช้งาน/ข้อมูลกลุ่มผู้ใช้', 'Setting : Manage Users/Group user', 'manage/groupuserdata', 1, 21, 1),
(12, 'จัดการผู้ใช้งาน : ข้อมูลผู้ใช้', 'Manage Users : Users', 'manage/userdata', 1, 8, 1),
(14, 'จัดการผู้ใช้งาน : ปลดล็อกบัญชีผู้ใช้งาน', 'Manage Users : Unlock User Account', 'dashboard/unlockAcc', 1, 9, 1),
(15, 'จัดการผู้ใช้งาน : จัดการรหัสผ่าน', 'Manage Users : Manage Password', 'dashboard/resetPass', 1, 10, 1),
(16, 'รายงาน : รายงานทั่วไป/รายงานบริษัท', 'Report : General report/Company report', 'report/loadreport_company', 1, 11, 1),
(17, 'รายงาน : รายงานทั่วไป/รายงานรายหลักสูตร', 'Report : General report/Course report', 'report/loadreport_coursename', 1, 12, 1),
(18, 'รายงาน : รายงานทั่วไป/รายงานผู้เรียน', 'Report : General report/Student report', 'report/loadreport_student', 1, 13, 1),
(19, 'รายงาน : รายงานทั่วไป/รายงานส่วนตัว', 'Report : General report/Personal report', 'report/loadreport_personal', 1, 15, 1),
(20, 'รายงาน : บันทึกการใช้งานระบบ', 'Report : Login Record', 'log/view', 1, 16, 1),
(21, 'ตั้งค่าทั่วไป : จัดการทั่วไป', 'Setting : General Management', 'setting/ManageECT', 0, 17, 1),
(22, 'ตั้งค่าทั่วไป : ลูกค้าที่มีค่าของเรา', 'Setting : Our Values Clients', 'setting/ManageTestimonials', 0, 19, 0),
(23, 'ตั้งค่าทั่วไป : จัดการ FAQ', 'Setting : Manage FAQ', 'setting/ManageFAQ', 1, 18, 1),
(24, 'ตั้งค่าทั่วไป : ระบบการเรียนรู้/เทมเพลตแบบทดสอบ', 'Setting : Learning System/Template Quiz', 'quiz/create_template', 1, 22, 1),
(25, 'ตั้งค่าทั่วไป : จัดการ Menu', 'Setting : Manage Menu', 'setting/ManageMenu', 0, 20, 1),
(26, 'ตั้งค่าทั่วไป : ระบบการเรียนรู้/เทมเพลตแบบสอบถาม', 'Setting : Learning System/Survey Template', 'questionnaire/create', 1, 23, 1),
(27, 'รายงาน : รายงานทั่วไป/รายงานแบบสอบถาม', 'Report : General report/Survey report', 'report/loadreport_survey', 1, 14, 1),
(28, 'ตั้งค่าทั่วไป : จัดการ Event', 'Setting : Manage Event', 'setting/ManageEvent', 0, 19, 1),
(29, 'QR CODE', 'QR CODE', 'qrcode/create', 1, 24, 1),
(30, 'แบบสอบถาม : รายการแบบสอบถาม', 'Survey : Survey List', 'survey/list_survey', 1, 4, 1),
(31, 'แบบสอบถาม : รายงานแบบสอบถาม', 'Survey : Report Survey', 'survey/report_survey', 1, 5, 1),
(32, 'ตั้งค่า : ตั้งค่าอีเมล', 'Settings : Setting E-Mail', 'setting/setting_email', 0, 25, 1),
(33, 'ตั้งค่า : แบบฟอร์มการส่งอีเมล', 'Settings : Form E-Mail', 'setting/format_email', 0, 26, 1),
(34, 'การจัดการหลักสูตร', 'Manage Courses', 'managecourse/courses_all', 0, 29, 1),
(35, '', '', '', 0, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_POSITION`
--

CREATE TABLE `LMS_POSITION` (
  `posi_id` bigint(50) NOT NULL,
  `dep_id` bigint(50) DEFAULT NULL,
  `posi_name_th` varchar(255) NOT NULL,
  `posi_name_en` varchar(255) NOT NULL,
  `posi_remark` text NOT NULL,
  `posi_status` int(1) NOT NULL DEFAULT '1',
  `posi_isDelete` int(1) NOT NULL DEFAULT '0',
  `posi_createby` varchar(50) NOT NULL,
  `posi_createdate` datetime NOT NULL,
  `posi_modifiedby` varchar(50) NOT NULL,
  `posi_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_POSITION`
--

INSERT INTO `LMS_POSITION` (`posi_id`, `dep_id`, `posi_name_th`, `posi_name_en`, `posi_remark`, `posi_status`, `posi_isDelete`, `posi_createby`, `posi_createdate`, `posi_modifiedby`, `posi_modifieddate`) VALUES
(1, 9, 'พีเอชพี', 'PHP Developer', 'ทดสอบ', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(21, 17, 'PHP DEVELOPER', 'PHP DEVELOPER', '', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(22, 20, 'ผู้จัดการ', 'Manager', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(23, 21, 'ผู้จัดการ21', 'Manager21', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(24, 21, 'ผู้จัดการ21', 'Manager21', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(25, 21, 'ผู้จัดการ21', 'Manager21', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(26, 21, 'ผู้จัดการ21', 'Manager21', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(27, 22, 'ผู้จัดการ22', 'Manager22', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(28, 22, 'ผู้จัดการ22', 'Manager22', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(29, 22, 'ผู้จัดการ22', 'Manager22', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(30, 22, 'ผู้จัดการ22', 'Manager22', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(31, 23, 'ผู้จัดการ23', 'Manager23', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(32, 23, 'ผู้จัดการ23', 'Manager23', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(33, 23, 'ผู้จัดการ23', 'Manager23', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(34, 23, 'ผู้จัดการ23', 'Manager23', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(35, 24, 'ผู้จัดการ24', 'Manager24', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(36, 24, 'ผู้จัดการ24', 'Manager24', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(37, 24, 'ผู้จัดการ24', 'Manager24', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(38, 24, 'ผู้จัดการ24', 'Manager24', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(39, 25, 'ผู้จัดการ25', 'Manager25', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(40, 25, 'ผู้จัดการ25', 'Manager25', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(41, 25, 'ผู้จัดการ25', 'Manager25', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(42, 25, 'ผู้จัดการ25', 'Manager25', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(43, 26, 'ผู้จัดการ26', 'Manager26', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(44, 26, 'ผู้จัดการ26', 'Manager26', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(45, 26, 'ผู้จัดการ26', 'Manager26', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(46, 26, 'ผู้จัดการ26', 'Manager26', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(47, 27, 'ผู้จัดการ27', 'Manager27', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(48, 27, 'ผู้จัดการ27', 'Manager27', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(49, 27, 'ผู้จัดการ27', 'Manager27', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(50, 27, 'ผู้จัดการ27', 'Manager27', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(51, 30, 'ผู้จัดการ30', 'Manager30', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(52, 30, 'ผู้จัดการ30', 'Manager30', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(53, 30, 'ผู้จัดการ30', 'Manager30', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(54, 30, 'ผู้จัดการ30', 'Manager30', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(55, 31, 'ผู้จัดการ31', 'Manager31', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(56, 31, 'ผู้จัดการ31', 'Manager31', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(57, 31, 'ผู้จัดการ31', 'Manager31', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(58, 31, 'ผู้จัดการ31', 'Manager31', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(59, 32, 'ผู้จัดการ32', 'Manager32', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(60, 32, 'ผู้จัดการ32', 'Manager32', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(61, 32, 'ผู้จัดการ32', 'Manager32', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(62, 32, 'ผู้จัดการ32', 'Manager32', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(63, 35, 'ผู้จัดการ35', 'Manager35', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(64, 35, 'ผู้จัดการ35', 'Manager35', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(65, 35, 'ผู้จัดการ35', 'Manager35', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(66, 35, 'ผู้จัดการ35', 'Manager35', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(67, 36, 'ผู้จัดการ36', 'Manager36', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(68, 36, 'ผู้จัดการ36', 'Manager36', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(69, 36, 'ผู้จัดการ36', 'Manager36', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(70, 36, 'ผู้จัดการ36', 'Manager36', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(71, 37, 'ผู้จัดการ37', 'Manager37', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(72, 37, 'ผู้จัดการ37', 'Manager37', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(73, 37, 'ผู้จัดการ37', 'Manager37', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(74, 37, 'ผู้จัดการ37', 'Manager37', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(75, 38, 'ผู้จัดการ38', 'Manager38', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(76, 38, 'ผู้จัดการ38', 'Manager38', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(77, 38, 'ผู้จัดการ38', 'Manager38', 'กกกก', 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QIZ`
--

CREATE TABLE `LMS_QIZ` (
  `qiz_id` bigint(10) UNSIGNED NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `quiz_name_th` varchar(255) NOT NULL,
  `quiz_info_th` text,
  `quiz_name_en` varchar(255) NOT NULL,
  `quiz_info_en` text NOT NULL,
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL,
  `period_open` datetime DEFAULT NULL,
  `period_end` datetime DEFAULT NULL,
  `quiz_random` int(1) NOT NULL DEFAULT '0',
  `quiz_show` int(1) NOT NULL DEFAULT '1' COMMENT '0 = disable, 1 = enable',
  `quiz_grade` int(1) NOT NULL DEFAULT '1' COMMENT '0 = disable, 1 = enable',
  `quiz_type` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Pretest,2 = Post-test',
  `quiz_answer` int(1) NOT NULL DEFAULT '0' COMMENT '0 = disable, 1 = enable',
  `quiz_limit` int(1) NOT NULL DEFAULT '0' COMMENT '0 = disable, 1 = enable',
  `quiz_limitval` bigint(10) NOT NULL,
  `quiz_maxscore` bigint(10) NOT NULL,
  `quiz_status` int(1) NOT NULL DEFAULT '1' COMMENT '0=disable , 1=enable',
  `quiz_numofshown` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QIZ_EXP`
--

CREATE TABLE `LMS_QIZ_EXP` (
  `qize_id` bigint(50) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `qize_name_th` varchar(255) NOT NULL,
  `qize_name_en` varchar(255) NOT NULL,
  `qize_info` text NOT NULL,
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QIZ_TC`
--

CREATE TABLE `LMS_QIZ_TC` (
  `id_log` bigint(50) DEFAULT NULL,
  `id` bigint(10) UNSIGNED NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `qiz_id` bigint(10) UNSIGNED NOT NULL,
  `time_start` datetime NOT NULL,
  `time_mod` datetime NOT NULL,
  `time_finish` datetime NOT NULL,
  `sum_score` decimal(10,2) NOT NULL,
  `limit_val` int(10) NOT NULL COMMENT 'จำนวนครั้ง',
  `qiz_status` varchar(50) NOT NULL COMMENT '1 = noProgress,2 = not_start,3 = done,4 = m_cancel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QN_USER`
--

CREATE TABLE `LMS_QN_USER` (
  `id_log` bigint(50) DEFAULT NULL,
  `qnu_id` bigint(10) NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `sv_id` bigint(50) DEFAULT NULL,
  `qnu_suggestion` text NOT NULL,
  `qnu_datetime` datetime NOT NULL,
  `qnu_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QN_USER_DE`
--

CREATE TABLE `LMS_QN_USER_DE` (
  `qnude_id` bigint(10) NOT NULL,
  `qnu_id` bigint(10) DEFAULT NULL,
  `svde_id` bigint(50) DEFAULT NULL,
  `qnude_var` int(50) NOT NULL,
  `qnude_suggestion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QRCODE`
--

CREATE TABLE `LMS_QRCODE` (
  `qr_id` bigint(50) NOT NULL,
  `qr_name` varchar(255) NOT NULL,
  `qr_type` int(1) NOT NULL COMMENT '1 = image, 2 = video, 3 = pdf, 4 = document(word,ppt,excel)',
  `qr_path` varchar(255) NOT NULL,
  `qr_detail` text NOT NULL,
  `qr_status` int(1) NOT NULL DEFAULT '1',
  `qr_isDelete` int(1) NOT NULL DEFAULT '0',
  `qr_createby` varchar(50) NOT NULL,
  `qr_createdate` datetime NOT NULL,
  `qr_modifiedby` varchar(50) NOT NULL,
  `qr_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_QRCODE`
--

INSERT INTO `LMS_QRCODE` (`qr_id`, `qr_name`, `qr_type`, `qr_path`, `qr_detail`, `qr_status`, `qr_isDelete`, `qr_createby`, `qr_createdate`, `qr_modifiedby`, `qr_modifieddate`) VALUES
(2, 'ไฟล์เอกสารทดสอบ', 2, 'qr_path_20200127105909.mp4', '5454545454', 1, 0, '1', '2020-01-27 10:59:09', '1', '2020-01-27 12:00:05'),
(3, 'ทดสอบไฟล์รูปภาพ', 1, 'qr_path_20200127110021.jpg', '2125155454', 1, 0, '1', '2020-01-27 11:00:21', '1', '2020-01-27 12:00:03'),
(4, 'ทดสอบไฟล์ PDF', 3, 'qr_path_20200127110106.pdf', '', 1, 0, '1', '2020-01-27 11:01:06', '1', '2020-01-28 15:44:17'),
(5, 'ทดสอบไฟล์เอกสาร', 4, 'qr_path_20200127110136.pptx', '2151545', 1, 0, '1', '2020-01-27 11:01:36', '1', '2020-01-27 11:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUES`
--

CREATE TABLE `LMS_QUES` (
  `ques_id` bigint(10) NOT NULL,
  `qiz_id` bigint(10) UNSIGNED DEFAULT NULL,
  `ques_type` varchar(250) NOT NULL,
  `ques_name_th` text,
  `ques_name_en` text,
  `ques_info_th` text,
  `ques_info_en` text,
  `ques_score` decimal(10,2) NOT NULL,
  `ques_show` int(1) NOT NULL DEFAULT '1' COMMENT '0 = disable,1 = enable',
  `ques_status` int(1) NOT NULL DEFAULT '1',
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUESE`
--

CREATE TABLE `LMS_QUESE` (
  `quese_id` bigint(10) NOT NULL,
  `qize_id` bigint(50) DEFAULT NULL,
  `quese_type` varchar(250) NOT NULL,
  `quese_name_th` varchar(255) NOT NULL,
  `quese_name_en` varchar(255) NOT NULL,
  `quese_info_th` text NOT NULL,
  `quese_info_en` text NOT NULL,
  `quese_score` decimal(10,2) NOT NULL,
  `quese_show` int(1) NOT NULL COMMENT '0 = disable,1 = enable',
  `quese_status` int(1) NOT NULL DEFAULT '1',
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUESE_MUL`
--

CREATE TABLE `LMS_QUESE_MUL` (
  `mule_id` bigint(10) NOT NULL,
  `quese_id` bigint(10) DEFAULT NULL,
  `mule_c1_th` text NOT NULL,
  `mule_c2_th` text NOT NULL,
  `mule_c3_th` text NOT NULL,
  `mule_c4_th` text NOT NULL,
  `mule_c5_th` text NOT NULL,
  `mule_answer` varchar(100) NOT NULL,
  `mule_c1_en` text NOT NULL,
  `mule_c2_en` text NOT NULL,
  `mule_c3_en` text NOT NULL,
  `mule_c4_en` text NOT NULL,
  `mule_c5_en` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUESTIONNAIRE`
--

CREATE TABLE `LMS_QUESTIONNAIRE` (
  `qn_id` bigint(10) NOT NULL,
  `com_id` bigint(50) NOT NULL,
  `qn_title_th` varchar(250) NOT NULL,
  `qn_title_en` varchar(250) NOT NULL,
  `qn_explanation_th` text NOT NULL,
  `qn_explanation_en` text NOT NULL,
  `qn_suggestion_status` int(1) NOT NULL DEFAULT '0',
  `qn_filename` varchar(250) NOT NULL,
  `qn_status` int(1) NOT NULL DEFAULT '1',
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUESTIONNAIRE_DE`
--

CREATE TABLE `LMS_QUESTIONNAIRE_DE` (
  `qnde_id` bigint(10) NOT NULL,
  `qn_id` bigint(10) DEFAULT NULL,
  `qnde_heading_th` varchar(250) NOT NULL,
  `qnde_detail_th` text NOT NULL,
  `qnde_heading_en` varchar(250) NOT NULL,
  `qnde_detail_en` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUES_MUL`
--

CREATE TABLE `LMS_QUES_MUL` (
  `mul_id` bigint(10) NOT NULL,
  `ques_id` bigint(10) DEFAULT NULL,
  `mul_c1_th` text,
  `mul_c2_th` text,
  `mul_c3_th` text,
  `mul_c4_th` text,
  `mul_c5_th` text,
  `mul_answer` varchar(100) NOT NULL,
  `mul_c1_en` text,
  `mul_c2_en` text,
  `mul_c3_en` text,
  `mul_c4_en` text,
  `mul_c5_en` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_QUES_TC`
--

CREATE TABLE `LMS_QUES_TC` (
  `id_log` bigint(50) DEFAULT NULL,
  `tc_id` bigint(10) NOT NULL,
  `qiz_id` bigint(10) UNSIGNED DEFAULT NULL,
  `ques_id` bigint(10) DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `tc_answer` varchar(100) NOT NULL,
  `tc_finish` datetime NOT NULL,
  `tc_flag` varchar(50) NOT NULL,
  `tc_save` varchar(50) NOT NULL,
  `tc_score` decimal(10,2) NOT NULL COMMENT 'คะแนน',
  `tc_number` int(10) NOT NULL DEFAULT '0',
  `tc_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_ROLE_FD`
--

CREATE TABLE `LMS_ROLE_FD` (
  `rfd_id` bigint(50) NOT NULL,
  `fd_id` bigint(50) DEFAULT NULL,
  `ug_id` bigint(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Function Dashboard for users';

--
-- Dumping data for table `LMS_ROLE_FD`
--

INSERT INTO `LMS_ROLE_FD` (`rfd_id`, `fd_id`, `ug_id`) VALUES
(40, 1, 2),
(41, 4, 2),
(43, 1, 4),
(44, 2, 4),
(45, 3, 4),
(46, 5, 4),
(47, 1, 3),
(48, 2, 3),
(49, 3, 3),
(50, 5, 3),
(51, 1, 1),
(52, 2, 1),
(53, 3, 1),
(54, 4, 1),
(55, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_ROLE_GP`
--

CREATE TABLE `LMS_ROLE_GP` (
  `ug_id` bigint(50) DEFAULT NULL,
  `mu_id` int(50) DEFAULT NULL,
  `rgu_view` int(1) NOT NULL,
  `rgu_add` int(1) NOT NULL,
  `rgu_edit` int(1) NOT NULL,
  `rgu_del` int(1) NOT NULL,
  `rgu_print` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_ROLE_GP`
--

INSERT INTO `LMS_ROLE_GP` (`ug_id`, `mu_id`, `rgu_view`, `rgu_add`, `rgu_edit`, `rgu_del`, `rgu_print`) VALUES
(1, 4, 1, 1, 1, 1, 1),
(1, 5, 1, 1, 1, 1, 1),
(1, 6, 1, 1, 1, 1, 1),
(1, 7, 1, 1, 1, 1, 1),
(1, 8, 1, 1, 1, 1, 1),
(1, 9, 1, 1, 1, 1, 1),
(1, 10, 1, 1, 1, 1, 1),
(1, 11, 1, 1, 1, 1, 1),
(1, 12, 1, 1, 1, 1, 1),
(1, 14, 1, 1, 1, 1, 1),
(1, 15, 1, 1, 1, 1, 1),
(1, 16, 1, 1, 1, 1, 1),
(1, 17, 1, 1, 1, 1, 1),
(4, 4, 1, 0, 0, 0, 0),
(4, 6, 1, 0, 0, 0, 0),
(4, 7, 1, 0, 0, 0, 0),
(4, 19, 1, 0, 0, 0, 1),
(3, 4, 1, 0, 1, 1, 1),
(3, 5, 1, 0, 1, 1, 1),
(3, 6, 1, 0, 1, 1, 1),
(3, 8, 1, 0, 1, 1, 1),
(3, 10, 1, 0, 1, 1, 1),
(3, 11, 0, 0, 0, 0, 0),
(3, 12, 1, 0, 1, 1, 1),
(3, 14, 1, 0, 1, 1, 1),
(3, 15, 1, 0, 1, 1, 1),
(3, 17, 1, 0, 1, 1, 1),
(3, 18, 1, 0, 1, 1, 1),
(3, 19, 1, 0, 1, 1, 1),
(3, 16, 1, 0, 1, 1, 1),
(3, 20, 1, 0, 1, 1, 1),
(3, 24, 1, 0, 1, 1, 1),
(3, 26, 1, 0, 1, 1, 1),
(2, 4, 1, 1, 1, 1, 1),
(2, 5, 1, 1, 1, 1, 1),
(2, 6, 1, 1, 1, 1, 1),
(2, 8, 1, 1, 1, 1, 1),
(2, 9, 1, 1, 1, 1, 1),
(2, 10, 1, 1, 1, 1, 1),
(2, 11, 1, 1, 1, 1, 1),
(2, 12, 1, 1, 1, 1, 1),
(2, 14, 1, 1, 1, 1, 1),
(2, 15, 1, 1, 1, 1, 1),
(2, 16, 1, 0, 0, 0, 1),
(2, 17, 1, 0, 0, 0, 1),
(2, 18, 1, 0, 0, 0, 1),
(2, 19, 1, 0, 0, 0, 1),
(2, 20, 1, 0, 0, 0, 1),
(2, 21, 1, 1, 1, 1, 0),
(2, 22, 1, 1, 1, 1, 0),
(2, 23, 1, 1, 1, 1, 0),
(2, 25, 1, 1, 1, 1, 0),
(2, 24, 1, 1, 1, 1, 0),
(2, 26, 1, 1, 1, 1, 0),
(1, 18, 1, 1, 1, 1, 1),
(1, 19, 1, 1, 1, 1, 1),
(1, 20, 1, 1, 1, 1, 1),
(1, 21, 1, 1, 1, 1, 1),
(1, 22, 1, 1, 1, 1, 1),
(1, 23, 1, 1, 1, 1, 1),
(1, 25, 1, 1, 1, 1, 1),
(1, 24, 1, 1, 1, 1, 1),
(1, 26, 1, 1, 1, 1, 1),
(3, 7, 0, 0, 0, 0, 0),
(3, 9, 0, 0, 0, 0, 0),
(3, 21, 0, 0, 0, 0, 0),
(3, 22, 0, 0, 0, 0, 0),
(3, 23, 0, 0, 0, 0, 0),
(3, 25, 0, 0, 0, 0, 0),
(1, 27, 1, 1, 1, 1, 1),
(2, 27, 1, 0, 0, 0, 1),
(3, 27, 1, 0, 1, 1, 1),
(2, 4, 1, 1, 1, 1, 1),
(2, 5, 1, 1, 1, 1, 1),
(2, 6, 1, 1, 1, 1, 1),
(2, 8, 1, 1, 1, 1, 1),
(2, 9, 1, 1, 1, 1, 1),
(2, 10, 1, 1, 1, 1, 1),
(2, 12, 1, 1, 1, 1, 1),
(2, 14, 1, 1, 1, 1, 1),
(2, 15, 1, 1, 1, 1, 1),
(2, 16, 1, 1, 1, 1, 1),
(2, 17, 1, 1, 1, 1, 1),
(2, 18, 1, 1, 1, 1, 1),
(2, 27, 1, 1, 1, 1, 1),
(2, 19, 1, 1, 1, 1, 1),
(2, 20, 1, 1, 1, 1, 1),
(2, 21, 1, 1, 1, 1, 1),
(2, 11, 1, 1, 1, 1, 1),
(2, 24, 1, 1, 1, 1, 1),
(2, 26, 1, 1, 1, 1, 1),
(4, 4, 1, 0, 0, 0, 0),
(4, 6, 1, 0, 0, 0, 0),
(4, 7, 1, 0, 0, 0, 0),
(4, 19, 1, 0, 0, 0, 0),
(1, 28, 1, 1, 1, 1, 1),
(1, 29, 1, 1, 1, 1, 1),
(1, 30, 1, 1, 1, 1, 1),
(1, 31, 1, 1, 1, 1, 1),
(1, 32, 1, 1, 1, 1, 1),
(1, 33, 1, 1, 1, 1, 1),
(1, 34, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_ROLE_USP`
--

CREATE TABLE `LMS_ROLE_USP` (
  `u_id` bigint(50) DEFAULT NULL,
  `mu_id` int(50) DEFAULT NULL,
  `ru_view` int(1) NOT NULL,
  `ru_add` int(1) NOT NULL,
  `ru_edit` int(1) NOT NULL,
  `ru_del` int(1) NOT NULL,
  `ru_print` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_ROLE_USP`
--

INSERT INTO `LMS_ROLE_USP` (`u_id`, `mu_id`, `ru_view`, `ru_add`, `ru_edit`, `ru_del`, `ru_print`) VALUES
(1, 4, 1, 1, 1, 1, 1),
(1, 5, 1, 1, 1, 1, 1),
(1, 6, 1, 1, 1, 1, 1),
(1, 7, 1, 1, 1, 1, 1),
(1, 8, 1, 1, 1, 1, 1),
(1, 9, 1, 1, 1, 1, 1),
(1, 10, 1, 1, 1, 1, 1),
(1, 11, 1, 1, 1, 1, 1),
(1, 12, 1, 1, 1, 1, 1),
(1, 14, 1, 1, 1, 1, 1),
(1, 15, 1, 1, 1, 1, 1),
(1, 16, 1, 1, 1, 1, 1),
(1, 17, 1, 1, 1, 1, 1),
(1, 18, 1, 1, 1, 1, 1),
(1, 19, 1, 1, 1, 1, 1),
(1, 20, 1, 1, 1, 1, 1),
(1, 21, 1, 1, 1, 1, 1),
(1, 22, 1, 1, 1, 1, 1),
(1, 23, 1, 1, 1, 1, 1),
(1, 25, 1, 1, 1, 1, 1),
(1, 24, 1, 1, 1, 1, 1),
(1, 26, 1, 1, 1, 1, 1),
(1, 27, 1, 1, 1, 1, 1),
(1, 28, 1, 1, 1, 1, 1),
(1, 29, 1, 1, 1, 1, 1),
(1, 30, 1, 1, 1, 1, 1),
(1, 31, 1, 1, 1, 1, 1),
(1, 32, 1, 1, 1, 1, 1),
(1, 33, 1, 1, 1, 1, 1),
(1, 34, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SCM`
--

CREATE TABLE `LMS_SCM` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `lessons_id` bigint(10) UNSIGNED DEFAULT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SCM_VAL`
--

CREATE TABLE `LMS_SCM_VAL` (
  `id_log` bigint(50) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `scm_id` bigint(10) UNSIGNED DEFAULT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `var_name` text NOT NULL,
  `var_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SENDMAIL_COURSE`
--

CREATE TABLE `LMS_SENDMAIL_COURSE` (
  `smc_id` bigint(50) NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `smc_msg` text NOT NULL,
  `smc_status` int(1) NOT NULL DEFAULT '1',
  `smc_createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SENDMAIL_FORM`
--

CREATE TABLE `LMS_SENDMAIL_FORM` (
  `smf_id` bigint(50) NOT NULL,
  `smf_type` int(1) NOT NULL COMMENT '1 = register,2 = forgot password,3 = unlock user',
  `smf_subject_th` varchar(255) NOT NULL,
  `smf_subject_en` varchar(255) NOT NULL,
  `smf_message_th` text NOT NULL,
  `smf_message_en` text NOT NULL,
  `smf_show` int(1) NOT NULL DEFAULT '1',
  `smf_createby` varchar(50) NOT NULL,
  `smf_createdate` datetime NOT NULL,
  `smf_modifiedby` varchar(50) NOT NULL,
  `smf_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SETTING_MAIL`
--

CREATE TABLE `LMS_SETTING_MAIL` (
  `sm_id` int(50) NOT NULL,
  `sm_host` varchar(255) NOT NULL,
  `sm_port` varchar(50) NOT NULL,
  `sm_smtpauth` varchar(10) NOT NULL COMMENT 'SMTPAuth',
  `sm_username` varchar(255) NOT NULL,
  `sm_password` varchar(50) NOT NULL,
  `sm_sender` varchar(255) NOT NULL,
  `sm_emailsender` varchar(255) NOT NULL,
  `sm_modifiedby` varchar(50) NOT NULL,
  `sm_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_SETTING_MAIL`
--

INSERT INTO `LMS_SETTING_MAIL` (`sm_id`, `sm_host`, `sm_port`, `sm_smtpauth`, `sm_username`, `sm_password`, `sm_sender`, `sm_emailsender`, `sm_modifiedby`, `sm_modifieddate`) VALUES
(1, 'mail.verztec.com', '587', 'true', 'pandora@verztec.com', 'pppp99999', 'THAIHEALTH LMS', 'pandora@verztec.com', '1', '2019-07-08 09:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SETTING_SSO`
--

CREATE TABLE `LMS_SETTING_SSO` (
  `sso_id` int(50) NOT NULL,
  `sso_client_id` varchar(255) NOT NULL,
  `sso_password` varchar(255) NOT NULL,
  `sso_access_token` varchar(255) NOT NULL,
  `sso_redirect_url` varchar(255) NOT NULL,
  `sso_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SURVEY`
--

CREATE TABLE `LMS_SURVEY` (
  `sv_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `sv_title_th` varchar(250) NOT NULL,
  `sv_title_en` varchar(250) NOT NULL,
  `sv_explanation_th` text NOT NULL,
  `sv_explanation_en` text NOT NULL,
  `sv_suggestion_status` int(1) NOT NULL DEFAULT '0',
  `sv_status` int(1) NOT NULL DEFAULT '1',
  `time_create` datetime NOT NULL,
  `time_mod` datetime NOT NULL,
  `survey_open` datetime NOT NULL,
  `survey_end` datetime NOT NULL,
  `qn_id` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_SURVEY_DE`
--

CREATE TABLE `LMS_SURVEY_DE` (
  `svde_id` bigint(50) NOT NULL,
  `sv_id` bigint(50) DEFAULT NULL,
  `svde_heading_th` varchar(250) DEFAULT NULL,
  `svde_detail_th` text,
  `svde_heading_en` varchar(250) DEFAULT NULL,
  `svde_detail_en` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_TESTIMONIALS`
--

CREATE TABLE `LMS_TESTIMONIALS` (
  `tim_id` bigint(10) NOT NULL,
  `tim_file` varchar(250) NOT NULL,
  `tim_title` varchar(250) NOT NULL,
  `tim_createdate` datetime NOT NULL,
  `tim_moddate` datetime NOT NULL,
  `emp_c` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_TRANSFER_COS`
--

CREATE TABLE `LMS_TRANSFER_COS` (
  `tfcos_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `tfcos_datetime` datetime NOT NULL,
  `cos_id_ori` bigint(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_TYPECOS`
--

CREATE TABLE `LMS_TYPECOS` (
  `tc_id` bigint(50) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `tc_name_th` varchar(255) NOT NULL,
  `tc_name_en` varchar(250) NOT NULL,
  `tc_lesson` int(1) NOT NULL DEFAULT '0',
  `tc_pretest` int(1) NOT NULL DEFAULT '0',
  `tc_questionnaire` int(1) NOT NULL DEFAULT '0',
  `tc_qrcode` int(1) NOT NULL DEFAULT '0',
  `tc_student_enroll` int(1) NOT NULL DEFAULT '0',
  `tc_videocourse` int(1) NOT NULL DEFAULT '0',
  `tc_createdate` datetime NOT NULL,
  `tc_modifeddate` datetime NOT NULL,
  `tc_status` int(1) NOT NULL DEFAULT '1',
  `tc_color` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_TYPECOS`
--

INSERT INTO `LMS_TYPECOS` (`tc_id`, `com_id`, `tc_name_th`, `tc_name_en`, `tc_lesson`, `tc_pretest`, `tc_questionnaire`, `tc_qrcode`, `tc_student_enroll`, `tc_videocourse`, `tc_createdate`, `tc_modifeddate`, `tc_status`, `tc_color`) VALUES
(8, 2, 'E-learning', 'E-learning', 1, 1, 1, 1, 1, 1, '2019-01-30 14:28:20', '2019-01-30 08:28:20', 1, '#398bf7'),
(9, 2, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 1, 1, '2019-01-30 14:28:38', '2019-01-30 08:28:38', 1, '#39f744'),
(10, 3, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:29:06', '2020-01-31 10:22:20', 1, '#6599dd'),
(11, 3, 'ห้องเรียน', 'Classroom', 0, 0, 1, 1, 0, 0, '2020-01-24 10:29:06', '2020-01-24 10:29:06', 1, ''),
(12, 5, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:43:45', '2020-01-24 10:43:45', 1, ''),
(13, 5, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:43:46', '2020-01-24 10:43:46', 1, ''),
(14, 6, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:47:01', '2020-01-24 10:47:01', 1, ''),
(15, 6, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:47:01', '2020-01-24 10:47:01', 1, ''),
(16, 7, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:47:50', '2020-01-24 10:47:50', 1, ''),
(17, 7, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:47:50', '2020-01-24 10:47:50', 1, ''),
(18, 8, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:48:44', '2020-01-24 10:48:44', 1, ''),
(19, 8, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:48:45', '2020-01-24 10:48:45', 1, ''),
(20, 9, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:49:29', '2020-01-24 10:49:29', 1, ''),
(21, 9, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:49:29', '2020-01-24 10:49:29', 1, ''),
(22, 10, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:50:22', '2020-01-30 09:22:48', 1, '#347cdb'),
(23, 10, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:50:22', '2020-01-24 10:50:22', 1, ''),
(24, 11, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:51:06', '2020-01-24 10:51:06', 1, ''),
(25, 11, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:51:06', '2020-01-24 10:51:06', 1, ''),
(26, 12, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:51:51', '2020-01-24 10:51:51', 1, ''),
(27, 12, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:51:51', '2020-01-24 10:51:51', 1, ''),
(28, 13, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:52:41', '2020-01-24 10:52:41', 1, ''),
(29, 13, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:52:42', '2020-01-24 10:52:42', 1, ''),
(30, 14, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:53:36', '2020-01-24 10:53:36', 1, ''),
(31, 14, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:53:36', '2020-01-24 10:53:36', 1, ''),
(32, 15, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:54:23', '2020-01-24 10:54:23', 1, ''),
(33, 15, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:54:24', '2020-01-24 10:54:24', 1, ''),
(34, 16, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:55:16', '2020-01-24 10:55:16', 1, ''),
(35, 16, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:55:16', '2020-01-24 10:55:16', 1, ''),
(36, 17, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:55:58', '2020-01-24 10:55:58', 1, ''),
(37, 17, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:55:58', '2020-01-24 10:55:58', 1, ''),
(38, 18, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-01-24 10:56:41', '2020-01-24 10:56:41', 1, ''),
(39, 18, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-01-24 10:56:41', '2020-01-24 10:56:41', 1, ''),
(40, 19, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-02-06 18:50:05', '2020-02-06 18:50:05', 1, ''),
(41, 19, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-02-06 18:50:05', '2020-02-06 18:50:05', 1, ''),
(42, 20, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-02-06 18:50:36', '2020-02-06 18:50:36', 1, ''),
(43, 20, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-02-06 18:50:36', '2020-02-06 18:50:36', 1, ''),
(44, 21, 'E-learning', 'E-learning', 1, 1, 1, 0, 1, 0, '2020-02-06 18:51:00', '2020-02-06 18:51:00', 1, ''),
(45, 21, 'ห้องเรียน', 'Classroom', 0, 0, 0, 1, 0, 0, '2020-02-06 18:51:00', '2020-02-06 18:51:00', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_USP`
--

CREATE TABLE `LMS_USP` (
  `u_id` bigint(50) NOT NULL,
  `emp_id` int(50) DEFAULT NULL,
  `useri` varchar(255) NOT NULL,
  `userp` text NOT NULL,
  `last_act` datetime NOT NULL,
  `st_on` varchar(10) NOT NULL DEFAULT 'offline',
  `login` varchar(20) DEFAULT '1',
  `firsttime` int(11) NOT NULL DEFAULT '1',
  `expiredate` datetime NOT NULL,
  `dummy_status` int(1) NOT NULL DEFAULT '0' COMMENT '0 = No Dummy , 1 = Dummy',
  `dep_id` bigint(50) DEFAULT NULL,
  `posi_id` bigint(50) DEFAULT NULL,
  `ug_id` bigint(50) DEFAULT NULL,
  `img_profile` varchar(250) NOT NULL,
  `usp_point` decimal(10,2) NOT NULL COMMENT 'Point',
  `confirm_status` int(1) NOT NULL DEFAULT '1',
  `u_status` int(1) NOT NULL DEFAULT '1',
  `u_isDelete` int(1) NOT NULL DEFAULT '0',
  `u_createby` varchar(50) NOT NULL,
  `u_createdate` datetime NOT NULL,
  `u_modifiedby` varchar(50) NOT NULL,
  `u_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_USP`
--

INSERT INTO `LMS_USP` (`u_id`, `emp_id`, `useri`, `userp`, `last_act`, `st_on`, `login`, `firsttime`, `expiredate`, `dummy_status`, `dep_id`, `posi_id`, `ug_id`, `img_profile`, `usp_point`, `confirm_status`, `u_status`, `u_isDelete`, `u_createby`, `u_createdate`, `u_modifiedby`, `u_modifieddate`) VALUES
(1, 1, 'admin_verztec', 'e7dcccfa2751be1813f496d209bc07df3239a44f00af984f214d496206b68855', '2020-02-07 14:05:42', 'online', '1', 0, '2050-05-20 10:13:10', 0, 0, 0, 1, '1229900480178_20200124114157.jpg', '0.00', 1, 1, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_USP_GP`
--

CREATE TABLE `LMS_USP_GP` (
  `ug_id` bigint(50) NOT NULL,
  `ug_name_th` varchar(250) NOT NULL,
  `ug_name_en` varchar(255) NOT NULL,
  `ug_code` varchar(255) NOT NULL,
  `ug_for` varchar(250) NOT NULL COMMENT 'com_central,com_associated',
  `Is_admin` int(1) NOT NULL DEFAULT '0',
  `ug_approve` int(1) NOT NULL DEFAULT '0' COMMENT 'กลุ่มผู้ใช้งานนี้สามารถอนุมัติข้อมูลได้ หรือไม่ ?',
  `ug_viewdata` int(1) NOT NULL DEFAULT '1' COMMENT '1 = เห็นข้อมูลทุกบริษัท,2 = เห็นข้อมูลเฉพาะบริษัทของตัวเอง, 3 = เห็นเฉพาะข้อมูลของตัวเอง',
  `ug_status` int(1) NOT NULL DEFAULT '1',
  `ug_isDelete` int(1) NOT NULL DEFAULT '0',
  `ug_createby` varchar(50) NOT NULL,
  `ug_createdate` datetime NOT NULL,
  `ug_modifiedby` varchar(50) NOT NULL,
  `ug_modifieddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LMS_USP_GP`
--

INSERT INTO `LMS_USP_GP` (`ug_id`, `ug_name_th`, `ug_name_en`, `ug_code`, `ug_for`, `Is_admin`, `ug_approve`, `ug_viewdata`, `ug_status`, `ug_isDelete`, `ug_createby`, `ug_createdate`, `ug_modifiedby`, `ug_modifieddate`) VALUES
(1, 'IMAT Super Admin', 'IMAT Super Admin', '', 'com_central', 1, 1, 1, 1, 0, '', '2018-11-20 15:23:53', '', '0000-00-00 00:00:00'),
(2, 'Gr.Com Admin', 'Gr.Com Admin', '', 'com_associated', 1, 0, 2, 1, 0, '', '2019-06-18 14:33:38', '', '0000-00-00 00:00:00'),
(3, 'Instructor', 'Instructor', '', 'com_associated', 1, 0, 2, 1, 0, '', '2019-06-24 16:23:23', '', '0000-00-00 00:00:00'),
(4, 'Learner', 'Learner', '', 'com_associated', 0, 0, 3, 1, 0, '', '2019-06-20 15:59:52', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `LMS_USP_POINT`
--

CREATE TABLE `LMS_USP_POINT` (
  `up_id` bigint(50) NOT NULL,
  `cos_id` bigint(10) UNSIGNED DEFAULT NULL,
  `u_id` bigint(50) DEFAULT NULL,
  `usp_point` decimal(10,2) NOT NULL,
  `up_createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LMS_WKG`
--

CREATE TABLE `LMS_WKG` (
  `id` int(11) NOT NULL,
  `wcode` varchar(100) NOT NULL,
  `com_id` bigint(50) DEFAULT NULL,
  `wtitle_th` varchar(255) NOT NULL,
  `wdesc_th` text,
  `wtitle_en` varchar(255) NOT NULL,
  `wdesc_en` text NOT NULL,
  `wthumb` varchar(255) DEFAULT NULL,
  `c_date` datetime NOT NULL,
  `c_by` varchar(50) NOT NULL,
  `u_date` datetime DEFAULT NULL,
  `u_by` varchar(50) DEFAULT NULL,
  `wstatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `LMS_ABOUT`
--
ALTER TABLE `LMS_ABOUT`
  ADD PRIMARY KEY (`da_id`);

--
-- Indexes for table `LMS_ABOUT_BAN`
--
ALTER TABLE `LMS_ABOUT_BAN`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LMS_BAD`
--
ALTER TABLE `LMS_BAD`
  ADD PRIMARY KEY (`badges_id`),
  ADD KEY `fk_LMS_BAD_cid_idx` (`courses_id`);

--
-- Indexes for table `LMS_BAN`
--
ALTER TABLE `LMS_BAN`
  ADD PRIMARY KEY (`id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_BAN_COS`
--
ALTER TABLE `LMS_BAN_COS`
  ADD PRIMARY KEY (`bc_id`);

--
-- Indexes for table `LMS_CERTIFICATE`
--
ALTER TABLE `LMS_CERTIFICATE`
  ADD PRIMARY KEY (`cert_id`),
  ADD KEY `cos_id` (`cos_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `LMS_COG`
--
ALTER TABLE `LMS_COG`
  ADD PRIMARY KEY (`cg_id`);

--
-- Indexes for table `LMS_COMPANY`
--
ALTER TABLE `LMS_COMPANY`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `LMS_CONTENT`
--
ALTER TABLE `LMS_CONTENT`
  ADD PRIMARY KEY (`con_id`);

--
-- Indexes for table `LMS_COS`
--
ALTER TABLE `LMS_COS`
  ADD PRIMARY KEY (`cos_id`),
  ADD KEY `com_id` (`com_id`),
  ADD KEY `tc_id` (`tc_id`);

--
-- Indexes for table `LMS_COSINCG`
--
ALTER TABLE `LMS_COSINCG`
  ADD KEY `cg_id` (`cg_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `LMS_COS_DETAIL`
--
ALTER TABLE `LMS_COS_DETAIL`
  ADD PRIMARY KEY (`cosde_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_COS_DETAIL_UG`
--
ALTER TABLE `LMS_COS_DETAIL_UG`
  ADD PRIMARY KEY (`cosdepos_id`),
  ADD KEY `cosde_id` (`cosde_id`),
  ADD KEY `ug_id` (`posi_id`);

--
-- Indexes for table `LMS_COS_ENROLL`
--
ALTER TABLE `LMS_COS_ENROLL`
  ADD PRIMARY KEY (`cosen_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_COS_FIL`
--
ALTER TABLE `LMS_COS_FIL`
  ADD PRIMARY KEY (`fil_cos_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_COS_SORT`
--
ALTER TABLE `LMS_COS_SORT`
  ADD PRIMARY KEY (`coss_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_COS_VIDEO`
--
ALTER TABLE `LMS_COS_VIDEO`
  ADD PRIMARY KEY (`cosv_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_CUG`
--
ALTER TABLE `LMS_CUG`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_LMS_CUG_ccode_idx` (`course_id`);

--
-- Indexes for table `LMS_DEPART`
--
ALTER TABLE `LMS_DEPART`
  ADD PRIMARY KEY (`dep_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_EMP`
--
ALTER TABLE `LMS_EMP`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_FAQ`
--
ALTER TABLE `LMS_FAQ`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_LMS_FAQ_lang` (`lang`),
  ADD KEY `title` (`title`),
  ADD KEY `fk_LMS_FAQ_emp_c` (`emp_c`);

--
-- Indexes for table `LMS_FAQ_Q`
--
ALTER TABLE `LMS_FAQ_Q`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_LMS_FAQ_Q_title` (`tid`),
  ADD KEY `fk_LMS_FAQ_Q_emp_c` (`emp_c`);

--
-- Indexes for table `LMS_FIL`
--
ALTER TABLE `LMS_FIL`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_image_Lessons1_idx` (`lessons_id`);

--
-- Indexes for table `LMS_FIL_LOG`
--
ALTER TABLE `LMS_FIL_LOG`
  ADD PRIMARY KEY (`fil_log_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `fil_id` (`fil_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_FUNC_DASHBOARD`
--
ALTER TABLE `LMS_FUNC_DASHBOARD`
  ADD PRIMARY KEY (`fd_id`);

--
-- Indexes for table `LMS_LES`
--
ALTER TABLE `LMS_LES`
  ADD PRIMARY KEY (`les_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_LES_TC`
--
ALTER TABLE `LMS_LES_TC`
  ADD PRIMARY KEY (`lestc_id`),
  ADD KEY `les_id` (`les_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_LG`
--
ALTER TABLE `LMS_LG`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `LMS_LOG_ENROLL`
--
ALTER TABLE `LMS_LOG_ENROLL`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `cosen_id` (`cosen_id`);

--
-- Indexes for table `LMS_MAINMENU`
--
ALTER TABLE `LMS_MAINMENU`
  ADD PRIMARY KEY (`mm_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_MED`
--
ALTER TABLE `LMS_MED`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Media_Lessons1_idx` (`lessons_id`);

--
-- Indexes for table `LMS_MED_TC`
--
ALTER TABLE `LMS_MED_TC`
  ADD PRIMARY KEY (`medtc_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `med_id` (`med_id`);

--
-- Indexes for table `LMS_MENU`
--
ALTER TABLE `LMS_MENU`
  ADD PRIMARY KEY (`mu_id`);

--
-- Indexes for table `LMS_POSITION`
--
ALTER TABLE `LMS_POSITION`
  ADD PRIMARY KEY (`posi_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `LMS_QIZ`
--
ALTER TABLE `LMS_QIZ`
  ADD PRIMARY KEY (`qiz_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_QIZ_EXP`
--
ALTER TABLE `LMS_QIZ_EXP`
  ADD PRIMARY KEY (`qize_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_QIZ_TC`
--
ALTER TABLE `LMS_QIZ_TC`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_User_attempts_Quiz_TS_Quiz_id_idx` (`qiz_id`),
  ADD KEY `fk_User_attempts_Quiz_TS_User_Emp_C_idx` (`emp_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_QN_USER`
--
ALTER TABLE `LMS_QN_USER`
  ADD PRIMARY KEY (`qnu_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `LMS_QN_USER_ibfk_2` (`sv_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_QN_USER_DE`
--
ALTER TABLE `LMS_QN_USER_DE`
  ADD PRIMARY KEY (`qnude_id`),
  ADD KEY `qnu_id` (`qnu_id`),
  ADD KEY `LMS_QN_USER_DE_ibfk_2` (`svde_id`);

--
-- Indexes for table `LMS_QRCODE`
--
ALTER TABLE `LMS_QRCODE`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indexes for table `LMS_QUES`
--
ALTER TABLE `LMS_QUES`
  ADD PRIMARY KEY (`ques_id`),
  ADD KEY `qiz_id` (`qiz_id`);

--
-- Indexes for table `LMS_QUESE`
--
ALTER TABLE `LMS_QUESE`
  ADD PRIMARY KEY (`quese_id`),
  ADD KEY `qize_id` (`qize_id`);

--
-- Indexes for table `LMS_QUESE_MUL`
--
ALTER TABLE `LMS_QUESE_MUL`
  ADD PRIMARY KEY (`mule_id`),
  ADD KEY `quese_id` (`quese_id`);

--
-- Indexes for table `LMS_QUESTIONNAIRE`
--
ALTER TABLE `LMS_QUESTIONNAIRE`
  ADD PRIMARY KEY (`qn_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_QUESTIONNAIRE_DE`
--
ALTER TABLE `LMS_QUESTIONNAIRE_DE`
  ADD PRIMARY KEY (`qnde_id`),
  ADD KEY `qn_id` (`qn_id`);

--
-- Indexes for table `LMS_QUES_MUL`
--
ALTER TABLE `LMS_QUES_MUL`
  ADD PRIMARY KEY (`mul_id`),
  ADD KEY `ques_id` (`ques_id`);

--
-- Indexes for table `LMS_QUES_TC`
--
ALTER TABLE `LMS_QUES_TC`
  ADD PRIMARY KEY (`tc_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `ques_id` (`ques_id`),
  ADD KEY `qiz_id` (`qiz_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_ROLE_FD`
--
ALTER TABLE `LMS_ROLE_FD`
  ADD PRIMARY KEY (`rfd_id`),
  ADD KEY `fd_id` (`fd_id`),
  ADD KEY `ug_id` (`ug_id`);

--
-- Indexes for table `LMS_ROLE_GP`
--
ALTER TABLE `LMS_ROLE_GP`
  ADD KEY `mu_id` (`mu_id`),
  ADD KEY `ug_id` (`ug_id`);

--
-- Indexes for table `LMS_ROLE_USP`
--
ALTER TABLE `LMS_ROLE_USP`
  ADD KEY `mu_id` (`mu_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `LMS_SCM`
--
ALTER TABLE `LMS_SCM`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_id` (`lessons_id`);

--
-- Indexes for table `LMS_SCM_VAL`
--
ALTER TABLE `LMS_SCM_VAL`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `scm_id` (`scm_id`),
  ADD KEY `id_log` (`id_log`);

--
-- Indexes for table `LMS_SENDMAIL_COURSE`
--
ALTER TABLE `LMS_SENDMAIL_COURSE`
  ADD PRIMARY KEY (`smc_id`),
  ADD KEY `cos_id` (`cos_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `LMS_SENDMAIL_FORM`
--
ALTER TABLE `LMS_SENDMAIL_FORM`
  ADD PRIMARY KEY (`smf_id`);

--
-- Indexes for table `LMS_SETTING_MAIL`
--
ALTER TABLE `LMS_SETTING_MAIL`
  ADD PRIMARY KEY (`sm_id`);

--
-- Indexes for table `LMS_SETTING_SSO`
--
ALTER TABLE `LMS_SETTING_SSO`
  ADD PRIMARY KEY (`sso_id`);

--
-- Indexes for table `LMS_SURVEY`
--
ALTER TABLE `LMS_SURVEY`
  ADD PRIMARY KEY (`sv_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_SURVEY_DE`
--
ALTER TABLE `LMS_SURVEY_DE`
  ADD PRIMARY KEY (`svde_id`),
  ADD KEY `sv_id` (`sv_id`);

--
-- Indexes for table `LMS_TESTIMONIALS`
--
ALTER TABLE `LMS_TESTIMONIALS`
  ADD PRIMARY KEY (`tim_id`);

--
-- Indexes for table `LMS_TRANSFER_COS`
--
ALTER TABLE `LMS_TRANSFER_COS`
  ADD PRIMARY KEY (`tfcos_id`),
  ADD KEY `com_id` (`com_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_TYPECOS`
--
ALTER TABLE `LMS_TYPECOS`
  ADD PRIMARY KEY (`tc_id`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `LMS_USP`
--
ALTER TABLE `LMS_USP`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `ug_id` (`ug_id`),
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `useri_2` (`useri`),
  ADD KEY `posi_id` (`posi_id`);

--
-- Indexes for table `LMS_USP_GP`
--
ALTER TABLE `LMS_USP_GP`
  ADD PRIMARY KEY (`ug_id`);

--
-- Indexes for table `LMS_USP_POINT`
--
ALTER TABLE `LMS_USP_POINT`
  ADD PRIMARY KEY (`up_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `cos_id` (`cos_id`);

--
-- Indexes for table `LMS_WKG`
--
ALTER TABLE `LMS_WKG`
  ADD PRIMARY KEY (`id`),
  ADD KEY `com_id` (`com_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `LMS_ABOUT`
--
ALTER TABLE `LMS_ABOUT`
  MODIFY `da_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_ABOUT_BAN`
--
ALTER TABLE `LMS_ABOUT_BAN`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `LMS_BAD`
--
ALTER TABLE `LMS_BAD`
  MODIFY `badges_id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_BAN`
--
ALTER TABLE `LMS_BAN`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `LMS_BAN_COS`
--
ALTER TABLE `LMS_BAN_COS`
  MODIFY `bc_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_CERTIFICATE`
--
ALTER TABLE `LMS_CERTIFICATE`
  MODIFY `cert_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_COG`
--
ALTER TABLE `LMS_COG`
  MODIFY `cg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_COMPANY`
--
ALTER TABLE `LMS_COMPANY`
  MODIFY `com_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `LMS_CONTENT`
--
ALTER TABLE `LMS_CONTENT`
  MODIFY `con_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_COS`
--
ALTER TABLE `LMS_COS`
  MODIFY `cos_id` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_COS_DETAIL`
--
ALTER TABLE `LMS_COS_DETAIL`
  MODIFY `cosde_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `LMS_COS_DETAIL_UG`
--
ALTER TABLE `LMS_COS_DETAIL_UG`
  MODIFY `cosdepos_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT for table `LMS_COS_ENROLL`
--
ALTER TABLE `LMS_COS_ENROLL`
  MODIFY `cosen_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_COS_FIL`
--
ALTER TABLE `LMS_COS_FIL`
  MODIFY `fil_cos_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_COS_SORT`
--
ALTER TABLE `LMS_COS_SORT`
  MODIFY `coss_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_COS_VIDEO`
--
ALTER TABLE `LMS_COS_VIDEO`
  MODIFY `cosv_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_CUG`
--
ALTER TABLE `LMS_CUG`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_DEPART`
--
ALTER TABLE `LMS_DEPART`
  MODIFY `dep_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `LMS_EMP`
--
ALTER TABLE `LMS_EMP`
  MODIFY `emp_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_FAQ`
--
ALTER TABLE `LMS_FAQ`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `LMS_FAQ_Q`
--
ALTER TABLE `LMS_FAQ_Q`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `LMS_FIL`
--
ALTER TABLE `LMS_FIL`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_FIL_LOG`
--
ALTER TABLE `LMS_FIL_LOG`
  MODIFY `fil_log_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_FUNC_DASHBOARD`
--
ALTER TABLE `LMS_FUNC_DASHBOARD`
  MODIFY `fd_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `LMS_LES`
--
ALTER TABLE `LMS_LES`
  MODIFY `les_id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_LES_TC`
--
ALTER TABLE `LMS_LES_TC`
  MODIFY `lestc_id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_LG`
--
ALTER TABLE `LMS_LG`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `LMS_LOG_ENROLL`
--
ALTER TABLE `LMS_LOG_ENROLL`
  MODIFY `id_log` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_MAINMENU`
--
ALTER TABLE `LMS_MAINMENU`
  MODIFY `mm_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_MED`
--
ALTER TABLE `LMS_MED`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_MED_TC`
--
ALTER TABLE `LMS_MED_TC`
  MODIFY `medtc_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_MENU`
--
ALTER TABLE `LMS_MENU`
  MODIFY `mu_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `LMS_POSITION`
--
ALTER TABLE `LMS_POSITION`
  MODIFY `posi_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `LMS_QIZ`
--
ALTER TABLE `LMS_QIZ`
  MODIFY `qiz_id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QIZ_EXP`
--
ALTER TABLE `LMS_QIZ_EXP`
  MODIFY `qize_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QIZ_TC`
--
ALTER TABLE `LMS_QIZ_TC`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QN_USER`
--
ALTER TABLE `LMS_QN_USER`
  MODIFY `qnu_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QN_USER_DE`
--
ALTER TABLE `LMS_QN_USER_DE`
  MODIFY `qnude_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QRCODE`
--
ALTER TABLE `LMS_QRCODE`
  MODIFY `qr_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `LMS_QUES`
--
ALTER TABLE `LMS_QUES`
  MODIFY `ques_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUESE`
--
ALTER TABLE `LMS_QUESE`
  MODIFY `quese_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUESE_MUL`
--
ALTER TABLE `LMS_QUESE_MUL`
  MODIFY `mule_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUESTIONNAIRE`
--
ALTER TABLE `LMS_QUESTIONNAIRE`
  MODIFY `qn_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUESTIONNAIRE_DE`
--
ALTER TABLE `LMS_QUESTIONNAIRE_DE`
  MODIFY `qnde_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUES_MUL`
--
ALTER TABLE `LMS_QUES_MUL`
  MODIFY `mul_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_QUES_TC`
--
ALTER TABLE `LMS_QUES_TC`
  MODIFY `tc_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_ROLE_FD`
--
ALTER TABLE `LMS_ROLE_FD`
  MODIFY `rfd_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `LMS_SCM`
--
ALTER TABLE `LMS_SCM`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SCM_VAL`
--
ALTER TABLE `LMS_SCM_VAL`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SENDMAIL_COURSE`
--
ALTER TABLE `LMS_SENDMAIL_COURSE`
  MODIFY `smc_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SENDMAIL_FORM`
--
ALTER TABLE `LMS_SENDMAIL_FORM`
  MODIFY `smf_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SETTING_MAIL`
--
ALTER TABLE `LMS_SETTING_MAIL`
  MODIFY `sm_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_SETTING_SSO`
--
ALTER TABLE `LMS_SETTING_SSO`
  MODIFY `sso_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SURVEY`
--
ALTER TABLE `LMS_SURVEY`
  MODIFY `sv_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_SURVEY_DE`
--
ALTER TABLE `LMS_SURVEY_DE`
  MODIFY `svde_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_TESTIMONIALS`
--
ALTER TABLE `LMS_TESTIMONIALS`
  MODIFY `tim_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_TRANSFER_COS`
--
ALTER TABLE `LMS_TRANSFER_COS`
  MODIFY `tfcos_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_TYPECOS`
--
ALTER TABLE `LMS_TYPECOS`
  MODIFY `tc_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `LMS_USP`
--
ALTER TABLE `LMS_USP`
  MODIFY `u_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LMS_USP_GP`
--
ALTER TABLE `LMS_USP_GP`
  MODIFY `ug_id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `LMS_USP_POINT`
--
ALTER TABLE `LMS_USP_POINT`
  MODIFY `up_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LMS_WKG`
--
ALTER TABLE `LMS_WKG`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `LMS_BAN`
--
ALTER TABLE `LMS_BAN`
  ADD CONSTRAINT `LMS_BAN_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_CERTIFICATE`
--
ALTER TABLE `LMS_CERTIFICATE`
  ADD CONSTRAINT `LMS_CERTIFICATE_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_CERTIFICATE_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS`
--
ALTER TABLE `LMS_COS`
  ADD CONSTRAINT `LMS_COS_ibfk_2` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_COS_ibfk_3` FOREIGN KEY (`tc_id`) REFERENCES `lms_typecos` (`tc_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COSINCG`
--
ALTER TABLE `LMS_COSINCG`
  ADD CONSTRAINT `lms_cosincg_ibfk_1` FOREIGN KEY (`cg_id`) REFERENCES `lms_cog` (`cg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lms_cosincg_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_DETAIL`
--
ALTER TABLE `LMS_COS_DETAIL`
  ADD CONSTRAINT `LMS_COS_DETAIL_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_DETAIL_UG`
--
ALTER TABLE `LMS_COS_DETAIL_UG`
  ADD CONSTRAINT `LMS_COS_DETAIL_POS_ibfk_1` FOREIGN KEY (`cosde_id`) REFERENCES `lms_cos_detail` (`cosde_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lms_cos_detail_ug_ibfk_1` FOREIGN KEY (`posi_id`) REFERENCES `lms_position` (`posi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_ENROLL`
--
ALTER TABLE `LMS_COS_ENROLL`
  ADD CONSTRAINT `LMS_COS_ENROLL_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_COS_ENROLL_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_FIL`
--
ALTER TABLE `LMS_COS_FIL`
  ADD CONSTRAINT `LMS_COS_FIL_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_SORT`
--
ALTER TABLE `LMS_COS_SORT`
  ADD CONSTRAINT `LMS_COS_SORT_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_COS_VIDEO`
--
ALTER TABLE `LMS_COS_VIDEO`
  ADD CONSTRAINT `LMS_COS_VIDEO_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_CUG`
--
ALTER TABLE `LMS_CUG`
  ADD CONSTRAINT `LMS_CUG_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_DEPART`
--
ALTER TABLE `LMS_DEPART`
  ADD CONSTRAINT `LMS_DEPART_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_EMP`
--
ALTER TABLE `LMS_EMP`
  ADD CONSTRAINT `LMS_EMP_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_FAQ_Q`
--
ALTER TABLE `LMS_FAQ_Q`
  ADD CONSTRAINT `LMS_FAQ_Q_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `lms_faq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_FIL`
--
ALTER TABLE `LMS_FIL`
  ADD CONSTRAINT `LMS_FIL_ibfk_1` FOREIGN KEY (`lessons_id`) REFERENCES `lms_les` (`les_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_FIL_LOG`
--
ALTER TABLE `LMS_FIL_LOG`
  ADD CONSTRAINT `LMS_FIL_LOG_ibfk_1` FOREIGN KEY (`fil_id`) REFERENCES `lms_fil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_FIL_LOG_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_FIL_LOG_ibfk_3` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_LES`
--
ALTER TABLE `LMS_LES`
  ADD CONSTRAINT `LMS_LES_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_LES_TC`
--
ALTER TABLE `LMS_LES_TC`
  ADD CONSTRAINT `LMS_LES_TC_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_LES_TC_ibfk_2` FOREIGN KEY (`les_id`) REFERENCES `lms_les` (`les_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_LES_TC_ibfk_3` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_LG`
--
ALTER TABLE `LMS_LG`
  ADD CONSTRAINT `LMS_LG_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_LOG_ENROLL`
--
ALTER TABLE `LMS_LOG_ENROLL`
  ADD CONSTRAINT `LMS_LOG_ENROLL_ibfk_1` FOREIGN KEY (`cosen_id`) REFERENCES `lms_cos_enroll` (`cosen_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_MAINMENU`
--
ALTER TABLE `LMS_MAINMENU`
  ADD CONSTRAINT `LMS_MAINMENU_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_MED`
--
ALTER TABLE `LMS_MED`
  ADD CONSTRAINT `LMS_MED_ibfk_1` FOREIGN KEY (`lessons_id`) REFERENCES `lms_les` (`les_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_MED_TC`
--
ALTER TABLE `LMS_MED_TC`
  ADD CONSTRAINT `LMS_MED_TC_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_MED_TC_ibfk_2` FOREIGN KEY (`med_id`) REFERENCES `lms_med` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_POSITION`
--
ALTER TABLE `LMS_POSITION`
  ADD CONSTRAINT `LMS_POSITION_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `lms_depart` (`dep_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QIZ`
--
ALTER TABLE `LMS_QIZ`
  ADD CONSTRAINT `LMS_QIZ_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QIZ_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QIZ_EXP`
--
ALTER TABLE `LMS_QIZ_EXP`
  ADD CONSTRAINT `LMS_QIZ_EXP_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QIZ_TC`
--
ALTER TABLE `LMS_QIZ_TC`
  ADD CONSTRAINT `LMS_QIZ_TC_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QIZ_TC_ibfk_2` FOREIGN KEY (`qiz_id`) REFERENCES `lms_qiz` (`qiz_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QIZ_TC_ibfk_3` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QN_USER`
--
ALTER TABLE `LMS_QN_USER`
  ADD CONSTRAINT `LMS_QN_USER_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QN_USER_ibfk_2` FOREIGN KEY (`sv_id`) REFERENCES `lms_survey` (`sv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QN_USER_ibfk_3` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QN_USER_DE`
--
ALTER TABLE `LMS_QN_USER_DE`
  ADD CONSTRAINT `LMS_QN_USER_DE_ibfk_1` FOREIGN KEY (`qnu_id`) REFERENCES `lms_qn_user` (`qnu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QN_USER_DE_ibfk_2` FOREIGN KEY (`svde_id`) REFERENCES `lms_survey_de` (`svde_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUES`
--
ALTER TABLE `LMS_QUES`
  ADD CONSTRAINT `LMS_QUES_ibfk_1` FOREIGN KEY (`qiz_id`) REFERENCES `lms_qiz` (`qiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUESE`
--
ALTER TABLE `LMS_QUESE`
  ADD CONSTRAINT `LMS_QUESE_ibfk_1` FOREIGN KEY (`qize_id`) REFERENCES `lms_qiz_exp` (`qize_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUESE_MUL`
--
ALTER TABLE `LMS_QUESE_MUL`
  ADD CONSTRAINT `LMS_QUESE_MUL_ibfk_1` FOREIGN KEY (`quese_id`) REFERENCES `lms_quese` (`quese_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUESTIONNAIRE`
--
ALTER TABLE `LMS_QUESTIONNAIRE`
  ADD CONSTRAINT `LMS_QUESTIONNAIRE_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUESTIONNAIRE_DE`
--
ALTER TABLE `LMS_QUESTIONNAIRE_DE`
  ADD CONSTRAINT `LMS_QUESTIONNAIRE_DE_ibfk_1` FOREIGN KEY (`qn_id`) REFERENCES `lms_questionnaire` (`qn_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUES_MUL`
--
ALTER TABLE `LMS_QUES_MUL`
  ADD CONSTRAINT `LMS_QUES_MUL_ibfk_1` FOREIGN KEY (`ques_id`) REFERENCES `lms_ques` (`ques_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_QUES_TC`
--
ALTER TABLE `LMS_QUES_TC`
  ADD CONSTRAINT `LMS_QUES_TC_ibfk_1` FOREIGN KEY (`qiz_id`) REFERENCES `lms_qiz` (`qiz_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QUES_TC_ibfk_2` FOREIGN KEY (`ques_id`) REFERENCES `lms_ques` (`ques_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QUES_TC_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_QUES_TC_ibfk_4` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_ROLE_FD`
--
ALTER TABLE `LMS_ROLE_FD`
  ADD CONSTRAINT `lms_role_fd_ibfk_1` FOREIGN KEY (`fd_id`) REFERENCES `lms_func_dashboard` (`fd_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lms_role_fd_ibfk_2` FOREIGN KEY (`ug_id`) REFERENCES `lms_usp_gp` (`ug_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_ROLE_GP`
--
ALTER TABLE `LMS_ROLE_GP`
  ADD CONSTRAINT `LMS_ROLE_GP_ibfk_1` FOREIGN KEY (`ug_id`) REFERENCES `lms_usp_gp` (`ug_id`),
  ADD CONSTRAINT `LMS_ROLE_GP_ibfk_2` FOREIGN KEY (`mu_id`) REFERENCES `lms_menu` (`mu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_ROLE_USP`
--
ALTER TABLE `LMS_ROLE_USP`
  ADD CONSTRAINT `LMS_ROLE_USP_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `lms_usp` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_ROLE_USP_ibfk_2` FOREIGN KEY (`mu_id`) REFERENCES `lms_menu` (`mu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_SCM`
--
ALTER TABLE `LMS_SCM`
  ADD CONSTRAINT `LMS_SCM_ibfk_1` FOREIGN KEY (`lessons_id`) REFERENCES `lms_les` (`les_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_SCM_VAL`
--
ALTER TABLE `LMS_SCM_VAL`
  ADD CONSTRAINT `LMS_SCM_VAL_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_SCM_VAL_ibfk_2` FOREIGN KEY (`scm_id`) REFERENCES `lms_scm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_SCM_VAL_ibfk_3` FOREIGN KEY (`id_log`) REFERENCES `lms_log_enroll` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_SENDMAIL_COURSE`
--
ALTER TABLE `LMS_SENDMAIL_COURSE`
  ADD CONSTRAINT `LMS_SENDMAIL_COURSE_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_SENDMAIL_COURSE_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_SURVEY`
--
ALTER TABLE `LMS_SURVEY`
  ADD CONSTRAINT `LMS_SURVEY_ibfk_1` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_SURVEY_DE`
--
ALTER TABLE `LMS_SURVEY_DE`
  ADD CONSTRAINT `LMS_SURVEY_DE_ibfk_1` FOREIGN KEY (`sv_id`) REFERENCES `lms_survey` (`sv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_TRANSFER_COS`
--
ALTER TABLE `LMS_TRANSFER_COS`
  ADD CONSTRAINT `LMS_TRANSFER_COS_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_TRANSFER_COS_ibfk_2` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_TYPECOS`
--
ALTER TABLE `LMS_TYPECOS`
  ADD CONSTRAINT `LMS_TYPECOS_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_USP`
--
ALTER TABLE `LMS_USP`
  ADD CONSTRAINT `LMS_USP_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `lms_emp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_USP_ibfk_4` FOREIGN KEY (`ug_id`) REFERENCES `lms_usp_gp` (`ug_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_USP_POINT`
--
ALTER TABLE `LMS_USP_POINT`
  ADD CONSTRAINT `LMS_USP_POINT_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `lms_usp` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LMS_USP_POINT_ibfk_2` FOREIGN KEY (`cos_id`) REFERENCES `lms_cos` (`cos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LMS_WKG`
--
ALTER TABLE `LMS_WKG`
  ADD CONSTRAINT `LMS_WKG_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `lms_company` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
