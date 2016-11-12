-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: ibou
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

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
-- Table structure for table `choice`
--

DROP TABLE IF EXISTS `choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `choice` (
  `choiceid` int(11) NOT NULL AUTO_INCREMENT,
  `cnum` int(11) NOT NULL,
  `linkqnid` int(11) DEFAULT NULL,
  `choicecontent` text,
  `weighting` int(11) DEFAULT NULL,
  `qid` int(11) NOT NULL,
  PRIMARY KEY (`choiceid`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choice`
--

LOCK TABLES `choice` WRITE;
/*!40000 ALTER TABLE `choice` DISABLE KEYS */;
INSERT INTO `choice` VALUES (10,0,NULL,'íŒŒëž‘',NULL,7),(11,1,NULL,'ë¹¨ê°•',NULL,7),(12,2,NULL,'ë…¸ëž‘',NULL,7);
/*!40000 ALTER TABLE `choice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `f_k_rel`
--

DROP TABLE IF EXISTS `f_k_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_k_rel` (
  `k_num` int(11) NOT NULL,
  `f_num` int(11) NOT NULL,
  `f_k_attach_date` date NOT NULL,
  PRIMARY KEY (`k_num`,`f_num`),
  KEY `f_num` (`f_num`),
  CONSTRAINT `f_k_rel_ibfk_1` FOREIGN KEY (`k_num`) REFERENCES `keywords` (`k_num`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `f_k_rel_ibfk_2` FOREIGN KEY (`f_num`) REFERENCES `files` (`f_num`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `f_k_rel`
--

LOCK TABLES `f_k_rel` WRITE;
/*!40000 ALTER TABLE `f_k_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_k_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `f_num` int(11) NOT NULL AUTO_INCREMENT,
  `f_origin_name` varchar(80) NOT NULL,
  `f_saved_name` varchar(80) DEFAULT NULL,
  `f_path` varchar(100) NOT NULL,
  `f_ext` varchar(10) NOT NULL,
  `f_upload_date` datetime NOT NULL,
  `f_update_date` datetime NOT NULL,
  PRIMARY KEY (`f_num`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (111,'Jellyfish.jpg','67d10137ffa2bbf1af014da152f4753c.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-24 03:03:00','0000-00-00 00:00:00'),(112,'Koala.jpg','f85ab2ad1ec2e6e7718fbedace9df2a7.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-24 03:03:00','0000-00-00 00:00:00'),(113,'Lighthouse.jpg','a88b8f54cc3fb4b72e30fbca7c91f39c.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-24 03:03:00','0000-00-00 00:00:00'),(114,'Penguins.jpg','7679e859ce137964a465282fc011fe8c.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-24 03:03:00','0000-00-00 00:00:00'),(115,'경기도가평.jpg','afac4578e955e08196c3c672947ed5c9.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-26 10:58:00','0000-00-00 00:00:00'),(116,'송년회장소3.jpg','4234658d76d730646caff45e5795ed7b.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-26 11:00:00','0000-00-00 00:00:00'),(117,'word.jpg','4b23b146d2535d1cf9d21681b79630c4.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-26 11:00:00','0000-00-00 00:00:00'),(118,'송년회알림.jpg','de50782a8117a5f3f829ddf3bda0622f.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-26 11:01:00','0000-00-00 00:00:00'),(119,'Desert.jpg','bb5e054bd5b8d3d3259cb941a9c1596f.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-27 09:09:00','0000-00-00 00:00:00'),(120,'Hydrangeas.jpg','9bcb3ddf83b136e35bc30e21e56336f6.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-27 09:09:00','0000-00-00 00:00:00'),(121,'Jellyfish.jpg','2511830f6f18d0010899be0ca64f8c04.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-27 09:09:00','0000-00-00 00:00:00'),(122,'Koala.jpg','9d948a39009d57a3805010bc17ca9e29.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-27 09:09:00','0000-00-00 00:00:00'),(123,'Lighthouse.jpg','c4a823c5dfb6c6680b98e4a07129a3f0.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-27 09:09:00','0000-00-00 00:00:00'),(124,'1조_건조대건조_스타크래프트설계.zip','5b228239acad9131f7616701077fc5e5.zip','/home/ubuntu/workspace/download/','.zip','2016-06-28 06:48:00','0000-00-00 00:00:00'),(125,'자바_조편성.txt','1eb7cc8218a16906e335c03d639556fa.txt','/home/ubuntu/workspace/download/','.txt','2016-06-28 06:48:00','0000-00-00 00:00:00'),(126,'game2.jpg','a7402e22e3b8bc701797f25c03221002.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-28 06:48:00','0000-00-00 00:00:00'),(127,'mygame.jpg','6bb7523326a06dd00c95bf7e18ac38f0.jpg','/home/ubuntu/workspace/download/','.jpg','2016-06-28 06:48:00','0000-00-00 00:00:00'),(129,'Hydrangeas.jpg','82a946d117de534ddae2815f008ce2de.jpg','/home/ubuntu/workspace/download/','.jpg','2016-07-01 09:05:00','0000-00-00 00:00:00'),(130,'Desert.jpg','2f3e1c1406c1022f00e326be001e400c.jpg','/home/ubuntu/workspace/download/','.jpg','2016-07-01 11:20:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `f_num` int(11) NOT NULL,
  `m_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (5,7),(8,7),(9,7),(10,7),(8,37),(9,37),(20,37);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keywords` (
  `k_num` int(11) NOT NULL AUTO_INCREMENT,
  `w_num` int(11) NOT NULL,
  `m_num` int(11) NOT NULL,
  `k_word` varchar(100) NOT NULL,
  `k_parent` int(11) NOT NULL DEFAULT '0',
  `k_depth` int(11) NOT NULL,
  `k_created_date` date NOT NULL,
  `k_edited_date` date NOT NULL,
  PRIMARY KEY (`k_num`),
  KEY `w_num` (`w_num`),
  KEY `m_num` (`m_num`),
  KEY `k_parent` (`k_parent`),
  CONSTRAINT `keywords_ibfk_1` FOREIGN KEY (`w_num`) REFERENCES `workbench` (`w_num`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `keywords_ibfk_2` FOREIGN KEY (`m_num`) REFERENCES `member` (`m_num`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
INSERT INTO `keywords` VALUES (105,14,1,'송년회',0,0,'2016-06-20','2016-06-20'),(106,14,1,'일시',105,1,'2016-06-20','2016-06-20'),(107,14,1,'장소',105,1,'2016-06-20','2016-06-20'),(109,14,1,'한국',107,2,'2016-06-20','2016-06-20'),(110,14,1,'도쿄',107,2,'2016-06-20','2016-06-20'),(113,14,1,'12월 말',106,2,'2016-06-20','2016-06-20'),(114,14,1,'12월 중순',106,2,'2016-06-20','2016-06-20'),(115,14,1,'12월 초',106,2,'2016-06-20','2016-06-20'),(118,14,1,'교통수단',110,3,'2016-06-20','2016-06-20'),(119,14,1,'비행기',118,4,'2016-06-20','2016-06-20'),(120,14,1,'배',118,4,'2016-06-20','2016-06-20'),(131,14,1,'서울',109,3,'2016-06-20','2016-06-20'),(132,14,1,'구체적 장소',131,4,'2016-06-20','2016-06-20'),(133,14,1,'호텔',132,5,'2016-06-20','2016-06-20'),(134,14,1,'레스토랑',132,5,'2016-06-20','2016-06-20'),(135,14,1,'야외장소',132,5,'2016-06-20','2016-06-20'),(136,14,1,'비용',120,5,'2016-06-20','2016-06-20'),(137,14,1,'비용',119,5,'2016-06-20','2016-06-20'),(138,14,1,'섭외비용',134,6,'2016-06-20','2016-06-20'),(139,14,1,'섭외비용',135,6,'2016-06-20','2016-06-20'),(140,14,1,'섭외비용',133,6,'2016-06-20','2016-06-20'),(142,14,1,'섭외담당자(신명길)',138,7,'2016-06-20','2016-06-20'),(143,14,1,'섭외담당자(김광연)',139,7,'2016-06-20','2016-06-20'),(144,14,1,'섭외담당자(박세진)',140,7,'2016-06-20','2016-06-20'),(145,14,1,'단체비용',137,6,'2016-06-20','2016-06-20'),(146,14,1,'단체비용',136,6,'2016-06-20','2016-06-20'),(147,14,1,'개인비용',136,6,'2016-06-20','2016-06-20'),(148,14,1,'개인비용',137,6,'2016-06-20','2016-06-20'),(151,14,1,'12월 30일',115,3,'2016-06-21','2016-06-21'),(152,14,1,'11월',151,4,'2016-06-21','2016-06-21'),(153,14,1,'asdf',106,2,'2016-06-22','2016-06-22'),(154,14,1,'10월',106,2,'2016-06-26','2016-06-26'),(155,14,1,'27~28일',113,3,'2016-06-28','2016-06-28'),(157,14,1,'ㅎ2',155,4,'2016-06-28','2016-06-28'),(160,14,1,'일본어시간',157,5,'2016-06-28','2016-06-28'),(162,14,1,'중순',154,3,'2016-06-28','2016-06-28'),(163,14,1,'초순',154,3,'2016-06-28','2016-06-28'),(164,14,1,'월말',154,3,'2016-06-28','2016-06-28'),(165,15,1,'테스트',0,0,'2016-06-30','2016-06-30'),(166,14,1,'7일',164,4,'2016-06-30','2016-06-30'),(172,16,10,'',0,0,'2016-06-30','2016-06-30'),(173,16,10,'123',172,1,'2016-06-30','2016-06-30'),(174,16,10,'123',173,2,'2016-06-30','2016-06-30'),(175,16,10,'123123',173,2,'2016-06-30','2016-06-30'),(182,16,10,'123123',173,2,'2016-06-30','2016-06-30'),(183,16,10,'123123',173,2,'2016-06-30','2016-06-30'),(184,16,10,'123123',173,2,'2016-06-30','2016-06-30'),(185,16,10,'123123',173,2,'2016-06-30','2016-06-30'),(186,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(187,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(188,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(189,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(190,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(191,16,10,'123123\\',173,2,'2016-06-30','2016-06-30'),(234,15,1,'안녕하세요',165,1,'2016-07-01','2016-07-01'),(235,15,1,'네 안녕하세요',165,1,'2016-07-01','2016-07-01'),(236,15,1,'아무 문제 없어요',234,2,'2016-07-01','2016-07-01'),(237,15,1,'아무 문제 없어요',234,2,'2016-07-01','2016-07-01'),(238,15,1,'새로운 노드',234,2,'2016-07-01','2016-07-01'),(239,17,1,'생성됨',0,0,'2016-07-01','2016-07-01'),(240,14,1,'문제 없죠?',235,2,'2016-07-01','2016-07-01'),(241,15,1,'잘 되나요?',235,2,'2016-07-01','2016-07-01'),(242,15,1,'새로운 노드',165,1,'2016-07-01','2016-07-01'),(243,15,1,'이제 좀 되죠?',235,2,'2016-07-01','2016-07-01'),(244,15,1,'아주 다행스럽게도요 ㅋㅋㅋ',242,2,'2016-07-01','2016-07-01'),(245,18,37,'123',0,0,'2016-07-01','2016-07-01');
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_f_rel`
--

DROP TABLE IF EXISTS `m_f_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_f_rel` (
  `m_num` int(11) NOT NULL,
  `f_num` int(11) NOT NULL,
  `owner` int(1) NOT NULL,
  PRIMARY KEY (`m_num`,`f_num`),
  KEY `m_num` (`m_num`),
  KEY `f_num` (`f_num`),
  CONSTRAINT `f_num_foreignkey` FOREIGN KEY (`f_num`) REFERENCES `files` (`f_num`) ON DELETE CASCADE,
  CONSTRAINT `m_num_foreignkey` FOREIGN KEY (`m_num`) REFERENCES `member` (`m_num`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_f_rel`
--

LOCK TABLES `m_f_rel` WRITE;
/*!40000 ALTER TABLE `m_f_rel` DISABLE KEYS */;
INSERT INTO `m_f_rel` VALUES (1,119,1),(1,120,1),(1,121,1),(1,122,1),(1,123,1),(2,111,1),(2,112,1),(2,113,1),(2,114,1),(2,115,1),(2,116,1),(2,117,1),(2,118,1),(8,129,0),(8,130,0),(9,124,1),(9,125,1),(9,126,1),(9,127,1),(9,129,0),(9,130,0),(37,129,1),(37,130,1);
/*!40000 ALTER TABLE `m_f_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `m_num` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` varchar(20) NOT NULL,
  `m_pwd` varchar(20) NOT NULL,
  `m_name` varchar(20) NOT NULL,
  PRIMARY KEY (`m_num`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'nonokia','1234','이준성'),(2,'sjpark','222','박세진'),(3,'mgshin','1234','신명길'),(4,'gykim','1234','김광연'),(7,'이준성','1234','이준성'),(8,'6조 박세진','1234','6조 박세진'),(9,'6조 김광연','1234','6조 김광연'),(10,'6조 신명길','1234','6조 신명길'),(12,'kim','kim','1234'),(20,'1234','1234','1234'),(37,'123','123','123');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panel`
--

DROP TABLE IF EXISTS `panel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `panel` (
  `panelid` int(11) NOT NULL AUTO_INCREMENT,
  `s_num` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `gender` text NOT NULL,
  `agegroup` int(11) NOT NULL DEFAULT '10',
  `area` int(11) NOT NULL DEFAULT '53',
  `pdate` date NOT NULL,
  `ip` tinytext,
  PRIMARY KEY (`panelid`),
  KEY `surveyid` (`s_num`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panel`
--

LOCK TABLES `panel` WRITE;
/*!40000 ALTER TABLE `panel` DISABLE KEYS */;
INSERT INTO `panel` VALUES (54,19,NULL,'man',20,53,'2016-07-01','10.240.0.211'),(55,19,NULL,'man',20,53,'2016-07-01','10.240.0.213'),(56,19,NULL,'man',20,62,'2016-07-01','10.240.0.211'),(57,19,NULL,'woman',10,54,'2016-07-01','10.240.0.212'),(58,19,NULL,'man',20,32,'2016-07-01','10.240.0.136');
/*!40000 ALTER TABLE `panel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `surveyid` int(11) NOT NULL,
  `qnum` int(11) DEFAULT NULL,
  `qindex` int(11) DEFAULT NULL,
  `qcontent` text NOT NULL,
  `logiccheck` tinyint(1) DEFAULT NULL,
  `qgroup` int(11) DEFAULT NULL,
  `requirecheck` tinyint(1) DEFAULT NULL,
  `type` text,
  PRIMARY KEY (`qid`),
  KEY `surveyid` (`surveyid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (7,19,0,0,'ì§€ê¸ˆ ì¸ê¸°ìžˆëŠ” ìƒ‰ì€?',0,NULL,0,'multiple'),(8,19,1,1,'ìžì‹ ì˜ ìƒê°ì„ ì ì–´ì£¼ì„¸ìš”.',NULL,NULL,0,'singleTextbox');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `result` (
  `resultid` int(11) NOT NULL AUTO_INCREMENT,
  `panelid` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `chk_ob` int(11) DEFAULT NULL,
  `chk_sub` text,
  `chk_date` date DEFAULT NULL,
  `qnum` int(11) NOT NULL,
  PRIMARY KEY (`resultid`),
  KEY `s_num` (`surveyid`),
  KEY `panelid` (`panelid`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result`
--

LOCK TABLES `result` WRITE;
/*!40000 ALTER TABLE `result` DISABLE KEYS */;
INSERT INTO `result` VALUES (66,54,19,7,1,NULL,NULL,0),(67,54,19,8,NULL,'24',NULL,0),(68,55,19,7,1,NULL,NULL,0),(69,55,19,8,NULL,'ttt',NULL,0),(70,56,19,7,1,NULL,NULL,0),(71,56,19,8,NULL,'123',NULL,0),(72,57,19,7,0,NULL,NULL,0),(73,57,19,8,NULL,'ggg',NULL,0),(74,58,19,7,0,NULL,NULL,0),(75,58,19,8,NULL,'test',NULL,0);
/*!40000 ALTER TABLE `result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey`
--

DROP TABLE IF EXISTS `survey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey` (
  `s_num` int(11) NOT NULL AUTO_INCREMENT,
  `m_num` int(20) NOT NULL,
  `b_num` int(20) NOT NULL,
  `s_subject` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_explain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_date` date NOT NULL,
  `respondent` int(11) NOT NULL,
  PRIMARY KEY (`s_num`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey`
--

LOCK TABLES `survey` WRITE;
/*!40000 ALTER TABLE `survey` DISABLE KEYS */;
INSERT INTO `survey` VALUES (19,1,1,'1234','ì„¤ë¬¸ì— ëŒ€í•œ ì„¤ëª… ìž…ë ¥.124','0001-03-02',5);
/*!40000 ALTER TABLE `survey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_m_rel`
--

DROP TABLE IF EXISTS `t_m_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_m_rel` (
  `t_num` int(11) NOT NULL,
  `m_num` int(11) NOT NULL,
  `t_auth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_m_rel`
--

LOCK TABLES `t_m_rel` WRITE;
/*!40000 ALTER TABLE `t_m_rel` DISABLE KEYS */;
INSERT INTO `t_m_rel` VALUES (5,10,1),(31,7,1),(34,7,1),(0,10,0),(0,0,0),(34,8,0),(34,9,0);
/*!40000 ALTER TABLE `t_m_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `t_num` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`t_num`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (5,'6조그룹'),(34,'송년회 간부');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workbench`
--

DROP TABLE IF EXISTS `workbench`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workbench` (
  `w_num` int(11) NOT NULL AUTO_INCREMENT,
  `m_num` int(11) NOT NULL,
  `w_name` varchar(50) NOT NULL,
  `w_created_date` date NOT NULL,
  `w_edited_date` date NOT NULL,
  PRIMARY KEY (`w_num`),
  KEY `m_num` (`m_num`),
  KEY `m_num_2` (`m_num`),
  CONSTRAINT `workbench_ibfk_1` FOREIGN KEY (`m_num`) REFERENCES `member` (`m_num`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workbench`
--

LOCK TABLES `workbench` WRITE;
/*!40000 ALTER TABLE `workbench` DISABLE KEYS */;
INSERT INTO `workbench` VALUES (14,1,'송년회','2016-06-20','2016-06-20'),(15,1,'테스트','2016-06-30','2016-06-30'),(16,10,'','2016-06-30','2016-06-30'),(17,1,'생성됨','2016-07-01','2016-07-01'),(18,37,'123','2016-07-01','2016-07-01');
/*!40000 ALTER TABLE `workbench` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-02  1:59:10
