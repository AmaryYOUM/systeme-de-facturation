-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 nov. 2025 à 17:54
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
-- Base de données : `ufr2s_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id_etudiant` int(11) NOT NULL,
  `prenom_etudiant` varchar(255) NOT NULL,
  `nom_etudiant` varchar(255) NOT NULL,
  `option_etudiant` varchar(255) NOT NULL,
  `groupe` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` int(11) NOT NULL,
  `num` varchar(255) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `prestation_id` int(11) DEFAULT NULL,
  `prescripteur_id` int(11) NOT NULL,
  `reduction` float NOT NULL,
  `montant_global` int(11) NOT NULL,
  `pec` int(11) NOT NULL,
  `modifier` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `projet` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facturessupprimees`
--

CREATE TABLE `facturessupprimees` (
  `id` int(11) NOT NULL,
  `numero_facture` varchar(255) NOT NULL,
  `date_suppression` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `raison` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `cle` varchar(100) NOT NULL,
  `valeur` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `matricule` varchar(255) DEFAULT NULL,
  `prenom_patient` varchar(255) DEFAULT NULL,
  `nom_patient` varchar(255) DEFAULT NULL,
  `telephone_patient` varchar(255) DEFAULT NULL,
  `contact_patient` int(11) NOT NULL,
  `type_client` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prescripteurs`
--

CREATE TABLE `prescripteurs` (
  `id` int(11) NOT NULL,
  `prenom_prescripteur` varchar(255) NOT NULL,
  `nom_prescripteur` varchar(255) NOT NULL,
  `tel_prescripteur` varchar(255) NOT NULL,
  `mail_prescripteur` varchar(255) NOT NULL,
  `specialite_prescripteur` varchar(255) NOT NULL,
  `structure_prescripteur` varchar(255) NOT NULL,
  `service_prescripteur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prestations`
--

CREATE TABLE `prestations` (
  `id` int(11) NOT NULL,
  `intitule_prestat` varchar(255) DEFAULT NULL,
  `montant_prestat` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `intitule_serv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profil` varchar(255) DEFAULT NULL,
  `online` int(1) NOT NULL,
  `prenom_user` varchar(255) DEFAULT NULL,
  `nom_user` varchar(255) DEFAULT NULL,
  `tel_user` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `maj_mdp` int(11) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `last_logout` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id_etudiant`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_factures_users_idx` (`user_id`),
  ADD KEY `fk_factures_patients1_idx` (`patient_id`),
  ADD KEY `fk_factures_prestations1_idx` (`prestation_id`),
  ADD KEY `prescripteur_id` (`prescripteur_id`);

--
-- Index pour la table `facturessupprimees`
--
ALTER TABLE `facturessupprimees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numero_facture` (`numero_facture`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`cle`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricule` (`matricule`);

--
-- Index pour la table `prescripteurs`
--
ALTER TABLE `prescripteurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_prescripteur_id` (`service_prescripteur_id`);

--
-- Index pour la table `prestations`
--
ALTER TABLE `prestations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`),
  ADD KEY `tel` (`tel_user`),
  ADD KEY `email` (`email`),
  ADD KEY `service_id` (`service_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facturessupprimees`
--
ALTER TABLE `facturessupprimees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prescripteurs`
--
ALTER TABLE `prescripteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prestations`
--
ALTER TABLE `prestations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
