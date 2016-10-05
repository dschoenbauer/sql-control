<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

class ConvertIntTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ConvertInt
     */
    protected $object;
    protected function setUp() {
        $this->object = new ConvertInt;
    }

    public function testFilter() {
        $original = "CREATE TABLE `Container` (
  `container_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `container_name` varchar(100) NOT NULL,
  `container_description` varchar(500) DEFAULT NULL,
  `container_start` datetime DEFAULT NULL,
  `container_end` datetime DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL,
  `containerType_id` int(10) unsigned NOT NULL,
  `parent_container_id` int(10) DEFAULT NULL,
  `master_container_id` int(10) DEFAULT NULL,
  `container_tags` varchar(200) DEFAULT NULL,
  `container_short_code` varchar(50) DEFAULT NULL,
  `containerCategory_id` int(10) unsigned DEFAULT NULL,
  `venue_id` int(10) DEFAULT NULL,
  `container_shortName` varchar(10) DEFAULT NULL,
  `container_image` varchar(255) DEFAULT NULL,
  `container_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`container_id`),
  KEY `fk_TblContainer_TblLocation1_idx` (`location_id`),
  KEY `fk_Container_ContainerType1_idx` (`containerType_id`),
  CONSTRAINT `fk_Container_ContainerType1` FOREIGN KEY (`containerType_id`) REFERENCES `ContainerType` (`containerType_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8";
        $filtered = "CREATE TABLE `Container` (
  `container_id` int unsigned NOT NULL AUTO_INCREMENT,
  `container_name` varchar(100) NOT NULL,
  `container_description` varchar(500) DEFAULT NULL,
  `container_start` datetime DEFAULT NULL,
  `container_end` datetime DEFAULT NULL,
  `location_id` int unsigned DEFAULT NULL,
  `containerType_id` int unsigned NOT NULL,
  `parent_container_id` int DEFAULT NULL,
  `master_container_id` int DEFAULT NULL,
  `container_tags` varchar(200) DEFAULT NULL,
  `container_short_code` varchar(50) DEFAULT NULL,
  `containerCategory_id` int unsigned DEFAULT NULL,
  `venue_id` int DEFAULT NULL,
  `container_shortName` varchar(10) DEFAULT NULL,
  `container_image` varchar(255) DEFAULT NULL,
  `container_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`container_id`),
  KEY `fk_TblContainer_TblLocation1_idx` (`location_id`),
  KEY `fk_Container_ContainerType1_idx` (`containerType_id`),
  CONSTRAINT `fk_Container_ContainerType1` FOREIGN KEY (`containerType_id`) REFERENCES `ContainerType` (`containerType_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8";
        $this->assertEquals($filtered, $this->object->filter($original));
    }

}
