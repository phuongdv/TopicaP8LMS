CREATE TABLE `vietth_cham_lai_bt30` (
`id` int(10) NOT NULL,
`attemptid` int(10) NULL DEFAULT NULL,
`questionid` int(10) NULL DEFAULT NULL,
`comment` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`new_grade` float(5,2) NULL DEFAULT NULL,
`user_edit` int(11) NULL DEFAULT NULL,
`timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`) 
);


CREATE TABLE `vietth_q169_answer` (
`id` int(10) NOT NULL,
`attempt` int(10) NOT NULL,
`answer` mediumtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`) 
);


CREATE TABLE `vietth_q169_attempts` (
`id` int(10) NOT NULL,
`userid` int(10) NOT NULL,
`ma_de` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
`quiz` int(10) NOT NULL,
`attempt` int(10) NOT NULL,
`starttime` datetime NULL DEFAULT NULL,
`finishtime` datetime NULL DEFAULT NULL,
`sumgrade` float(10,2) NULL DEFAULT '0.00',
`corrects` int(10) NULL DEFAULT '0',
`modtime` timestamp NULL DEFAULT NULL,
`deleted` int(11) NULL DEFAULT '0',
`usermodified` int(10) NULL DEFAULT NULL,
`status` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'inprogress',
`type` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `quiz` (`quiz`),
INDEX `de` (`ma_de`),
INDEX `uid` (`userid`)
);


CREATE TABLE `vietth_q169_de` (
`id` int(11) NOT NULL,
`quizid` int(11) NOT NULL,
`code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`quest_ids` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`course_id` int(11) NOT NULL,
`number_question` int(11) NOT NULL,
`answers` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`times` int(11) NOT NULL DEFAULT '90',
`url_file` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
`num` int(11) NULL DEFAULT '1',
`timeopen` int(10) NOT NULL DEFAULT '0',
`timeclose` int(10) NOT NULL DEFAULT '0',
`type` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `quiz` (`quizid`)
);


