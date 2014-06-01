#
# Table structure for table 'tx_secretsanta_domain_model_pair'
#
CREATE TABLE tx_secretsanta_domain_model_pair (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,

	donor text,
	donee text,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
