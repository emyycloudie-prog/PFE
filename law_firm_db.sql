-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 juin 2026 à 18:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `law_firm_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

CREATE TABLE `appointments` (
  `id_appointment` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `court_name` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `outcome` text DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cases`
--

CREATE TABLE `cases` (
  `id_case` int(11) NOT NULL,
  `case_title` varchar(100) DEFAULT NULL,
  `case_type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `court` varchar(100) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cases`
--

INSERT INTO `cases` (`id_case`, `case_title`, `case_type`, `status`, `court`, `id_client`) VALUES
(1, 'Divorce Agreement', 'Family Law', 'Open', 'Casablanca Court', 1),
(2, 'Property Dispute', 'Civil Law', 'In Progress', 'Rabat Court', 2),
(3, 'Company Contract Issue', 'Commercial Law', 'Closed', 'Tangier Commercial Court', 3),
(4, 'Workplace Accident', 'Labor Law', 'Open', 'Marrakech Court', 4),
(5, 'Fraud Investigation', 'Criminal Law', 'Pending', 'Fes Criminal Court', 5);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_card` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `fullname`, `phone`, `email`, `id_card`, `type`) VALUES
(1, 'Sarah Radi', '+212600000001', 'sarah.radi@gmail.com', 'AB123456', 'Individual'),
(2, 'Ahmed Benali', '+212600000002', 'ahmed.benali@gmail.com', 'CD789456', 'Business'),
(3, 'Yasmine Alaoui', '+212600000003', 'yasmine.alaoui@gmail.com', 'EF456123', 'Individual'),
(4, 'Omar Tazi', '+212600000004', 'omar.tazi@gmail.com', 'GH852741', 'Business'),
(5, 'Salma Idrissi', '+212600000005', 'salma.idrissi@gmail.com', 'IJ963258', 'Individual'),
(6, 'farah', '0711732058', 'farah@gmail.com', 'KB*****', 'طلب');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id_document` int(11) NOT NULL,
  `doc_title` varchar(100) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `id_case` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `created_at`) VALUES
(1, 'admin@lawfirm.com', '$2y$10$vjJuMs81ZTJ6GAMUeSLkMuctEUZG7A0qnd1ztWPBQYkKURdh46Y3a', 'System Administrator', '2026-06-01 15:49:03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id_appointment`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id_case`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_document`),
  ADD KEY `id_case` (`id_case`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id_appointment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cases`
--
ALTER TABLE `cases`
  MODIFY `id_case` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);

--
-- Contraintes pour la table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`id_case`) REFERENCES `cases` (`id_case`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
