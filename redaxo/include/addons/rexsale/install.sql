-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_cats`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_cats`;
CREATE TABLE `%TABLE_PREFIX%153_cats` (
  `fID` int(11) NOT NULL auto_increment,
  `rPARENT` int(11) NOT NULL default '0',
  `fSTATUS` int(11) NOT NULL default '0',
  `fSORTORDER` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_cats`
-- 
-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_cats_meta`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_cats_meta`;
CREATE TABLE `%TABLE_PREFIX%153_cats_meta` (
  `rCATID` int(11) NOT NULL default '0',
  `rCLANG` int(11) NOT NULL default '0',
  `fVALUE` text NOT NULL,
  `fTYPE` char(1) NOT NULL default '',
  `fINDEX` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_cats_meta`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_cats_names`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_cats_names`;
CREATE TABLE `%TABLE_PREFIX%153_cats_names` (
  `rCATID` int(11) NOT NULL default '0',
  `rCLANG` int(11) NOT NULL default '0',
  `fNAME` varchar(60) NOT NULL default '',
  `fINDEX` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_cats_names`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_countries`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_countries`;
CREATE TABLE `%TABLE_PREFIX%153_countries` (
  `fID` int(11) NOT NULL auto_increment,
  `fCODE` varchar(3) NOT NULL default '',
  `fNAME` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=239 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_countries`
-- 

INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (1, 'AD', 'Andorra');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (2, 'AE', 'United Arab Emirates');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (3, 'AF', 'Afghanistan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (4, 'AG', 'Antigua & Barbuda');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (5, 'AI', 'Anguilla');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (6, 'AL', 'Albania');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (7, 'AM', 'Armenia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (8, 'AN', 'Netherlands Antilles');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (9, 'AO', 'Angola');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (10, 'AQ', 'Antarctica');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (11, 'AR', 'Argentina');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (12, 'AS', 'American Samoa');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (13, 'AT', 'Austria');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (14, 'AU', 'Australia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (15, 'AW', 'Aruba');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (16, 'AZ', 'Azerbaijan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (17, 'BA', 'Bosnia and Herzegovina');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (18, 'BB', 'Barbados');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (19, 'BD', 'Bangladesh');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (20, 'BE', 'Belgium');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (21, 'BF', 'Burkina Faso');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (22, 'BG', 'Bulgaria');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (23, 'BH', 'Bahrain');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (24, 'BI', 'Burundi');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (25, 'BJ', 'Benin');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (26, 'BM', 'Bermuda');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (27, 'BN', 'Brunei Darussalam');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (28, 'BO', 'Bolivia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (29, 'BR', 'Brazil');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (30, 'BS', 'Bahama');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (31, 'BT', 'Bhutan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (32, 'BV', 'Bouvet Island');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (33, 'BW', 'Botswana');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (34, 'BY', 'Belarus');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (35, 'BZ', 'Belize');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (36, 'CA', 'Canada');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (37, 'CC', 'Cocos (Keeling) Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (38, 'CF', 'Central African Republic');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (39, 'CG', 'Congo');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (40, 'CH', 'Switzerland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (41, 'CI', 'Côte Divoire (Ivory Coast)');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (42, 'CK', 'Cook Iislands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (43, 'CL', 'Chile');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (44, 'CM', 'Cameroon');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (45, 'CN', 'China');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (46, 'CO', 'Colombia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (47, 'CR', 'Costa Rica');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (48, 'CU', 'Cuba');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (49, 'CV', 'Cape Verde');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (50, 'CX', 'Christmas Island');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (51, 'CY', 'Cyprus');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (52, 'CZ', 'Czech Republic');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (53, 'DE', 'Germany');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (54, 'DJ', 'Djibouti');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (55, 'DK', 'Denmark');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (56, 'DM', 'Dominica');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (57, 'DO', 'Dominican Republic');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (58, 'DZ', 'Algeria');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (59, 'EC', 'Ecuador');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (60, 'EE', 'Estonia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (61, 'EG', 'Egypt');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (62, 'EH', 'Western Sahara');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (63, 'ER', 'Eritrea');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (64, 'ES', 'Spain');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (65, 'ET', 'Ethiopia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (66, 'FI', 'Finland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (67, 'FJ', 'Fiji');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (68, 'FK', 'Falkland Islands (Malvinas)');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (69, 'FM', 'Micronesia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (70, 'FO', 'Faroe Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (71, 'FR', 'France');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (72, 'FX', 'France, Metropolitan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (73, 'GA', 'Gabon');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (74, 'GB', 'United Kingdom (Great Britain)');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (75, 'GD', 'Grenada');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (76, 'GE', 'Georgia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (77, 'GF', 'French Guiana');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (78, 'GH', 'Ghana');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (79, 'GI', 'Gibraltar');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (80, 'GL', 'Greenland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (81, 'GM', 'Gambia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (82, 'GN', 'Guinea');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (83, 'GP', 'Guadeloupe');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (84, 'GQ', 'Equatorial Guinea');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (85, 'GR', 'Greece');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (86, 'GS', 'South Georgia and the South Sandwich Isl');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (87, 'GT', 'Guatemala');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (88, 'GU', 'Guam');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (89, 'GW', 'Guinea-Bissau');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (90, 'GY', 'Guyana');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (91, 'HK', 'Hong Kong');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (92, 'HM', 'Heard & McDonald Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (93, 'HN', 'Honduras');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (94, 'HR', 'Croatia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (95, 'HT', 'Haiti');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (96, 'HU', 'Hungary');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (97, 'ID', 'Indonesia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (98, 'IE', 'Ireland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (99, 'IL', 'Israel');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (100, 'IN', 'India');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (101, 'IO', 'British Indian Ocean Territory');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (102, 'IQ', 'Iraq');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (103, 'IR', 'Islamic Republic of Iran');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (104, 'IS', 'Iceland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (105, 'IT', 'Italy');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (106, 'JM', 'Jamaica');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (107, 'JO', 'Jordan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (108, 'JP', 'Japan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (109, 'KE', 'Kenya');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (110, 'KG', 'Kyrgyzstan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (111, 'KH', 'Cambodia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (112, 'KI', 'Kiribati');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (113, 'KM', 'Comoros');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (114, 'KN', 'St. Kitts and Nevis');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (115, 'KP', 'Korea, Democratic Peoples Republic of');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (116, 'KR', 'Korea, Republic of');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (117, 'KW', 'Kuwait');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (118, 'KY', 'Cayman Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (119, 'KZ', 'Kazakhstan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (120, 'LA', 'Lao Peoples Democratic Republic');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (121, 'LB', 'Lebanon');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (122, 'LC', 'Saint Lucia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (123, 'LI', 'Liechtenstein');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (124, 'LK', 'Sri Lanka');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (125, 'LR', 'Liberia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (126, 'LS', 'Lesotho');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (127, 'LT', 'Lithuania');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (128, 'LU', 'Luxembourg');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (129, 'LV', 'Latvia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (130, 'LY', 'Libyan Arab Jamahiriya');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (131, 'MA', 'Morocco');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (132, 'MC', 'Monaco');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (133, 'MD', 'Moldova, Republic of');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (134, 'MG', 'Madagascar');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (135, 'MH', 'Marshall Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (136, 'ML', 'Mali');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (137, 'MN', 'Mongolia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (138, 'MM', 'Myanmar');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (139, 'MO', 'Macau');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (140, 'MP', 'Northern Mariana Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (141, 'MQ', 'Martinique');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (142, 'MR', 'Mauritania');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (143, 'MS', 'Monserrat');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (144, 'MT', 'Malta');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (145, 'MU', 'Mauritius');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (146, 'MV', 'Maldives');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (147, 'MW', 'Malawi');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (148, 'MX', 'Mexico');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (149, 'MY', 'Malaysia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (150, 'MZ', 'Mozambique');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (151, 'NA', 'Namibia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (152, 'NC', 'New Caledonia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (153, 'NE', 'Niger');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (154, 'NF', 'Norfolk Island');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (155, 'NG', 'Nigeria');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (156, 'NI', 'Nicaragua');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (157, 'NL', 'Netherlands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (158, 'NO', 'Norway');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (159, 'NP', 'Nepal');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (160, 'NR', 'Nauru');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (161, 'NU', 'Niue');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (162, 'NZ', 'New Zealand');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (163, 'OM', 'Oman');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (164, 'PA', 'Panama');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (165, 'PE', 'Peru');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (166, 'PF', 'French Polynesia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (167, 'PG', 'Papua New Guinea');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (168, 'PH', 'Philippines');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (169, 'PK', 'Pakistan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (170, 'PL', 'Poland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (171, 'PM', 'St. Pierre & Miquelon');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (172, 'PN', 'Pitcairn');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (173, 'PR', 'Puerto Rico');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (174, 'PT', 'Portugal');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (175, 'PW', 'Palau');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (176, 'PY', 'Paraguay');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (177, 'QA', 'Qatar');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (178, 'RE', 'Réunion');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (179, 'RO', 'Romania');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (180, 'RU', 'Russian Federation');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (181, 'RW', 'Rwanda');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (182, 'SA', 'Saudi Arabia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (183, 'SB', 'Solomon Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (184, 'SC', 'Seychelles');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (185, 'SD', 'Sudan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (186, 'SE', 'Sweden');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (187, 'SG', 'Singapore');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (188, 'SH', 'St. Helena');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (189, 'SI', 'Slovenia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (190, 'SJ', 'Svalbard & Jan Mayen Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (191, 'SK', 'Slovakia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (192, 'SL', 'Sierra Leone');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (193, 'SM', 'San Marino');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (194, 'SN', 'Senegal');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (195, 'SO', 'Somalia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (196, 'SR', 'Suriname');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (197, 'ST', 'Sao Tome & Principe');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (198, 'SV', 'El Salvador');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (199, 'SY', 'Syrian Arab Republic');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (200, 'SZ', 'Swaziland');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (201, 'TC', 'Turks & Caicos Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (202, 'TD', 'Chad');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (203, 'TF', 'French Southern Territories');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (204, 'TG', 'Togo');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (205, 'TH', 'Thailand');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (206, 'TJ', 'Tajikistan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (207, 'TK', 'Tokelau');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (208, 'TM', 'Turkmenistan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (209, 'TN', 'Tunisia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (210, 'TO', 'Tonga');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (211, 'TP', 'East Timor');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (212, 'TR', 'Turkey');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (213, 'TT', 'Trinidad & Tobago');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (214, 'TV', 'Tuvalu');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (215, 'TW', 'Taiwan, Province of China');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (216, 'TZ', 'Tanzania, United Republic of');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (217, 'UA', 'Ukraine');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (218, 'UG', 'Uganda');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (219, 'UM', 'United States Minor Outlying Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (220, 'US', 'United States of America');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (221, 'UY', 'Uruguay');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (222, 'UZ', 'Uzbekistan');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (223, 'VA', 'Vatican City State (Holy See)');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (224, 'VC', 'St. Vincent & the Grenadines');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (225, 'VE', 'Venezuela');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (226, 'VG', 'British Virgin Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (227, 'VI', 'United States Virgin Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (228, 'VN', 'Viet Nam');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (229, 'VU', 'Vanuatu');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (230, 'WF', 'Wallis & Futuna Islands');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (231, 'WS', 'Samoa');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (232, 'YE', 'Yemen');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (233, 'YT', 'Mayotte');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (234, 'YU', 'Yugoslavia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (235, 'ZA', 'South Africa');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (236, 'ZM', 'Zambia');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (237, 'ZR', 'Zaire');
INSERT INTO `%TABLE_PREFIX%153_countries` (`fID`, `fCODE`, `fNAME`) VALUES (238, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_images`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_images`;
CREATE TABLE `%TABLE_PREFIX%153_images` (
  `fID` int(11) NOT NULL auto_increment,
  `rPROD` int(11) NOT NULL default '0',
  `fFILE` varchar(100) NOT NULL default '',
  `fSORT` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_images`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_options`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_options`;
CREATE TABLE `%TABLE_PREFIX%153_options` (
  `fID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_options`
-- 

INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (2);
INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (3);
INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (4);
INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (5);
INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (6);
INSERT INTO `%TABLE_PREFIX%153_options` (`fID`) VALUES (7);

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_options2products`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_options2products`;
CREATE TABLE `%TABLE_PREFIX%153_options2products` (
  `rPRODID` int(11) NOT NULL default '0',
  `rOPTIONID` int(11) NOT NULL default '0',
  `fSORT` int(11) NOT NULL default '0'
) ENGINE=MyISAM ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_options2products`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_options_names`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_options_names`;
CREATE TABLE `%TABLE_PREFIX%153_options_names` (
  `fINDEX` int(11) NOT NULL auto_increment,
  `rOPTIONID` int(11) NOT NULL default '0',
  `rCLANGID` int(11) NOT NULL default '0',
  `fNAME` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=63 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_options_names`
-- 

INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (33, 24, 0, 'Größe');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (35, 26, 0, 'Duft');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (48, 39, 0, 'Farbe');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (52, 43, 0, 'Rahmen');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (58, 4, 0, 'Speicher');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (54, 2, 0, 'Farbe');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (55, 2, 1, 'Colour');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (57, 3, 0, 'Größe');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (59, 4, 1, 'Capacity');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (60, 5, 0, 'Grafikkarte');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (61, 6, 0, 'Festplatte');
INSERT INTO `%TABLE_PREFIX%153_options_names` (`fINDEX`, `rOPTIONID`, `rCLANGID`, `fNAME`) VALUES (62, 7, 0, 'Tastatur');

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_payments`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_payments`;
CREATE TABLE `%TABLE_PREFIX%153_payments` (
  `fID` int(11) NOT NULL auto_increment,
  `fNAME` varchar(40) NOT NULL default '',
  `fFOLDER` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_payments`
-- 

INSERT INTO `%TABLE_PREFIX%153_payments` (`fID`, `fNAME`, `fFOLDER`) VALUES (1, 'Bankeinzug / Direct Debit', '');
INSERT INTO `%TABLE_PREFIX%153_payments` (`fID`, `fNAME`, `fFOLDER`) VALUES (2, 'Nachnahme / COA', '');
INSERT INTO `%TABLE_PREFIX%153_payments` (`fID`, `fNAME`, `fFOLDER`) VALUES (3, 'Vorkasse', '');
INSERT INTO `%TABLE_PREFIX%153_payments` (`fID`, `fNAME`, `fFOLDER`) VALUES (4, 'Rechnung', '');
INSERT INTO `%TABLE_PREFIX%153_payments` (`fID`, `fNAME`, `fFOLDER`) VALUES (5, 'PayPal / Kreditkarte', 'PAYPAL');

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_products`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_products`;
CREATE TABLE `%TABLE_PREFIX%153_products` (
  `fID` int(11) NOT NULL auto_increment,
  `fSTATUS` int(11) NOT NULL default '0',
  `fPRICE` float NOT NULL default '0',
  `rTAXID` int(11) NOT NULL default '0',
  `fMANU` varchar(40) NOT NULL,
  `fMAKE` varchar(40) NOT NULL,
  `fARTNR` varchar(40) NOT NULL,
  `fEAN` varchar(40) NOT NULL,
  `fUPC` varchar(40) NOT NULL,
  `fISBN` varchar(40) NOT NULL,
  `fCODE` varchar(40) NOT NULL,
  `fSORTORDER` int(11) NOT NULL default '0',
  `fSPECIAL` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_products`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_products2cats`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_products2cats`;
CREATE TABLE `%TABLE_PREFIX%153_products2cats` (
  `rCAT` int(11) NOT NULL default '0',
  `rPROD` int(11) NOT NULL default '0',
  `fINDEX` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=55 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_products2cats`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_products_descs`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_products_descs`;
CREATE TABLE `%TABLE_PREFIX%153_products_descs` (
  `fINDEX` int(11) NOT NULL auto_increment,
  `rCLANG` int(11) NOT NULL default '0',
  `rPRODID` int(11) NOT NULL default '0',
  `fDESC1` text NOT NULL,
  `fDESC2` text NOT NULL,
  `fDESC3` text NOT NULL,
  `fDESC4` text NOT NULL,
  `fDESC5` text NOT NULL,
  `fMETATITLE` text NOT NULL,
  `fMETAKEYWORDS` text NOT NULL,
  `fMETADESC` text NOT NULL,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_products_descs`
-- 
-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_products_names`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_products_names`;
CREATE TABLE `%TABLE_PREFIX%153_products_names` (
  `rPRODID` int(11) NOT NULL default '0',
  `rCLANG` int(11) NOT NULL default '0',
  `fNAME` varchar(100) NOT NULL default '',
  `fINDEX` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_products_names`
-- 
-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_sef`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_sef`;
CREATE TABLE `%TABLE_PREFIX%153_sef` (
  `fID` int(11) NOT NULL auto_increment,
  `fMODE` char(1) NOT NULL default '',
  `fURL` text NOT NULL,
  `rID` int(11) NOT NULL default '0',
  `rCATID` int(11) NOT NULL default '0',
  `rCLANG` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_sef`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_shipping`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_shipping`;
CREATE TABLE `%TABLE_PREFIX%153_shipping` (
  `fID` int(11) NOT NULL auto_increment,
  `fNAME` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_shipping`
-- 

INSERT INTO `%TABLE_PREFIX%153_shipping` (`fID`, `fNAME`) VALUES (1, 'Deutschland / Germany (Inland)');
INSERT INTO `%TABLE_PREFIX%153_shipping` (`fID`, `fNAME`) VALUES (2, 'Ausland');

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_shipping2payments`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_shipping2payments`;
CREATE TABLE `%TABLE_PREFIX%153_shipping2payments` (
  `fID` int(11) NOT NULL auto_increment,
  `rSHIPPINGID` int(11) NOT NULL default '0',
  `rPAYMENTID` int(11) NOT NULL default '0',
  `fCOST` float NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=9;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_shipping2payments`
-- 

INSERT INTO `%TABLE_PREFIX%153_shipping2payments` (`fID`, `rSHIPPINGID`, `rPAYMENTID`, `fCOST`) VALUES (2, 1, 2, 5.2);
INSERT INTO `%TABLE_PREFIX%153_shipping2payments` (`fID`, `rSHIPPINGID`, `rPAYMENTID`, `fCOST`) VALUES (3, 1, 3, 5.2);
INSERT INTO `%TABLE_PREFIX%153_shipping2payments` (`fID`, `rSHIPPINGID`, `rPAYMENTID`, `fCOST`) VALUES (4, 2, 3, 0);
INSERT INTO `%TABLE_PREFIX%153_shipping2payments` (`fID`, `rSHIPPINGID`, `rPAYMENTID`, `fCOST`) VALUES (5, 1, 4, 5.2);
INSERT INTO `%TABLE_PREFIX%153_shipping2payments` (`fID`, `rSHIPPINGID`, `rPAYMENTID`, `fCOST`) VALUES (8, 1, 5, 5.2);

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_tax`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_tax`;
CREATE TABLE `%TABLE_PREFIX%153_tax` (
  `fID` int(11) NOT NULL auto_increment,
  `fNAME` varchar(20) NOT NULL default '',
  `fAMOUNT` float NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_tax`
-- 

INSERT INTO `%TABLE_PREFIX%153_tax` (`fID`, `fNAME`, `fAMOUNT`) VALUES (1, '19% MwSt.', 0.19);
INSERT INTO `%TABLE_PREFIX%153_tax` (`fID`, `fNAME`, `fAMOUNT`) VALUES (2, '7% MwSt.', 0.07);
INSERT INTO `%TABLE_PREFIX%153_tax` (`fID`, `fNAME`, `fAMOUNT`) VALUES (3, '0%', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_users`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_users`;
CREATE TABLE `%TABLE_PREFIX%153_users` (
  `fID` int(11) NOT NULL auto_increment,
  `fEMAIL` varchar(60) NOT NULL default '',
  `fPASSWORD` varchar(32) NOT NULL default '',
  `fPHONE` varchar(40) NOT NULL default '',
  `fBILL_FIRST_NAME` varchar(40) NOT NULL default '',
  `fBILL_LAST_NAME` varchar(40) NOT NULL default '',
  `fBILL_COMPANY` varchar(40) NOT NULL default '',
  `fBILL_STREET` varchar(40) NOT NULL default '',
  `fBILL_TOWN` varchar(40) NOT NULL default '',
  `fBILL_STATE` varchar(40) NOT NULL default '',
  `fBILL_POST` varchar(40) NOT NULL default '',
  `rBILL_COUNTRY` int(11) NOT NULL default '0',
  `fDEL_FIRST_NAME` varchar(40) NOT NULL default '',
  `fDEL_LAST_NAME` varchar(40) NOT NULL default '',
  `fDEL_COMPANY` varchar(40) NOT NULL default '',
  `fDEL_STREET` varchar(40) NOT NULL default '',
  `fDEL_TOWN` varchar(40) NOT NULL default '',
  `fDEL_STATE` varchar(40) NOT NULL default '',
  `fDEL_POST` varchar(40) NOT NULL default '',
  `rDEL_COUNTRY` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=40 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_users`
-- 

INSERT INTO `%TABLE_PREFIX%153_users` (`fID`, `fEMAIL`, `fPASSWORD`, `fPHONE`, `fBILL_FIRST_NAME`, `fBILL_LAST_NAME`, `fBILL_COMPANY`, `fBILL_STREET`, `fBILL_TOWN`, `fBILL_STATE`, `fBILL_POST`, `rBILL_COUNTRY`, `fDEL_FIRST_NAME`, `fDEL_LAST_NAME`, `fDEL_COMPANY`, `fDEL_STREET`, `fDEL_TOWN`, `fDEL_STATE`, `fDEL_POST`, `rDEL_COUNTRY`) VALUES (34, 'dh@gn2-netwerk.de', '570a90bfbf8c7eab5dc5d4e26832d5b1', '09561 511690', 'Dave', 'Holloway', 'GN2-Netwerk.de', 'Rosenauser Strasse 98', 'Coburg', 'Bayern', '96450', 1, 'Ab', 'B', 'C', 'D', 'E', 'Bayern', 'G', 15);
INSERT INTO `%TABLE_PREFIX%153_users` (`fID`, `fEMAIL`, `fPASSWORD`, `fPHONE`, `fBILL_FIRST_NAME`, `fBILL_LAST_NAME`, `fBILL_COMPANY`, `fBILL_STREET`, `fBILL_TOWN`, `fBILL_STATE`, `fBILL_POST`, `rBILL_COUNTRY`, `fDEL_FIRST_NAME`, `fDEL_LAST_NAME`, `fDEL_COMPANY`, `fDEL_STREET`, `fDEL_TOWN`, `fDEL_STATE`, `fDEL_POST`, `rDEL_COUNTRY`) VALUES (35, 'support@gn2-netwerk.de', '16d7a4fca7442dda3ad93c9a726597e4', '09561/511 690', 'Ruediger', 'Nitzsche', '', 'rosenauer str. 98', 'coburg', 'bayern', '96450', 53, '', '', '', '', '', '', '', 0);


-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_values`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_values`;
CREATE TABLE `%TABLE_PREFIX%153_values` (
  `fID` int(11) NOT NULL auto_increment,
  `rOPTIONID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_values`
-- 

INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (9, 3);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (8, 3);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (7, 3);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (4, 2);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (5, 2);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (6, 2);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (10, 4);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (11, 4);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (12, 5);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (13, 5);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (14, 5);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (15, 4);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (16, 6);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (17, 6);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (18, 6);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (19, 7);
INSERT INTO `%TABLE_PREFIX%153_values` (`fID`, `rOPTIONID`) VALUES (20, 7);

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_values2products`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_values2products`;
CREATE TABLE `%TABLE_PREFIX%153_values2products` (
  `rPRODID` int(11) NOT NULL default '0',
  `rVALUEID` int(11) NOT NULL default '0',
  `rOPTIONID` int(11) NOT NULL default '0',
  `fSORT` int(11) NOT NULL default '0',
  `fOPTSORT` int(11) NOT NULL default '0',
  `fINDEX` int(11) NOT NULL auto_increment,
  `fPRICE` float NOT NULL default '0',
  `fMODIFIER` char(1) NOT NULL default '+',
  `fDEPS` text NOT NULL,
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=17;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_values2products`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `%TABLE_PREFIX%153_values_names`
-- 

DROP TABLE IF EXISTS `%TABLE_PREFIX%153_values_names`;
CREATE TABLE `%TABLE_PREFIX%153_values_names` (
  `fINDEX` int(11) NOT NULL auto_increment,
  `rVALID` int(11) NOT NULL default '0',
  `rCLANGID` int(11) NOT NULL default '0',
  `fNAME` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`fINDEX`)
) ENGINE=MyISAM AUTO_INCREMENT=24 ;

-- 
-- Dumping data for table `%TABLE_PREFIX%153_values_names`
-- 

INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (11, 8, 0, 'M');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (13, 10, 0, '2gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (10, 7, 0, 'L');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (4, 4, 0, 'Rot');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (5, 5, 0, 'Grün');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (6, 6, 0, 'Blau');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (7, 4, 1, 'Red');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (8, 5, 1, 'Green');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (9, 6, 1, 'Blue');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (14, 11, 0, '4gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (12, 9, 0, 'S');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (15, 12, 0, 'nVidia 256mb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (16, 13, 0, 'nVidia 512mb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (17, 14, 0, 'Matrox ImaginaryCard 2048mb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (18, 15, 0, '1gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (19, 16, 0, '80gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (20, 17, 0, '120gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (21, 18, 0, '250gb');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (22, 19, 0, 'Mit Kabel');
INSERT INTO `%TABLE_PREFIX%153_values_names` (`fINDEX`, `rVALID`, `rCLANGID`, `fNAME`) VALUES (23, 20, 0, 'Ohne Kabel (Bluetooth)');
