CREATE TABLE IF NOT EXISTS `#__angkor_emails` 
(  
	`id` int(11) NOT NULL auto_increment,  
	`code` varchar(50) default NULL,  
	`subject` varchar(255) default NULL,  
	`body` text,
	`sender_name` varchar(64) not null default '{sendername}',
	`sender_email` varchar(64) not null default '{senderemail}',
	`lang` CHAR(2) default NULL,
	`embed_image` TINYINT NULL,
	PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angkor_email_fields` 
(  
	`id` int(11) NOT NULL auto_increment,  
	`code` varchar(255) default NULL, 	
	`field_name` varchar(255) default NULL,  
	PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__angkor_css` 
(  
	`id` int(11) NOT NULL auto_increment,  
	`css` TEXT DEFAULT NULL,
	PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

TRUNCATE TABLE `#__angkor_email_fields`;

INSERT INTO `#__angkor_email_fields`(code,field_name)
	VALUES 	('SEND_MSG_ADMIN_ACTIVATE_1','{name}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{username}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{password}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{sitename}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{siteurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{activationurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{loginurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{email}'),
			('SEND_MSG_ADMIN_ACTIVATE_1','{user_id}'),
			
			('SEND_MSG_ADMIN_ACTIVATE_2','{name}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{username}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{sitename}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{siteurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{activationurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{email}'),
			('SEND_MSG_ADMIN_ACTIVATE_2','{user_id}'),
			
			('SEND_MSG_ADMIN_ACTIVATE_3','{name}'),
			('SEND_MSG_ADMIN_ACTIVATE_3','{username}'),
			('SEND_MSG_ADMIN_ACTIVATE_3','{sitename}'),
			('SEND_MSG_ADMIN_ACTIVATE_3','{siteurl}'),
			('SEND_MSG_ADMIN_ACTIVATE_3','{email}'),
			('SEND_MSG_ADMIN_ACTIVATE_3','{user_id}'),
			
			('SEND_MSG_ACTIVATE','{name}'),
			('SEND_MSG_ACTIVATE','{username}'),
			('SEND_MSG_ACTIVATE','{password}'),
			('SEND_MSG_ACTIVATE','{sitename}'),
			('SEND_MSG_ACTIVATE','{siteurl}'),
			('SEND_MSG_ACTIVATE','{activationurl}'),
			('SEND_MSG_ACTIVATE','{loginurl}'),
			('SEND_MSG_ACTIVATE','{email}'),
			('SEND_MSG_ACTIVATE','{user_id}'),
			
			('SEND_MSG','{name}'),
			('SEND_MSG','{username}'),
			('SEND_MSG','{password}'),
			('SEND_MSG','{sitename}'),
			('SEND_MSG','{siteurl}'),
			('SEND_MSG','{loginurl}'),
			('SEND_MSG','{email}'),
			('SEND_MSG','{user_id}'),
			
			('SEND_MSG_ADMIN','{adminname}'),
			('SEND_MSG_ADMIN','{name}'),
			('SEND_MSG_ADMIN','{username}'),
			('SEND_MSG_ADMIN','{password}'),
			('SEND_MSG_ADMIN','{sitename}'),
			('SEND_MSG_ADMIN','{siteurl}'),
			('SEND_MSG_ADMIN','{loginurl}'),
			('SEND_MSG_ADMIN','{email}'),
			('SEND_MSG_ADMIN','{user_id}'),
			
			('USERNAME_REMINDER','{username}'),
			('USERNAME_REMINDER','{sitename}'),
			('USERNAME_REMINDER','{siteurl}'),
			('PASSWORD_RESET_CONFIRMATION','{name}'),
			('PASSWORD_RESET_CONFIRMATION','{username}'),
			('PASSWORD_RESET_CONFIRMATION','{token}'),
			('PASSWORD_RESET_CONFIRMATION','{sitename}'),
			('PASSWORD_RESET_CONFIRMATION','{siteurl}'),
			('SEND_MSG_AUTHORIZE', '{username}'),
			('SEND_MSG_AUTHORIZE', '{password}'),
			
			('SEND_MSG_TO_CONTACT', '{s_name}'),
			('SEND_MSG_TO_CONTACT', '{s_email}'),
			('SEND_MSG_TO_CONTACT', '{r_name}'),
			('SEND_MSG_TO_CONTACT', '{r_email}'),
			('SEND_MSG_TO_CONTACT', '{siteurl}'),
			('SEND_MSG_TO_CONTACT', '{sitename}'),
			('SEND_MSG_TO_CONTACT', '{message}'),
			('SEND_MSG_TO_CONTACT', '{subject}'),
			('SEND_MSG_TO_CONTACT','{user_id}'),
			('SEND_MSG_TO_CONTACT','{contact_id}'),
			
			('SEND_COPY_MSG_TO_USER', '{s_name}'),
			('SEND_COPY_MSG_TO_USER', '{s_email}'),
			('SEND_COPY_MSG_TO_USER', '{r_name}'),
			('SEND_COPY_MSG_TO_USER', '{r_email}'),
			('SEND_COPY_MSG_TO_USER', '{subject}'),
			('SEND_COPY_MSG_TO_USER', '{message}'),
			('SEND_COPY_MSG_TO_USER', '{siteurl}'),
			('SEND_COPY_MSG_TO_USER', '{sitename}'),
			('SEND_COPY_MSG_TO_USER','{user_id}'),
			('SEND_COPY_MSG_TO_USER','{contact_id}'),
			
			('SEND_COPY_MSG_TO_ADMIN', '{s_name}'),						
			('SEND_COPY_MSG_TO_ADMIN', '{s_email}'),
			('SEND_COPY_MSG_TO_ADMIN', '{r_name}'),
			('SEND_COPY_MSG_TO_ADMIN', '{r_email}'),
			('SEND_COPY_MSG_TO_ADMIN', '{message}'),
			('SEND_COPY_MSG_TO_ADMIN', '{adminname}'),
			('SEND_COPY_MSG_TO_ADMIN', '{subject}'),
			('SEND_COPY_MSG_TO_ADMIN', '{siteurl}'),
			('SEND_COPY_MSG_TO_ADMIN','{user_id}'),
			('SEND_COPY_MSG_TO_ADMIN','{contact_id}'),
			
			('ADD_NEW_USER','{name}'),
			('ADD_NEW_USER','{username}'),
			('ADD_NEW_USER','{password}'),
			('ADD_NEW_USER','{sitename}'),
			('ADD_NEW_USER','{siteurl}'),
			('ADD_NEW_USER','{user_id}'),
			
			('SENDARTICLE','{sitename}'),
			('SENDARTICLE','{email_to}'),
			('SENDARTICLE','{sender}'),
			('SENDARTICLE','{sender_email}'),
			('SENDARTICLE','{subject}'),
			('SENDARTICLE','{interesting_link}'),
			
			('MASS_MAIL','{sitename}'),
			('MASS_MAIL','{siteurl}'),
			('MASS_MAIL','{loginurl}'),
			('MASS_MAIL','{subject}'),
			('MASS_MAIL','{body}');