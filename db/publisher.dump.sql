-- MySQL dump 10.13  Distrib 5.6.12, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: publisher
-- ------------------------------------------------------
-- Server version	5.6.13-log

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
-- Table structure for table `apps`
--

DROP TABLE IF EXISTS `apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `developer` int(11) NOT NULL DEFAULT '1' COMMENT '开发商（作者）',
  `version` varchar(16) NOT NULL COMMENT 'app版本',
  `app_updtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'app更新时间',
  `description` varchar(255) NOT NULL COMMENT '文字简介',
  `screenshots` text NOT NULL COMMENT '软件截屏图',
  `intro` text NOT NULL COMMENT '详细介绍',
  `upd_info` varchar(512) NOT NULL COMMENT '更新信息UpdeteInfo',
  `cover_img` varchar(255) NOT NULL COMMENT '大图',
  `icon_img` varchar(128) NOT NULL COMMENT '图标图片',
  `out_app_id` int(11) NOT NULL DEFAULT '0' COMMENT '官网的app_id',
  `bbs_coverimg` varchar(255) NOT NULL,
  `pkg_size` int(11) NOT NULL COMMENT '包大小字节数',
  `pkg_name` varchar(255) NOT NULL COMMENT '包名，用于客户端检查是否安装等',
  `pkg_url` varchar(255) NOT NULL COMMENT '下载地址',
  `platform` enum('ANDROID','IOS','HTML5') NOT NULL,
  `extra_mark` enum('firstpub','hot','recommend','lottery') NOT NULL,
  `category_id` int(11) NOT NULL COMMENT '关联app_categorys',
  `download_times` int(11) NOT NULL DEFAULT '0' COMMENT '下载次数',
  `fake_downloads` int(11) NOT NULL DEFAULT '0' COMMENT '后台管理的下载次数（加）',
  `focus_times` int(11) NOT NULL DEFAULT '0',
  `grade_number` int(11) NOT NULL COMMENT '评分次数，每次评分后计算更新',
  `avg_grade` decimal(3,2) NOT NULL COMMENT '平均分，每次评分后计算更新',
  `credit_reward` int(11) NOT NULL DEFAULT '0' COMMENT '下载赠积分',
  `display_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `display_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `display_order` int(11) NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `display_order` (`display_order`),
  KEY `app_updtime` (`app_updtime`),
  KEY `pkg_name` (`pkg_name`(32)),
  KEY `avg_grade` (`avg_grade`),
  KEY `bbs_id` (`out_app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=944 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps`
--

LOCK TABLES `apps` WRITE;
/*!40000 ALTER TABLE `apps` DISABLE KEYS */;
INSERT INTO `apps` VALUES (943,'征途口袋版',1,'1.2.0','2014-11-05 16:00:00','《征途》手游是由巨人移动精心研发运营的一款国战手机游戏，游戏继承了大量《征途2》备受玩家好评的经典玩法，并结合了移动设备的特性进行了有针对性的优化和扩展，使得广大征途玩家在手机上也能体验到细腻的电影式画面、震撼人心的千人国战和激情PK。经典国家阵营概念，兄弟家族合力断金，战场厮杀血战，经典装备养成玩法，带你领略一样的征途，不一样的体验！\r\n国战正统手游王者回归，火爆内测即将开启！小伙伴们，准备好了么？一起来战！','<img src=\"http://huodong.gamm.ztgame.com/upload/day_141106/124240b3c993ae.jpg\" alt=\"\" /><img src=\"http://huodong.gamm.ztgame.com/upload/day_141106/12424556ef02cc.jpg\" alt=\"\" /><img src=\"http://huodong.gamm.ztgame.com/upload/day_141106/1242494c7cc6a8.jpg\" alt=\"\" /><img src=\"http://huodong.gamm.ztgame.com/upload/day_141106/124253b60c4b73.jpg\" alt=\"\" /><img src=\"http://huodong.gamm.ztgame.com/upload/day_141106/1242564ceec4dd.jpg\" alt=\"\" />','《征途》手游是由巨人移动精心研发运营的一款国战手机游戏，游戏继承了大量《征途2》备受玩家好评的经典玩法，并结合了移动设备的特性进行了有针对性的优化和扩展，使得广大征途玩家在手机上也能体验到细腻的电影式画面、震撼人心的千人国战和激情PK。经典国家阵营概念，兄弟家族合力断金，战场厮杀血战，经典装备养成玩法，带你领略一样的征途，不一样的体验！\r\n国战正统手游王者回归，火爆内测即将开启！小伙伴们，准备好了么？一起来战！','','http://huodong.gamm.ztgame.com/upload/day_141106/125833fba9a8be.jpg','http://huodong.gamm.ztgame.com/upload/day_141106/1258338804dafd.png',0,'',145000000,'com.ztgame.ztmobiletest.xingyun','http://download.gamm.ztgame.com/zt_xingyun.apk','ANDROID','firstpub',1,0,11352,0,0,0.00,299,'2014-11-05 16:00:00','2014-11-29 16:00:00',0,'2014-11-06 07:29:37');
/*!40000 ALTER TABLE `apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL COMMENT '项目名',
  `manager` varchar(16) NOT NULL COMMENT '项目负责人',
  `local_path` varchar(128) NOT NULL,
  `svn_addr` varchar(512) NOT NULL,
  `ignore_files` varchar(512) NOT NULL COMMENT '同步时屏蔽哪些文件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'星云','胡劼','nebula_root/','svn://192.168.104.21:8080/svn/nebula/trunk/server','nebula.txt');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL COMMENT '关联projects',
  `title` varchar(64) NOT NULL COMMENT '服务器名',
  `ip` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servers`
--

LOCK TABLES `servers` WRITE;
/*!40000 ALTER TABLE `servers` DISABLE KEYS */;
/*!40000 ALTER TABLE `servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_projects`
--

DROP TABLE IF EXISTS `user_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_projects` (
  `uid` int(11) NOT NULL,
  `prj_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`,`prj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_projects`
--

LOCK TABLES `user_projects` WRITE;
/*!40000 ALTER TABLE `user_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_superadmin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员权限',
  `login_ip` varchar(15) NOT NULL,
  `login_times` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2014-11-08  1:04:51
