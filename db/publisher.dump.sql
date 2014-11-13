-- MySQL dump 10.13  Distrib 5.6.16, for Win32 (x86)
--
-- Host: localhost    Database: publisher
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL COMMENT '项目名',
  `manager` varchar(16) NOT NULL COMMENT '项目负责人',
  `vcs_type` enum('svn','git') NOT NULL DEFAULT 'svn' COMMENT '版本管理类型 默认svn 以后会支持git',
  `src_addr` varchar(512) NOT NULL,
  `current_version` varchar(64) NOT NULL DEFAULT '',
  `ignore_files` varchar(512) NOT NULL COMMENT '同步时屏蔽哪些文件',
  `comments` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'星云','胡劼','git','http://192.168.104.21:8080/svn/apps/nebula/trunk/server','','nebula.txt',''),(2,'SVN发布系统','胡劼','git','https://github.com/xsir317/svn_publisher.git','','db','git项目check出来好像未必是要同步的目录啊'),(3,'手机助手','胡劼','git','http://192.168.104.21:8080/svn/apps/gamm/trunk/service','','',''),(4,'星云后台','胡劼','git','http://192.168.104.21:8080/svn/apps/nebula/trunk/server/admin','','.svn','');
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
  `rsync_name` varchar(64) NOT NULL COMMENT 'rsync同步的项目名',
  `current_version` varchar(64) NOT NULL COMMENT '此服务器最后一次同步时的代码版本',
  `last_pub_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次同步时间',
  `comment` varchar(512) NOT NULL,
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
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('checkout','update','delete','rsync') NOT NULL COMMENT '任务类型',
  `command` varchar(1024) NOT NULL,
  `pre_task` int(11) NOT NULL DEFAULT '0' COMMENT '前置任务，必须前置完成才能执行此任务',
  `status` enum('created','execute','success','failed') NOT NULL DEFAULT 'created',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `execute_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `output` text NOT NULL,
  `uid` int(11) NOT NULL COMMENT '提交任务的用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='耗时任务，页面操作时写入此表，由cron负责执行后写回执行结果';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'delete','{\"project_id\":1}',0,'created','2014-11-11 11:09:10','0000-00-00 00:00:00','',0),(2,'checkout','{\"project_id\":1}',1,'created','2014-11-11 11:09:10','0000-00-00 00:00:00','',0),(3,'delete','{\"project_id\":1}',0,'created','2014-11-12 08:36:40','0000-00-00 00:00:00','',1),(4,'checkout','{\"project_id\":1}',3,'created','2014-11-12 08:36:40','0000-00-00 00:00:00','',1),(5,'checkout','{\"project_id\":4}',0,'created','2014-11-12 10:26:57','0000-00-00 00:00:00','',1);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
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
  `password` varchar(64) NOT NULL,
  `remember_token` char(128) NOT NULL,
  `is_superadmin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员权限',
  `login_ip` varchar(15) NOT NULL,
  `login_times` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$Pv3DHJ7khXy3XGm0ECZNv.jGoRkllyXKyLxWBCNsOOvRbkbAdcjIe','mOsWbYJbKQN4aAbJqn6V0BWgkD27Y5TmvK2jMqp8PnCp7ooJDzZmKOBAAZBw',1,'',0);
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

-- Dump completed on 2014-11-13 14:56:10
