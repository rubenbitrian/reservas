INSERT INTO `user` (`id`, `user_group_id`, `name`, `surnames`, `email`, `roles`, `password`) VALUES
(NULL, 1, 'José Luis', 'Bitrián Esquillor', 'joseluisbitrian@yahoo.es', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 2, 'Rubén', 'Bitrián Crespo', 'rbitrian@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 3, 'David', 'Bitrián Crespo', 'jdbitrian@gmail.com', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 4, 'Ester', 'Bitrián Crespo', 'esterbitrian@yahoo.es', '[\"ROLE_EDITOR\"]', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO');


INSERT INTO `user_group` (`id`, `name`, `color`) VALUES
(NULL, 'Propietarios', '#00FF00'),
(NULL, 'Bitrián Andaluz', '#FFFF00'),
(NULL, 'Bitrián Rodríguez', '#0FBBFF'),
(NULL, 'Secretaria central de reservas', '#FFAA00');

INSERT INTO `state` (`id`, `name`) VALUES
(1, 'solicitado'),
(2, 'reservado'),
(3, 'cancelado');

CREATE TABLE sign_up
(id INT AUTO_INCREMENT NOT NULL, enable TINYINT(1) NOT NULL,
PRIMARY KEY(id))
DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
ENGINE = InnoDB

INSERT INTO `sign_up` (`id`, `enable`) VALUES (NULL, '1');