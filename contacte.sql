-- ----------------------------
-- Table structure for `contacte`
-- ----------------------------
DROP TABLE IF EXISTS `contacte`;
CREATE TABLE `contacte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(255) NOT NULL,
  `data_nasterii` date NOT NULL,
  `detalii` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contacte
-- ----------------------------
INSERT INTO `contacte` VALUES ('1', 'george', '1984-12-31', 'Detalii 1');
INSERT INTO `contacte` VALUES ('2', 'adrian', '1984-12-31', 'Detalii 2');
