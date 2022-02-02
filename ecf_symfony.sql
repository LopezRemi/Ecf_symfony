-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 fév. 2022 à 17:13
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf_symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_condition` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id_id` int(11) DEFAULT NULL,
  `date_emprunt` date DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `summary`, `release_date`, `category`, `book_condition`, `editor`, `status`, `user_id_id`, `date_emprunt`, `date_return`, `cover`) VALUES
(1, 'l\'assommoir', 'Émile Zola', 'L\'Assommoir est un roman d\'Émile Zola publié en feuilleton dès 1876 dans Le Bien public, puis dans La République des Lettres, avant sa sortie en livre en 1877 chez l\'éditeur Georges Charpentier. C\'est le septième volume de la série Les Rougon-Macquart. L\'', '1876-01-01', 'Roman naturaliste', 'Bon état', 'G. Charpentier', 1, 4, '2022-02-01', '2022-02-02', 'L-assommoir-61faa9deed97d.jpg'),
(3, 'le tour du monde en 80 jours', 'jules vernes', 'Le roman raconte la course autour du monde d\'un gentleman anglais, Phileas Fogg, qui a fait le pari d\'y parvenir en quatre-vingts jours. Il est accompagné par Jean Passepartout, son fidèle domestique français. L\'ensemble du roman mêle récit de voyage (tra', '1872-01-01', 'Roman d\'aventures', 'Bon état', 'Pierre-Jules Hetzel', 1, 3, NULL, '2022-02-01', 'Tour-du-Monde-61faac6a672b1.jpg'),
(8, 'Lettres de mon moulin', 'Alphonse Daudet', 'Lettres de mon moulin est un recueil de nouvelles d\'Alphonse Daudet. Le titre fait référence au moulin Saint-Pierre, situé à Fontvieille (Bouches-du-Rhône)1.', '1869-01-01', 'Recueil de nouvelles', 'Bon état', 'J. Hetzel', 1, 2, '2022-02-01', '2022-02-01', 'Lettres-de-mon-moulin-61faacd672b4d.jpg'),
(9, 'Apprendre à développer des applications web avec PHP et Symfony', 'Yves Rocamora', 'Ce livre s’adresse à toute personne qui souhaite disposer des connaissances nécessaires pour apprendre à développer des applications web avec PHP et le framework Symfony (en version 5 au moment de l’écriture). Partant des bases jusqu’à mener le lecteur pr', '2020-11-12', 'Ressources Informatiques', 'Bon état', 'Eni Editions', 1, 2, '2022-02-02', '2022-02-02', 'Apprendre-a-developper-des-applications-web-avec-PHP-et-Symfony-61faacefde875.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220131082208', '2022-01-31 09:23:07', 29),
('DoctrineMigrations\\Version20220131093353', '2022-01-31 10:34:03', 72),
('DoctrineMigrations\\Version20220131135408', '2022-01-31 14:54:14', 41),
('DoctrineMigrations\\Version20220131143930', '2022-01-31 15:39:37', 75),
('DoctrineMigrations\\Version20220201100803', '2022-02-01 11:08:15', 439),
('DoctrineMigrations\\Version20220201133320', '2022-02-01 14:33:39', 165),
('DoctrineMigrations\\Version20220202145717', '2022-02-02 16:08:24', 44),
('DoctrineMigrations\\Version20220202150428', '2022-02-02 16:08:24', 19);

-- --------------------------------------------------------

--
-- Structure de la table `historical`
--

CREATE TABLE `historical` (
  `id` int(11) NOT NULL,
  `date_loan` datetime DEFAULT NULL,
  `date_return` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historical`
--

INSERT INTO `historical` (`id`, `date_loan`, `date_return`) VALUES
(1, '2022-02-02 16:08:58', '2022-02-17 16:08:58');

-- --------------------------------------------------------

--
-- Structure de la table `historical_books`
--

CREATE TABLE `historical_books` (
  `historical_id` int(11) NOT NULL,
  `books_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historical_books`
--

INSERT INTO `historical_books` (`historical_id`, `books_id`) VALUES
(1, 9);

-- --------------------------------------------------------

--
-- Structure de la table `historical_user`
--

CREATE TABLE `historical_user` (
  `historical_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historical_user`
--

INSERT INTO `historical_user` (`historical_id`, `user_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `loan`) VALUES
(2, 'Romain', 'Anger', 'anger.romain@gmail.com', 'a:1:{i:0;i:9;}'),
(3, 'Rémi', 'Lopez', 'r.lopez76000@gmail.com', NULL),
(4, 'Harold', 'Pierrache', 'h.pierrache@gmail.com', NULL),
(5, 'David', 'Vieuxbled', 'david.vieuxbled@outlook.fr', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4A1B2A929D86650F` (`user_id_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `historical`
--
ALTER TABLE `historical`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historical_books`
--
ALTER TABLE `historical_books`
  ADD PRIMARY KEY (`historical_id`,`books_id`),
  ADD KEY `IDX_EBC4E014C75EAE06` (`historical_id`),
  ADD KEY `IDX_EBC4E0147DD8AC20` (`books_id`);

--
-- Index pour la table `historical_user`
--
ALTER TABLE `historical_user`
  ADD PRIMARY KEY (`historical_id`,`user_id`),
  ADD KEY `IDX_83CA2EE8C75EAE06` (`historical_id`),
  ADD KEY `IDX_83CA2EE8A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `historical`
--
ALTER TABLE `historical`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_4A1B2A929D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `historical_books`
--
ALTER TABLE `historical_books`
  ADD CONSTRAINT `FK_EBC4E0147DD8AC20` FOREIGN KEY (`books_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EBC4E014C75EAE06` FOREIGN KEY (`historical_id`) REFERENCES `historical` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historical_user`
--
ALTER TABLE `historical_user`
  ADD CONSTRAINT `FK_83CA2EE8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_83CA2EE8C75EAE06` FOREIGN KEY (`historical_id`) REFERENCES `historical` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
