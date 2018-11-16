<?php
$installer = $this;
$installer->startSetup();
$installer->run(
    "
DROP TABLE IF EXISTS {$this->getTable('imageclean')};
CREATE TABLE `{$this->getTable( 'imageclean' )}` (
	`imageclean_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
	`imagepath` varchar(1000) NOT NULL,
	`isproduct` tinyint(1) NOT NULL DEFAULT 1, 
	PRIMARY KEY (`imageclean_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
"
);
$installer->endSetup();
