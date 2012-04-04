-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_glossary`
-- 

CREATE TABLE `tl_glossary` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_glossary_term`
-- 

CREATE TABLE `tl_glossary_term` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `author` int(10) unsigned NOT NULL default '0',
  `term` varchar(64) NOT NULL default '',
  `sortTerm` varchar(128) NOT NULL default '',
  `addReference` char(1) NOT NULL default '',
  `referenceTerm` int(10) unsigned NOT NULL default '0'
  `referenceType` varchar(10) NOT NULL default '',
  `definition` text NULL,
  `addExample` char(1) NOT NULL default '',
  `example` text NULL,
  `addImage` char(1) NOT NULL default '',
  `singleSRC` varchar(255) NOT NULL default '',
  `size` varchar(64) NOT NULL default '',
  `alt` varchar(255) NOT NULL default '',
  `imagemargin` varchar(255) NOT NULL default '',
  `imageUrl` varchar(255) NOT NULL default '',
  `fullsize` char(1) NOT NULL default '',
  `caption` varchar(255) NOT NULL default '',
  `floating` varchar(32) NOT NULL default '',
  `addEnclosure` char(1) NOT NULL default '',
  `enclosure` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `glossaries` text NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
