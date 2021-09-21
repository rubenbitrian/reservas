INSERT INTO `user` (`id`, `user_group_id`, `name`, `surnames`, `email`, `roles`, `password`) VALUES
(NULL, 1, 'José Luis', 'Bitrián Esquillor', 'joseluisbitrian@yahoo.es', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 2, 'Rubén', 'Bitrián Crespo', 'rbitrian@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 3, 'David', 'Bitrián Crespo', 'jdbitrian@gmail.com', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(NULL, 4, 'Ester', 'Bitrián Crespo', 'esterbitrian@yahoo.es', '[\"ROLE_EDITOR\"]', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO');


INSERT INTO `user_group` (`id`, `name`, `color`) VALUES
(NULL, 'Propietarios', '#0F0'),
(NULL, 'Bitrián Andaluz', '#FF0'),
(NULL, 'Bitrián Rodríguez', '#0BF'),
(NULL, 'Secretaria central de reservas', '#FA0');

INSERT INTO `state` (`id`, `name`) VALUES
(NULL, 'solicitado'),
(NULL, 'reservado'),
(NULL, 'cancelado');

CREATE TABLE sign_up
(id INT AUTO_INCREMENT NOT NULL, enable TINYINT(1) NOT NULL,
PRIMARY KEY(id))
DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
ENGINE = InnoDB