#
# Table structure for table 'tx_vantomas_domain_model_secretsanta_pair'
#
CREATE TABLE tx_vantomas_domain_model_secretsanta_pair (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,

	donor int(11) DEFAULT '0' NOT NULL,
	donee int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	header_position varchar(6) DEFAULT '' NOT NULL,
	image_compression tinyint(3) unsigned DEFAULT '0' NOT NULL,
	image_effects tinyint(3) unsigned DEFAULT '0' NOT NULL,
	image_frames int(11) unsigned DEFAULT '0' NOT NULL,
	image_noRows tinyint(3) unsigned DEFAULT '0' NOT NULL,
	section_frame int(11) unsigned DEFAULT '0' NOT NULL,
	spaceAfter smallint(5) unsigned DEFAULT '0' NOT NULL,
	spaceBefore smallint(5) unsigned DEFAULT '0' NOT NULL,
	table_bgColor int(11) unsigned DEFAULT '0' NOT NULL,
	table_border tinyint(3) unsigned DEFAULT '0' NOT NULL,
	table_cellpadding tinyint(3) unsigned DEFAULT '0' NOT NULL,
	table_cellspacing tinyint(3) unsigned DEFAULT '0' NOT NULL
);