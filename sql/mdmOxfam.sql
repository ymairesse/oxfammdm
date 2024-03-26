-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 26 mars 2024 à 19:19
-- Version du serveur : 8.0.36-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mdmOxfamPlus`
--

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_authToken`
--

CREATE TABLE `oxmdm1_authToken` (
  `acronyme` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Acronyme de l''utilisateur',
  `token` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token d''authentification',
  `startTime` datetime NOT NULL COMMENT 'Date et heure de début de session'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des utilisateurs authentifiés en session';

--
-- Déchargement des données de la table `oxmdm1_authToken`
--

INSERT INTO `oxmdm1_authToken` (`acronyme`, `token`, `startTime`) VALUES
('maiyve', 'b551f05126d6f1206b34cc5b', '2024-02-20 17:34:00');

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_calendar`
--

CREATE TABLE `oxmdm1_calendar` (
  `idContexte` int NOT NULL COMMENT 'Identifiant du contexte',
  `date` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` smallint NOT NULL COMMENT 'Numéro de la période',
  `pseudo` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Utilisateur inscrit pour la période',
  `dateInscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date / heure / min /seconde d''inscription',
  `confirme` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permanence confirmée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `oxmdm1_calendar`
--

INSERT INTO `oxmdm1_calendar` (`idContexte`, `date`, `periode`, `pseudo`, `dateInscription`, `confirme`) VALUES
(1, '2024-01-02', 2, 'maiyve', '2024-03-25 11:32:07', 0),
(1, '2024-01-02', 3, 'maiyve', '2024-03-25 11:32:07', 0),
(1, '2024-02-01', 1, 'maiyve', '2024-03-25 11:14:50', 0),
(1, '2024-02-01', 2, 'maiyve', '2024-03-25 11:14:50', 0),
(1, '2024-02-01', 3, 'maiyve', '2024-03-25 07:25:23', 0),
(1, '2024-02-01', 4, 'maiyve', '2024-03-25 07:26:33', 0),
(1, '2024-02-07', 1, 'maiyve', '2024-03-25 07:43:29', 0),
(1, '2024-02-07', 2, 'maiyve', '2024-03-25 07:43:29', 0),
(1, '2024-03-01', 1, 'cesjul', '2024-03-18 15:57:48', 0),
(1, '2024-03-01', 1, 'maiyve', '2024-03-18 15:57:48', 0),
(1, '2024-03-01', 3, 'curmar', '2024-03-26 12:33:24', 0),
(1, '2024-03-01', 3, 'maiyve', '2024-03-26 07:01:47', 0),
(1, '2024-03-01', 4, 'cesjul', '2024-03-26 17:13:45', 0),
(1, '2024-03-02', 1, 'fraros', '2024-03-26 17:13:03', 0),
(1, '2024-03-02', 3, 'newisa', '2024-03-18 15:57:48', 0),
(1, '2024-03-02', 4, 'curmar', '2024-03-18 15:57:48', 0),
(1, '2024-03-02', 4, 'maiyve', '2024-03-26 12:28:18', 0),
(1, '2024-03-02', 6, 'cesjul', '2024-03-26 17:13:57', 0),
(1, '2024-03-03', 2, 'cesjul', '2024-03-26 17:13:57', 0),
(1, '2024-03-07', 1, 'curmar', '2024-03-18 15:57:48', 0),
(2, '2024-03-07', 1, 'maiyve', '2024-03-26 12:28:18', 0);

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_config`
--

CREATE TABLE `oxmdm1_config` (
  `ordre` tinyint DEFAULT NULL,
  `parametre` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `label` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Label',
  `size` smallint DEFAULT NULL,
  `valeur` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `signification` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `domaine` enum('admin','bulletin','bullTQ') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `oxmdm1_config`
--

INSERT INTO `oxmdm1_config` (`ordre`, `parametre`, `label`, `size`, `valeur`, `signification`, `domaine`) VALUES
(2, 'NOMNOREPLY', 'Nom adresse No Reply', 30, 'Merci de ne pas \"répondre\"', 'Nom de l\'adresse pour la diffusion de mails \"no reply\"', NULL),
(1, 'NOREPLY', 'Ne pas répondre', 40, 'ne_pas_repondre@noMail.com', 'Adresse pour la diffusion de mails \"no reply\"', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_congesFeries`
--

CREATE TABLE `oxmdm1_congesFeries` (
  `idContexte` int NOT NULL COMMENT 'Contexte du congé',
  `dateConge` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'date du congé',
  `periode` int NOT NULL COMMENT 'Période de fermeture (voir le nombre de période de permanence par jour)',
  `conge` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ce jour est-il en congé?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Congés';

--
-- Déchargement des données de la table `oxmdm1_congesFeries`
--

INSERT INTO `oxmdm1_congesFeries` (`idContexte`, `dateConge`, `periode`, `conge`) VALUES
(2, '2024-04-02', 3, 1),
(2, '2024-04-02', 4, 1),
(2, '2024-07-25', 1, 1),
(2, '2024-07-25', 2, 1),
(2, '2024-07-25', 3, 1),
(2, '2024-07-25', 4, 1),
(8, '2025-08-20', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_congesHebdo`
--

CREATE TABLE `oxmdm1_congesHebdo` (
  `idContexte` int NOT NULL COMMENT 'Contexte pour le jour de fermeture',
  `jour` tinyint NOT NULL COMMENT 'jour de la semaine (lundi => 1, mardi => 2,...)\r\n',
  `periode` int NOT NULL COMMENT 'Période de fermeture (voir le nombre de période de permanence par jour)',
  `conge` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ce jour est-il en congé?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Congés';

--
-- Déchargement des données de la table `oxmdm1_congesHebdo`
--

INSERT INTO `oxmdm1_congesHebdo` (`idContexte`, `jour`, `periode`, `conge`) VALUES
(1, 1, 1, 1),
(1, 1, 2, 1),
(1, 1, 3, 1),
(1, 1, 4, 1),
(1, 1, 5, 1),
(1, 1, 6, 1),
(1, 7, 3, 1),
(1, 7, 4, 1),
(1, 7, 5, 1),
(1, 7, 6, 1),
(2, 1, 1, 1),
(2, 1, 2, 1),
(2, 1, 3, 1),
(2, 1, 4, 1),
(2, 2, 1, 0),
(2, 2, 2, 0),
(2, 2, 3, 0),
(2, 2, 4, 1),
(2, 7, 1, 1),
(2, 7, 2, 1),
(2, 7, 3, 1),
(2, 7, 4, 1),
(8, 1, 1, 1),
(8, 1, 2, 1),
(8, 1, 3, 1),
(8, 3, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_contextes`
--

CREATE TABLE `oxmdm1_contextes` (
  `idContexte` int NOT NULL COMMENT 'numéro identifiant du contexte',
  `dateDebutContexte` date NOT NULL COMMENT 'Date de début de l''époque'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oxmdm1_contextes`
--

INSERT INTO `oxmdm1_contextes` (`idContexte`, `dateDebutContexte`) VALUES
(1, '2024-01-01'),
(2, '2024-03-05'),
(8, '2024-08-25');

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_freeze`
--

CREATE TABLE `oxmdm1_freeze` (
  `date` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Calendrier freezé',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0 = ouvert, 1 = no desinscription, 2 = total'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Périodes freezées';

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_heuresPermanences`
--

CREATE TABLE `oxmdm1_heuresPermanences` (
  `idContexte` int NOT NULL COMMENT 'Numéro de du contexte (voir la table des "contextes")',
  `numeroPermanence` tinyint NOT NULL COMMENT 'Numéro de la permanence',
  `heureDebut` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Heure de début de permanence',
  `heureFin` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Fin de la permanence'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Liste des permanences pour chaque ère';

--
-- Déchargement des données de la table `oxmdm1_heuresPermanences`
--

INSERT INTO `oxmdm1_heuresPermanences` (`idContexte`, `numeroPermanence`, `heureDebut`, `heureFin`) VALUES
(1, 1, '10:00', '13:00'),
(1, 2, '13:00', '15:30'),
(1, 3, '15:30', '16:30'),
(1, 4, '16:30', '18:00'),
(1, 5, '20:00', '22:00'),
(1, 6, '22:00', '23:00'),
(2, 1, '10:00', '14:00'),
(2, 2, '14:00', '16:00'),
(2, 3, '16:00', '18:00'),
(2, 4, '18:00', '20:00'),
(8, 1, '09:00', '12:00'),
(8, 2, '12:00', '15:00'),
(8, 3, '15:00', '18:00');

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_lostPasswd`
--

CREATE TABLE `oxmdm1_lostPasswd` (
  `pseudo` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom d''utilisateur',
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'jeton unique pour récupération de mdp',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de validité du jeton'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oxmdm1_users`
--

CREATE TABLE `oxmdm1_users` (
  `pseudo` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Abréviation en 7 lettres',
  `civilite` enum('F','M','X','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Civilité',
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'nom de l''utilisateur',
  `prenom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'prénom de l''utilisateur',
  `droits` enum('admin','oxfam','nobody') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'oxfam' COMMENT '''admin'',''oxfam'',''nobody''',
  `mail` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'adresse mail',
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Téléphone',
  `adresse` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Adresse',
  `cpost` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Code postal',
  `commune` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ville',
  `homonyme` tinyint NOT NULL DEFAULT '0' COMMENT 'Homonymie sur le prénom',
  `md5pwd` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mot de passe haché md5',
  `approuve` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Bénévole approuvé par un admin?\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `oxmdm1_users`
--

INSERT INTO `oxmdm1_users` (`pseudo`, `civilite`, `nom`, `prenom`, `droits`, `mail`, `telephone`, `adresse`, `cpost`, `commune`, `homonyme`, `md5pwd`, `approuve`) VALUES
('??????', NULL, '???', '???', 'nobody', 'nomail@nomail.com', '', '', '', '', 0, '', 0),
('bonnap', 'M', 'Bonaparte', 'Napoléon', 'oxfam', 'ymairse@gmail.com', '0474754696', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 1),
('cesjul', 'M', 'César', 'Jules', 'admin', 'jcesar@gmail.com', '0', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 1),
('curmar', 'F', 'Curie', 'Marie', 'oxfam', 'yves@sio2.be', '0474 754696', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 0),
('fraros', 'F', 'Franklin', 'Rosalind', 'oxfam', 'rfranklin@sio2.be', '0474 754696', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 1),
('maiyve', 'M', 'Mairesse', 'Yves', 'admin', 'ymairesse@sio2.be', '0474754686', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 1),
('newisa', 'M', 'Newton', 'Isaac', 'oxfam', 'ymairesse@sio2.be', '0474 754696', '', '', '', 0, '1224b6196e600af6d118b8d7a12fec76', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `oxmdm1_authToken`
--
ALTER TABLE `oxmdm1_authToken`
  ADD PRIMARY KEY (`acronyme`);

--
-- Index pour la table `oxmdm1_calendar`
--
ALTER TABLE `oxmdm1_calendar`
  ADD PRIMARY KEY (`idContexte`,`date`,`periode`,`pseudo`),
  ADD KEY `pseudo` (`pseudo`);

--
-- Index pour la table `oxmdm1_config`
--
ALTER TABLE `oxmdm1_config`
  ADD PRIMARY KEY (`parametre`);

--
-- Index pour la table `oxmdm1_congesFeries`
--
ALTER TABLE `oxmdm1_congesFeries`
  ADD PRIMARY KEY (`dateConge`,`periode`);

--
-- Index pour la table `oxmdm1_congesHebdo`
--
ALTER TABLE `oxmdm1_congesHebdo`
  ADD PRIMARY KEY (`idContexte`,`jour`,`periode`);

--
-- Index pour la table `oxmdm1_contextes`
--
ALTER TABLE `oxmdm1_contextes`
  ADD PRIMARY KEY (`idContexte`);

--
-- Index pour la table `oxmdm1_freeze`
--
ALTER TABLE `oxmdm1_freeze`
  ADD PRIMARY KEY (`date`);

--
-- Index pour la table `oxmdm1_heuresPermanences`
--
ALTER TABLE `oxmdm1_heuresPermanences`
  ADD PRIMARY KEY (`idContexte`,`numeroPermanence`);

--
-- Index pour la table `oxmdm1_lostPasswd`
--
ALTER TABLE `oxmdm1_lostPasswd`
  ADD PRIMARY KEY (`pseudo`,`date`),
  ADD KEY `acronyme` (`pseudo`);

--
-- Index pour la table `oxmdm1_users`
--
ALTER TABLE `oxmdm1_users`
  ADD PRIMARY KEY (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `oxmdm1_contextes`
--
ALTER TABLE `oxmdm1_contextes`
  MODIFY `idContexte` int NOT NULL AUTO_INCREMENT COMMENT 'numéro identifiant du contexte', AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `oxmdm1_calendar`
--
ALTER TABLE `oxmdm1_calendar`
  ADD CONSTRAINT `oxmdm1_calendar_ibfk_1` FOREIGN KEY (`idContexte`) REFERENCES `oxmdm1_contextes` (`idContexte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `oxmdm1_calendar_ibfk_2` FOREIGN KEY (`pseudo`) REFERENCES `oxmdm1_users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `oxmdm1_congesHebdo`
--
ALTER TABLE `oxmdm1_congesHebdo`
  ADD CONSTRAINT `oxmdm1_congesHebdo_ibfk_1` FOREIGN KEY (`idContexte`) REFERENCES `oxmdm1_contextes` (`idContexte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `oxmdm1_heuresPermanences`
--
ALTER TABLE `oxmdm1_heuresPermanences`
  ADD CONSTRAINT `oxmdm1_heuresPermanences_ibfk_1` FOREIGN KEY (`idContexte`) REFERENCES `oxmdm1_contextes` (`idContexte`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
