--
-- 后台登录admin表
--
DROP TABLE IF EXISTS `dh2y_admin`;
CREATE TABLE `dh2y_admin`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `username` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员',
    `adminpass` CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
    `email` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
    `logintime` INT UNSIGNED  NOT NULL DEFAULT '0' COMMENT '登录时间',
    `loginip` BIGINT NOT NULL DEFAULT '0' COMMENT '登录ip',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY(`id`),
    UNIQUE dh2y_admin_username_password(`username`,`adminpass`),
    UNIQUE dh2y_admin_username_email(`username`,`email`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `dh2y_admin`(username, adminpass, email, createtime) VALUES ('admin',md5('123456'),'admin@qq.com',UNIX_TIMESTAMP());

--
-- 前台用户表
--
DROP TABLE IF EXISTS `dh2y_user`;
CREATE TABLE `dh2y_user`(
    `uid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `username` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '用户账号',
    `userpass` CHAR(32) NOT NULL DEFAULT '' COMMENT  '用户密码',
    `useremail` VARCHAR(100) NOT NULL DEFAULT '',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY(`uid`),
    UNIQUE dh2y_user_username_userpass(`username`,`userpass`),
    UNIQUE dh2y_user_username_useremail(`username`,`useremail`)
)ENGINE =InnoDB DEFAULT CHARSET =utf8;

--
-- 用户信息表
--
DROP TABLE IF EXISTS `dh2y_profile`;
CREATE TABLE `dh2y_profile`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `realname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '真实名字',
    `age` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '年龄',
    `sex` ENUM('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别',
    `birthday` DATE NOT NULL DEFAULT '2016-01-01' COMMENT '生日',
    `nickname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '昵称',
    `company` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '公司',
    `uid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY (`id`),
    UNIQUE dh2y_profile_uid(`uid`)
)ENGINE =InnoDB DEFAULT CHARSET =utf8;