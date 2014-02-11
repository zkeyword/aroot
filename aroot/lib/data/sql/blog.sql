DROP DATABASE IF EXISTS  `aroot`;
CREATE DATABASE `aroot`;

#DROP TABLE IF EXISTS `aroot`.`z_link`;


/*
 *********************
 * 新建表
 *********************
 */

/*系统设置表*/
CREATE TABLE  `aroot`.`z_options` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`options_key` varchar(20),
	`options_value` varchar(255),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*user表*/
CREATE TABLE  `aroot`.`z_user` (
	`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`password` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	`displayName` varchar(100) NOT NULL,
	`type` tinyint(1) NOT NULL DEFAULT '2',             /*1超级管理员，2管理员*/
	`status` tinyint(1) NOT NULL DEFAULT '1',
	`registeredTime` int(10) NOT NULL,
	`lastLoginTime` int(10) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE key `email` (`email`),
	UNIQUE key `displayName` (`displayName`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*post表*/
CREATE TABLE  `aroot`.`z_post` (
	`post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`slug` varchar(255),
	`author` tinyint(2) unsigned NOT NULL DEFAULT '1',
	`description` varchar(255),
	`content` longtext,
	`type` tinyint(2) unsigned NOT NULL DEFAULT '1',       /*1文章，2单页，3图片*/
	`updataTime` int(10) NOT NULL,
	PRIMARY KEY (`post_id`),
	UNIQUE key `title` (`title`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*项目表*/
CREATE TABLE  `aroot`.`z_term` (
	`term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(20),
	`slug` varchar(20),
	`description` varchar(255),
	`type` tinyint(2) unsigned NOT NULL DEFAULT '1',       /*1category，2tag*/
	`parent_id` int(10) NOT NULL DEFAULT '0',
	`count`int(10) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`term_id`),
	INDEX `index` (`name`, `slug`, `type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*relationships表*/
CREATE TABLE  `aroot`.`z_relationships` (
	`term_id` int(10) unsigned,
	`post_id` int(10) unsigned,
	INDEX `index` (`term_id`, `post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*comments表*/
CREATE TABLE  `aroot`.`z_comments` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`post_id` int(10) unsigned,
	`author` varchar(255),
	`email` varchar(100),
	`url` varchar(200),
	`text` text,
	`status` tinyint(2) unsigned NOT NULL DEFAULT '1',
	`parent` int(10),
	`uid` smallint(5) unsigned DEFAULT '0',  /*为0时表示不存在*/
	`updataTime` int(10) NOT NULL,
	`ip` varchar(12),
	PRIMARY KEY (`id`),
	INDEX `postID` (`post_id`),
	INDEX `time` (`updataTime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*link表*/
CREATE TABLE  `aroot`.`z_postMeta` (
	`meta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`post_id` int(10) unsigned DEFAULT '0',
	`meta_key` varchar(255) NOT NULL,
	`meta_value` varchar(255),
	PRIMARY KEY (`meta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*link表*/
CREATE TABLE  `aroot`.`z_link` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`url`varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`image` varchar(255),
	`target` varchar(255),
	`description` varchar(255),
	`notes` varchar(255),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


/* RABC 表 */

/*权限表*/
CREATE TABLE IF NOT EXISTS `z_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*节点表*/
CREATE TABLE IF NOT EXISTS `z_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*角色表*/
CREATE TABLE IF NOT EXISTS `z_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

/*角色、用户中间表*/
CREATE TABLE IF NOT EXISTS `z_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
 *********************
 * 添加默认值
 *********************
 */
/*系统设置*/
INSERT INTO `aroot`.`z_options` 
(`options_key`, `options_value`)
VALUES 
('siteurl', 'http://127.0.0.1/aroot/'),
('title', 'aroot'),
('description', '这个是一个由aroot构建的站点'),
('keywords', 'aroot, blog, cms'),
('date_format', 'Y年n月j日');

/*管理员*/
INSERT INTO `aroot`.`z_user` 
(`name`,`password`,`email`,`displayName`,`type`,`registeredTime`)
VALUES 
('admin','2555d1bb3ec26cb3caddee1669be1980','admin@admin.com','admin','1','1382663622');

/*默认文章*/
INSERT INTO `aroot`.`z_post` 
(`title`, `slug`, `author`, `description`, `content`, `type`) 
VALUES 
('欢迎使用 aroot', 'hello-aroot', '1', '如果您看到这篇文章,表示您的 aroot 已经安装成功.', '如果您看到这篇文章,表示您的 aroot 已经安装成功.', '1');

/*分类、标签*/
INSERT INTO `aroot`.`z_term` 
(`name`, `slug`, `description`, `type`, `parent_id`, `count`) 
VALUES 
('未分类', 'default', '这个是一个分类', '1', '0', '1'),
('标签', 'tag', '这个是一个标签', '2', '0', '1');

/*关联*/
INSERT INTO `aroot`.`z_relationships` 
(`term_id`, `post_id`) 
VALUES 
('1','1'),
('2','1');

/*评论*/
INSERT INTO `aroot`.`z_comments` 
(`post_id`, `author`, `email`, `url`, `ip`, `text`, `status`, `parent`) 
VALUES 
('1', 'norion', 'zjx1247225@163.com', 'http://zkeyword.com', '127.0.0.1', '这是一条评论', '1', '0');






/*
 * 创建视图，两个表的字段要全部关联
DROP VIEW  IF EXISTS `aroot`.`z_postInfo`;
CREATE VIEW z_postInfo
AS
SELECT * FROM `z_post`,`z_user`
*/

/*
	别名
	SELECT p.post_id,u.id FROM `z_post` AS p JOIN `z_user` AS u
	
	SELECT p.post_id id, p.post_title title, p.post_tag tag, p.post_updataTime time, u.name author, c.cat_name cat FROM z_post p, z_user u, z_cat c WHERE p.post_author = u.id AND p.post_type = c.cat_id LIMIT 0,10

*/

/*
	多表更新
	
	UPDATE z_post p,z_cat c SET p.post_type = c.cat_id 
	
	多行插入
	insert into z_tag(tag_name, tag_slug) values(1212,1133),(2133,1323),(1233,11133)
	
	
*/


/**
DELIMITER $$;
DROP PROCEDURE IF EXISTS `sp_test`$$
CREATE PROCEDURE `sp_test` ()
	BEGIN
	 select * from z_post; 
	END$$
DELIMITER ;$$

php调用:
	$sql = 'call sp_test()';
	$db->query($sql);
*/

/*
多表子查询
select * from (
SELECT title,GROUP_CONCAT( convert(a.type, CHAR) ), GROUP_CONCAT(a.slug) FROM (
	SELECT 
	p.post_id id,
	p.title,
	t.name,
	t.slug,
	t.type
	FROM
	z_post p,
	z_relationships r,
	z_term t
	WHERE
	p.post_id = r.post_id 
	AND 
	t.term_id = r.term_id
) a GROUP BY a.title
) b where b.term_id LIKE '%3%'
*/