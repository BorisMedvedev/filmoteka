#SKD101|filmoteka|1|2018.04.07 04:18:40|4|4

DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `genre` text NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `films` VALUES
(1, 'Облачный атлас', 'драма', 2012),
(2, 'Такси 4', 'боевик', 2000),
(3, 'Аватар вторая часть продолжение', 'фантастика', 2014),
(4, 'Элизиум', 'фантастика', 2017);

