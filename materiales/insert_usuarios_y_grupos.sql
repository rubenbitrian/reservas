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