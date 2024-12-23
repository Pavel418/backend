

--
-- Structure de la table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customerTitle` varchar(20) NOT NULL,
  `customerLastname` varchar(20) NOT NULL,
  `customerFirstname` varchar(20) NOT NULL,
  `customerStreetAddress` varchar(100) NOT NULL,
  `customerStreetAddress2` varchar(100) NOT NULL,
  `customerZipCode` varchar(20) NOT NULL,
  `customerCity` varchar(50) NOT NULL,
  `customerPhone` varchar(20) NOT NULL,
  `customerEmail` varchar(100) NOT NULL,
  `customerRegisterDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

