SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `recent_search` (
  `search_id` int(11) NOT NULL,
  `search_query` varchar(300) NOT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `recent_search`
  ADD PRIMARY KEY (`search_id`);

ALTER TABLE `recent_search`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;