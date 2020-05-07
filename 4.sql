CREATE DATABASE IF NOT EXISTS test1;

CREATE TABLE IF NOT EXISTS test1.teams (
  `team_id` varchar(30) NOT NULL,
  `team_name` varchar(30) NOT NULL,
  `dateofplay` date NOT NULL,
  `numofplayers` int(2) NOT NULL,
  `timetoplay` float NOT NULL,
  `status` varchar(30) NOT NULL,
  `score` int(10) NOT NULL,
  `timeofactivation` time DEFAULT NULL,
  PRIMARY KEY (`team_id`)
);

CREATE TABLE IF NOT EXISTS test1.users (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `team_id` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `nickName` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `age` varchar(10) DEFAULT NULL,
  `picture` text NOT NULL,
  PRIMARY KEY (`id`)
);


INSERT INTO test1.teams (`team_id`, `team_name`, `dateofplay`, `numofplayers`, `timetoplay`, `status`, `score`, `timeofactivation`) SELECT * FROM test.teams WHERE DATEDIFF(CURRENT_DATE, dateofplay) < 80;

INSERT INTO test1.users (`id`, `user_id`, `team_id`, `firstName`, `lastName`, `nickName`, `email`, `age`, `picture`) SELECT * FROM test.users WHERE team_id in (SELECT team_id FROM test1.teams);

DELETE FROM test.teams WHERE DATEDIFF(CURRENT_DATE, dateofplay) < 60;

DELETE FROM test.users WHERE team_id in (SELECT team_id FROM test1.teams);
