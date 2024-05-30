-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 mai 2024 à 11:31
-- Version du serveur : 8.0.36
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `espace_membres`
--

-- --------------------------------------------------------

--
-- Structure de la table `billet`
--

DROP TABLE IF EXISTS `billet`;
CREATE TABLE IF NOT EXISTS `billet` (
  `id_billet` int NOT NULL AUTO_INCREMENT,
  `id_users` int NOT NULL,
  `id_evenements` int NOT NULL,
  PRIMARY KEY (`id_billet`),
  KEY `user` (`id_users`),
  KEY `event` (`id_evenements`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `billet`
--

INSERT INTO `billet` (`id_billet`, `id_users`, `id_evenements`) VALUES
(30, 1, 5),
(31, 1, 11),
(32, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

-- DROP TABLE IF EXISTS `comments`;
-- CREATE TABLE IF NOT EXISTS `comments` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `pseudo` varchar(255) NOT NULL,
--   `date` date NOT NULL,
--   `commentaire` text NOT NULL,
--   `reference` varchar(255) NOT NULL, -- Correction de la longueur de la colonne `reference`
--   PRIMARY KEY (`id`)
-- ) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --
-- -- Déchargement des données de la table `comments`
-- --

-- INSERT INTO `comments` (`id`, `pseudo`, `date`, `commentaire`, `reference`) VALUES
-- (1, 'Dong', '2024-05-12', 'HEY, comment sa va ? Vous avez manger? C\'était comment le festival ?', 'POST'),
-- (2, 'Dong', '2024-05-15', 'teste modif', 'Modification'),
-- (23, 'TESTE', '2024-05-14', 'TESTE', 'TESTE'),
-- (3, 'Dong', '2024-05-12', 'sqdhcxlkcclxkcisl,fqnslki,qml nvcmkjeqfl!q,mlscnojmoqsl,fclqmojfzl, sqclmsqjfl,csmsqzl,mcqskskdkmqls', 'POST'),
-- (4, 'Dong', '2024-05-12', 'lqskdmsqkdmlqlscxlm;cwskdqsl;cxqskdlmsqkdlmqksldksmqkdlkqmdkozdqmlslmkclx', 'POST'),
-- (14, 'FAN', '2024-05-15', 'TESTE TESTE ', 'TESTE'),
-- (6, 'Dong', '2024-05-12', 'lkdsqx', 'POST'),
-- (8, 'Dong', '2024-05-12', 'Salut', 'POST'), -- Correction de la référence "Post" à "POST"
-- (9, 'Dong', '2024-05-12', 'Coucou', 'POST'),
-- (36, 'Dong', '2024-05-17', 'envoie', 'envoie'),
-- (37, 'root', '2024-05-17', 'test', 'teste'),
-- (11, 'Dong', '2024-05-12', 'Hello\r\nsqdhcxlkcclxkcisl,fqnslki,qml nvcmkjeqfl!q,mlscnojmoqsl,fclqmojfzl, sqclmsqjfl,csmsqzl,mcqskskdkmqls', 'POST'),
-- (12, 'Dong', '2024-05-12', 'Allo\r\nsqdhcxlkcclxkcisl,fqnslki,qml nvcmkjeqfl!q,mlscnojmoqsl,fclqmojfzl, sqclmsqjfl,csmsqzl,mcqskskdkmqls', 'POST'),
-- (13, 'Dong', '2024-05-12', 'Holla\nsqdhcxlkcclxkcisl,fqnslki,qml nvcmkjeqfl!q,mlscnojmoqsl,fclqmojfzl, sqclmsqjfl,csmsqzl,mcqskskdkmqls', 'Festival'),
-- (15, 'TONG', '2024-05-15', 'Bonne festival', 'TESTE 2'),
-- (16, 'LOL', '2024-05-15', 'teste 3', 'teste 3 '),
-- (26, 'XIAO', '2024-05-08', 'teste', 'teste'),
-- (35, 'Dong', '2024-05-17', 'envoie', 'envoie');


-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `artistes` varchar(255) NOT NULL,
  `type` int NOT NULL,
  `prix` int NOT NULL,
  `date_début` date NOT NULL,
  `date_fin` date NOT NULL,
  `imageDetail1` varchar(255) NOT NULL,
  `imageDetail2` varchar(255) NOT NULL,
  `imageDetail3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `popular` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `nom`, `localisation`, `image`, `description`, `artistes`, `type`, `prix`, `date_début`, `date_fin`, `imageDetail1`, `imageDetail2`, `imageDetail3`, `popular`) VALUES
(1, 'Solidays', 'Paris-Longchamp', 'https://www.guettapen.com/wp-content/uploads/2019/06/Solidays-2019-2.jpg', 'Depuis 1999, Solidays rassemble des artistes, conférenciers, militants et festivaliers. Durant les 3 jours de musique et de solidarité, les bénéfices récoltés permettent de financer des programmes de prévention et d’aide aux malades du SIDA.', 'GAZO & TIAKOLA - MARTIN GARRIX - PLK - MIKA - ZOLA - SDM - POMME - LOUISE ATTAQUE - WERENOI - CHARLOTTE CARDIN - LA FEVE - DIPLO - URUMI - TIF - SANTA - JETLAG GANG - SAM SMITH - ZAMDANE - SO LA LUNE  - LAURENT GARNIER - STYLETO - BABY VOLCANO', 2, 59, '2024-06-28', '2024-06-30', 'https://www.solidays.org/wp-content/uploads/2022/01/riles_1140_500_px-1140x570.jpg', 'https://www.guettapen.com/wp-content/uploads/2023/11/363420158_660100122812004_8265898842019057879_n.jpeg', 'https://www.soonnight.com/images/editor/1/fichiers/images/hippodrome-de-longchamp-l-773597_103.jpg', 1),
(2, 'Rock en Seine', 'Saint-Cloud', 'https://www.francetvinfo.fr/pictures/PM2zCQ6oCISr8wmr_MKxNh3xkvk/1200x1200/2023/08/24/64e74e485f6d1_billie-eilish-9-olivierhoffschir.jpg', 'Depuis plus de vingt ans, Rock en Seine est l’un des plus grands rendez-vous de l’été en France. Pouvant accueillir jusqu’à 40.000 festivaliers et festivalières chaque jour, Rock en Seine réunit le meilleur de la scène pop-rock internationale.', 'LANA DEL REY - FRED AGAIN - LCD SOUNDSYSTEM - MANESKIN - MASSIVE ATTACK - PJ HARVEY - THE OFFSPRING - THE SMILE - 2MANYDJS - BAXTER DURY - BLONDE REDHEAD - FRANK CARTER & THE RATTLESNAKES - GHINZU - GLASS BEAMS - GOSSIP - INHALER - JUNGLE - KASABIAN', 2, 59, '2024-08-21', '2024-08-25', 'https://urlz.fr/qt7y', 'https://styley.fr/images/articles/302201039_449142953919173_7126025965629333020_n.webp.webp', 'https://popnshot.fr/wp-content/uploads/2017/08/DSC1890.jpg', 1),
(3, 'We Love Green', 'Paris', 'https://weloveart.net/wp-content/uploads/2013/09/photo_wlg.jpeg', ' WE LOVE GREEN invite depuis 2011 des artistes déchaînés et passionnants qui dessinent la musique de notre époque, et attirent jusqu’à 80 000 personnes. Une programmation éclectique qui traverse les ponts entre indie, électro et urbain.', 'SZA - JUSTICE - NINHO - PEGGY YOU - BURNA BOY - KAYTRANADA - HAMZA - JOSMAN - FOUR TET - SHAY - LUIDJI - KING GIZZARD - OMAR APOLLO - L\'IMPERATRICE - CHILLY GONZALES - TROYE SIVAN - ANETHA - SKEPTA DJ - KENYA GRACE - EDDY DE PRETTO - CHASE & STATUS ', 2, 59, '2024-05-31', '2024-06-02', 'https://diveng.rosselcdn.net/sites/default/files/dpistyles/ena_16_9_extra_big/node_2808/8046/public/thumbnails/image/welovegreen.jpg?itok=UYCNtawF1684238606', 'https://www.radiofrance.fr/s3/cruiser-production/2020/12/42b9eb78-c216-4333-94c6-9ceb38a00459/870x489_02062018_18h41_dsc_1464_-_maxime_chermat.jpg', 'https://urlz.fr/qt9G\r\n', 1),
(4, 'Hellfest', 'Clisson', 'https://static.wixstatic.com/media/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg/v1/fill/w_640,h_426,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/cbbad6_0b8204041c92473da366669e12317f75~mv2.jpg', 'En 17 éditions, le Hellfest est devenu LE festival dédié aux musiques extrêmes en France et reconnu à l’international. Avec 240.000 festivaliers sur 4 jours,il se tient depuis sa première édition en 2006, dans la ville de Clisson en Loire-Atlantique.', 'FOO FIGHTERS - METALLICA - AVENGED SEVENFOLD - MACHINE HEAD - QUEENS OF THE STONE AGE - THE OFFSPRING - DROPKICK MURPHYS - SAXON - THE PRODIGY ', 3, 59, '2024-06-27', '2024-06-30', 'https://img.republiknews.fr/crop/fill/bdbd0235be422f372ac129896ca809a3/0/172/6898/3881/1200/627/hellfest-festival-experiences-inedites-innove-chaque-edition.jpg', 'https://img.20mn.fr/zqIMz4X1QI6IS9yiAtvJqyk/1444x920_l-entree-du-controle-billetterie-du-festival-hellfest-a-clisson-en-juin-2023', 'https://i2.wp.com/newsoundsmag.co.uk/wp-content/uploads/2019/08/Hellfest-experience-1600x1400.jpg?fit=1600%2C1400&ssl=1', 1),
(5, 'Les Eurockéennes', 'Belfort', 'https://www.sncf-connect.com/assets/media/2022-05/eurockeennes.jpg', 'Éternel adolescent de 34 ans, les Eurockéennes figure parmi les grands rassemblements musicaux les plus réputés d’Europe. Rassembleuse et défricheuse, sa programmation explore toutes les musiques, en accueillant chaque année les plus grands noms.', 'DAVID GUETTA - LENNY KRAVITZ - SUM 41 - THE PRODIGY - BIGFLO & OLI - SCH - GAZO - DROPKICK MURPHYS - KAARIS - ROYAL BLOOD - IDLES - BLACK PUMAS -  HEILUNG - SHAY - OUMOU SANGARE - ZAHO DE SAGAZAN - PURPLE DISCO MACHINE - THE BREEDERS - PRETENDERS', 2, 59, '2024-07-04', '2024-07-07', 'https://www.espaceconcept.eu/wp-content/uploads/2021/05/eurocks1.jpg', 'https://www.vdlv.fr/wpcontent/uploads/2023/07/Indochine-pour-clore-les-Eurockeennes-2023.jpg', 'https://solidaires.eurockeennes.fr/wp-content/uploads/2016/06/RGarcia-Eurocks-vue-Salbert.jpg', 1),
(6, 'Les Francofolies', 'La Rochelle', 'https://www.parc-marais-poitevin.fr/wp-content/uploads/parc-naturel-regional-marais-poitevin-villes-de-nuit-vibrer-Franck_Moreau-1280-1280x610.jpg', ' Portés par des passionnés partageant les mêmes envies et le même amour de la scène francophone, six festivals constituent aux côtés des Francofolies de La Rochelle, l\'association des Francofolies autour du monde. ', 'STING - JEAN-MICHEL JARRE - NINHO - PATRICK BRUEL - BIGFLO & OLI - PLK - PHOENIX - GRAND CORPS MALADE - PASCAL OBISPO - ETIENNE DAHO - ALAIN SOUCHON - JOSMAN - ZOLA - SOFIANE PAMART - ZAHO DE SAGAZAN - DAMIEN SAEZ SOLO - LUIDJI - EDDY DE PRETTO - YAME', 2, 59, '2024-07-10', '2024-07-14', 'https://media.sudouest.fr/2157151/1000x500/so-5f0c0a8d66a4bd7b68d490d4-ph0.jpg?v=1618482972', 'https://bullesdeculture.com/bdc-content/uploads/2023/03/les-francofolies-de-la-rochelle-final-ambiance-francofolies-crebit-bydimworks.jpeg', 'https://media.sudouest.fr/11681938/1000x500/20220717224026-167222nouveau95i9133.jpg?v=1658091652', 1),
(7, 'Le Delta Festival', 'Marseille', 'https://offloadmedia.feverup.com/marseillesecrete.com/wp-content/uploads/2022/04/13123511/Delta-Festival-Marseille-1024x576.jpg', 'Le Delta Festival fête son 10ième anniversaire avec une pléiade de têtes d\'affiche qui vont faire vibrer les grains de sable de la plage du Prado ! Cinq jours de festival, cinq scènes, des dizaines d\'artistes, des animations à gogo...', 'ASTRIX - GAZO - JUSTICE - MANDRAGORA - JAIN - MARTIN SOLVEIG - PLK - SCH - SEFA - TIAKOLA - VINI VICI - VLADIMIR CAUCHEMAR - ADIEL - ACID ARAB - BLOND:ISH - CERA KHIN - CARAVAN PALACE - CLARA CUVE - HECTOR OAKS - MATHAME - NICO MORENO', 4, 59, '2024-09-04', '2024-09-08', 'https://electro-news.eu/wp-content/uploads/2021/11/Laurine-bailly-canopee-foule.jpg', 'https://tarpin-bien.com/wp-content/uploads/2023/08/delta-festival-2023.jpg', 'https://static.latribune.fr/2207977/delta-festival.jpg', 1),
(8, 'Le Printemps de Bourges', 'Bourges', 'https://www.longueurdondes.com/wp-content/uploads/2016/04/PDB2016_Ambiance_W@Marylene_Eytier-2968.jpg', 'Le Printemps de Bourges annonce le renouveau artistique et la venue des beaux jours en ouvrant la saison des festivals. Son identité artistique épouse un large éventail d’esthétiques musicales et repose sur un équilibre entre artistes confirmés.', 'ADELE CASTILLON - 135 - ADI OASIS - AGHIAD - AKIRA & LE SABBAT - ALBAN CLAUDIN - ALBIN DE LA SIMONE - ALEX kAPRANOS - ALEX MONTEMBAULT - ALIOCHA SCHNEIDER - ANAIS MVA - ANAYSA - ANNA MOUGLALIS & LUCIE AUTUNES - ARONE - ASTRAL BAKERS - BASTIEN BURGER', 2, 59, '2024-04-22', '2024-04-28', 'https://france3-regions.francetvinfo.fr/image/g2uGQSDXyecIiK3NwFDW1twwIu8/600x400/regions/2020/06/09/5edf96d64d8a4_ambiance_matthieu_foucher_hd_45-4755608.jpg', 'https://www.bourgesberrytourisme.com/wp-content/uploads/2019/04/dsc08499-1200x915.jpg', 'https://www.touslesfestivals.com/caches/ad044e30291f77a5829b095e19dad8614e1dd0d8-1040x540-outbound.jpg', 1),
(9, 'Rose Festival', 'Aussonne', 'https://static.actu.fr/uploads/2023/06/boby-boby-l1470093.jpg', 'Le Rose Festival est né de la volonté de Bigflo et Oli de créer un festival innovant aux multiples facettes culturelles s’inscrivant dans la durée sur le territoire toulousain. ', 'JAIN - FRANCIS CABREL - MC SOLAAR - NINA KRAVIZ - BOOBA -ZOLA - POMME - TIF - LA FEVE - JUSTICE', 2, 59, '2024-08-01', '2024-09-01', 'https://cdn.al-ain.com/images/2022/8/27/229-122925-0596385e-e400-4921-9f44-bb8446ed1771.jpeg', 'https://www.aficia.info/wp-content/uploads/2023/09/RoseFest_3516%C2%A9MDHML-scaled.jpg', 'https://cdt31.media.tourinsoft.eu/upload/Rose-Festival-2023---Remi-Deligeon-copie.jpg', 1),
(10, 'Festival Art Rock', 'Saint-Brieuc', 'https://crtb.cloudly.space/app/uploads/crt-bretagne/2022/12/thumbs/Festival-Art-Rock_Gwendal-Le-Flem-1920x960.jpg', 'En 1983, l’association Wild Rose décide de créer un festival inédit à Saint-Brieuc et de se concentrer exclusivement sur ce projet. Le festival Art Rock est né. Depuis, chaque année Art Rock continue de faire vibrer le centre-ville de Saint-Brieuc.', 'THE LIBERTINES - ETIENNE DAHO - MORCHEEBA - HOSHI - LUIDJI - EDDY DE PRETTO - ZAHO DE SAGAZAN - YAME - FAVE - LOU DOILLON - OLIVIA RUIZ - JULIEN GRANEL - FLAVIEN BERGER - IRENE DRESEL - KERCHAK - ZED YUN PAVAROTTI - CLARA YSE - JOANNA - CALYPSO VALOIS', 2, 59, '2024-05-17', '2024-05-19', 'https://www.artrock.org/wp-content/uploads/2024/02/art-rock-2022-credits-spoon-768x512.jpg', 'https://www.portdattache.bzh/wp-content/uploads/2018/06/art-rock-foule-gwendal-leflem.jpg', 'https://www.artrock.org/wp-content/uploads/2021/05/yelle-de-gwendal-le-flem-2015-9-1536x768.jpg', 1),
(11, 'Les Ardentes', 'Liège (BE)', 'https://www.lalibre.be/resizer/sm6KnxernBa1o26E-RAez0VBQWI=/1200x800/filters:format(jpeg):focal(895x556.5:905x546.5)/cloudfront-eu-central-1.images.arcpublishing.com/ipmgroup/V2SHFWTCCBAWZABISSQV7TXGGY.jpg', 'Fondé en 2006, le festival se veut tout d\'abord électro-rock puis décide de s\'ouvrir tout doucement aux autres musiques que ça soit de la pop, du rock, de la musiques électroniques, de la chanson française mais aussi hip-hop et même jazz.', '13 BLOCK - 21 SAVAGE - ADVM - AYRA STARR - B.B. JACQUES - BB TRICKZ -BEKAR - BEN PLG - BOOBA - CENTRAL CEE - D-BLOCK EUROPE - DALI - DESTROY LONELY - DINA AYADA - DJ SNAKE - DOJA CAT - DON TOLIVER - DOUMS - DYSTINCT - ELGRANDETOTO - ENIMA - FALLY IPUPA', 1, 59, '2024-07-11', '2024-07-14', 'https://www.lavenir.net/resizer/v2/WJRTJ42IE5BTFOJD4QXCQCSCP4.jpg?auth=df5a311c351d8b332e54a438e98c3d982859a3c8325493a54199206a700d0f4c&width=1620&height=1080&quality=85&focal=373%2C249', 'https://live.staticflickr.com/8740/27949036690_88f6748901_b.jpg', 'https://wave.fr/images/1916/08/les_ardentes_festival_aftermovie.jpg', 0),
(13, 'Golden Coast Festival', 'Dijon', 'https://www.quotidien-libre.fr/wp-content/uploads/2023/12/jfjhgkhgkhjkh-350x250.png', 'Et si le paradis des fans de rap francophone se trouvait à Dijon ? Cette année, on est tous hype par le Golden Coast Festival, et à raison. Le line-up est certifié 100 % hip-hop et s’inscrit comme l’un des plus impressionnants pour un festival naissant.', 'ANGIE & LAZULI - BUSHI - BAMBY - BOOBA -DJAJA & DINAZ - DORIA - FAVE - FONKY FAMILY - HOUDI - HUGO TSR - JOSMAN - JUNGELI - KAY THE PRODIGY - LA FEVE - LUIDJI - LUTHER - LALA &CE - LESRAM - MAUREEN - MERVEILLE - MORAD - NINHO - ROUNHAA - SCH - SDM ', 1, 59, '2024-09-13', '2024-09-14', 'https://static.cnews.fr/sites/default/files/golden_coast_656dfa5ad610d_0.jpg', 'https://europebookings.com/wp-content/uploads/solar-weekend-festival-stage-lights-show.jpg', 'https://europebookings.com/wp-content/uploads/solar-weekend-festival-stage-dancing.jpg', 0),
(14, 'Festival Chorus', 'Boulogne-Billancourt', 'https://chorus.hauts-de-seine.fr/wp-content/uploads/2023/04/4.jpg', 'Au Chorus des Hauts-de-Seine, on pense aux festivaliers. Pendant tout le week-end, des animations sont proposées pour vivre votre festival à 100%.\r\nAvec le hors scène, grosse ambiance en perspective dans La Grande Rue et au Téléscope.', 'DINOS - SOPYCAL + LIVE BAND - AMAHLA - CALLING MARIAN - HOUDI - GUILLAUME PONCELET - PARQUET - FAVE - GROVE - BEKAR - BADA -BADA - IAMDDB - JULIEN GRANEL - LE SEINLAB - TONY LA FRIPE - DOMBRANCE - LUIDJI - COLT - RORI - DJ KERBY - SPIDER - TUERIE', 1, 59, '2024-03-20', '2024-03-24', 'https://chorus.hauts-de-seine.fr/wp-content/uploads/2023/01/parvis-3-sgo.jpg', 'https://mesinfos.fr/content/articles/152/A194152/initial-jok-air.jpg', 'https://www.hauts-de-seine.fr/fileadmin/user_upload/2304SGO032300.jpg', 0),
(15, 'Boomin Fest', 'Rennes', 'https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_1500,h_1000/https://krumpp.fr/wp-content/uploads/2023/05/@MAXLMNR_BOOMIN-FEST_-RENNES_10.jpg', 'BOOMIN Fest, c\'est une célébration de la scène rap actuelle et une invitation au turn-up. Pour sa troisième édition les organisateurs proposeront une nouvelle fois un audacieux plateau rassemblant têtes d\'affiches, révélations et talents locaux.', 'TH - WALLACE CLEAVER - KOBA LAD - ZOLA - BUSHI', 1, 59, '2024-04-19', '2024-04-20', 'https://hypesoul.com/wp-content/uploads/2023/05/MAXLMNR_BOOMIN_NANTES_073-1-1536x1024-1-1024x683.jpg', 'https://www.fragil.org/wp-content/uploads/2023/05/coelho-lumieres-2.jpg', 'https://www.bigcitylife.fr/wp-content/uploads/2023/04/1yFfSBgg-scaled.jpg', 0),
(16, 'Les Paradis Artificiels', 'Lille', 'https://www.touslesfestivals.com/uploads/acfd9d1c8d8474d6072d856214f118efeb2e425b/b6392eeabb61a5426766f317a278f9df6e1ae963.jpg', 'Les Paradis artificiels est un festival de musiques actuelles créé en 2007 qui se déroule en mars dans l\'agglomération lilloise. Il est organisé par la société de production À Gauche de la Lune et son édition 2009 a accueilli 42 000 spectateurs.', 'NISKA - CABALLERO & JEANJASS - LA FEVE - ZAMDANE - CRISTALE - HOUDI - MADEMOISELLE LOU - 8RUKI - TUERIE - ANNIE .ADAA - AAMO - GAZO - LALA &CE - TIF - PRINCE WALY - ISHA & LIMSA - NES - MALO - STONY STONE - JEY BROWNIE', 1, 59, '2024-06-01', '2024-06-02', 'https://i.ytimg.com/vi/PubOUnnSlbg/maxresdefault.jpg', 'https://vozer.s3.eu-west-3.amazonaws.com/production/1690052611/yozi9ootfz7grf8mx1ilo0rchl78/paradis3-1-scaled.jpg', 'https://www.touslesfestivals.com/uploads/medias/2022/06/10145721_photo4.png', 0),
(17, 'Marsatac', 'Marseille', 'https://www.jds.fr/medias/image/festival-marsatac-2-228912-1200-630.jpg', 'En période de préparation du festival, Orane mobilise autour d’elle de nombreuses personnes aux savoir-faire, expériences et talents variés qui ont pour objectif commun de faire du festival Marsatac l’un des meilleurs du genre.', 'HOUDI - MENACE SANTANA - LUIDJI - LUTHER - MORAD - SDM - SHAY - TIF - WERENOI - ZOLA - ZAMDANE - BOYS NOIZE - DJ HEARTSTRING - KOBOSIL - MARLON HOFFSTADT - PATRICK MASON - VTSS - ACHIM - DARIA KOLOSOVA - JERSEY - LESRAM - MALUGI - MARIE DAVIDSON - MCR-T', 1, 59, '2024-06-14', '2024-06-16', 'https://europebookings.com/wp-content/uploads/marsatac-festival-main-stage-view.jpg', 'https://electro-news.eu/wp-content/uploads/2018/06/ma2-e1530043449744.jpg', 'https://gomet.net/wp-content/uploads/2022/06/entree_2_2022.jpg', 0),
(18, 'Les 3 éléphants', 'Laval', 'https://upload.wikimedia.org/wikipedia/commons/a/a1/Les_3_%C3%A9l%C3%A9phants_2022_-_Laylow_%28c%29Alexis_Janicot.jpg', 'Les 3 éléphants est un festival de musiques actuelles et d’arts de la rue. Le festival a été créé en 1998 à Lassay-Les-Châteaux et se déroule dans le centre-ville de Laval depuis 2010 à destination d’un public plurigénérationnel et familial.', 'ETIENNE DAHO - SDM - BOYS NOIZE - LUTHER - YAME - CREEDS - ISAAC DELUSION - TIF - SOLANN - DALI - AUPINARD - MALO - PEPITE - SAM QUEALY - KABEAUSH2 - ADA ODA - BELARIA - RADIO CARGO - GURRIERS - NIKOLA - RALPHIE CHOO - JETLAG GANG - TURTLE WHITE', 1, 59, '2024-05-26', '2024-06-02', 'https://www.les3elephants.com/wp-content/uploads/2023/05/3lf23-alexis-janicot-samedi-6-800x400.jpg', 'https://storage.canalblog.com/85/85/291675/96077083_o.jpg', 'https://www.francebleu.fr/s3/cruiser-production/2023/05/98c1190f-b0b7-41db-b885-ff220741d733/1200x680_sc_fwhrmhbwiaqn7m3.jpg', 0),
(20, 'Les Vieilles Charrues', 'Carhaix', 'https://media.ouest-france.fr/v1/pictures/MjAxODA3YTZjNTMzNWUyMjVkMjJlNDk2YTZmNGMxNjIyM2FkMjY?width=1260&height=708&focuspoint=50%2C25&cropresize=1&client_id=bpeditorial&sign=6a0c08127be878d28c8ae1502fa5cdc87dab77f41189b1ce61b62d088ea0e271', 'Réputé pour son esprit festif et convivial, le festival des Vieilles Charrues est né en 1992 sous l’impulsion d’une bande d’amis. La programmation est éclectique et de qualité : The Cure, Sting et Justice notamment à l’affiche en 2012.', 'DAVID GUETTA - LENNY KRAVITZ - SUM 41 - THE PRODIGY - BIGFLO & OLI - SCH - GAZO - DROPKICK MURPHYS - KAARIS - ROYAL BLOOD - IDLES - BLACK PUMAS - HEILUNG - SHAY - OUMOU SANGARE - ZAHO DE SAGAZAN - PURPLE DISCO MACHINE - THE BREEDERS - PRETENDERS', 3, 80, '2024-07-11', '2024-07-14', 'https://images.lesindesradios.fr/fit-in/1100x2000/filters:format(webp)/radios/alouette/importrk/news/original/6037934a97bc67.78118269.png', 'https://static.latribune.fr/full_width/1215618/vieilles-charrues-festival.jpg', 'https://www.jds.fr/medias/image/les-vieilles-charrues-1-168256-1200-630.jpg', 0),
(21, 'La Route du Rock', 'Saint-Malo', 'https://static.actu.fr/uploads/2022/08/e7dbed76830368cdbed76830380ebev-960x612.jpg', 'L\'ancien édifice militaire datant du XVIIIe siècle, sur la commune de Saint-Père, en devient le site phare. Dans le même temps, le palais des Congrès se dédie entièrement au rock et une plage intra-muros devient synonyme de soirées mémorables.', 'DAVID GUETTA - LENNY KRAVITZ - SUM 41 - THE PRODIGY - BIGFLO & OLI - SCH - GAZO - DROPKICK MURPHYS - KAARIS - ROYAL BLOOD - IDLES - BLACK PUMAS - HEILUNG - SHAY - OUMOU SANGARE - ZAHO DE SAGAZAN - PURPLE DISCO MACHINE - THE BREEDERS - PRETENDERS', 3, 75, '2024-08-14', '2024-08-17', 'https://www.saint-malo-tourisme.com/app/uploads/saint-malo-tourisme/2023/07/thumbs/Easy-Ride-La-Route-du-Rock-1920x960-crop-1688635361.jpg', 'https://www.radiofrance.fr/s3/cruiser-production/2023/06/13a3f4dc-0b55-4fed-a50c-963d2701e2b1/1200x680_sc_la-route-du-rock-fort-de-st-pe-re-2022-ctitouan-masse-2.jpg', 'https://www.leparisien.fr/resizer/jQWjCSzghrN9SLW2Axa6q-WBujI=/932x582/arc-anglerfish-eu-central-1-prod-leparisien.s3.amazonaws.com/public/SX4QFXQAEUGTHVFXRSG2RUWHDI.jpg', 0),
(22, 'Les Transmusicales', 'Rennes', 'https://france3-regions.francetvinfo.fr/image/xu4hyue16GIik9EwcSllwRew0a4/1200x900/regions/2021/11/22/619bb8ad9c124_photo-transmu.jpg', 'C\'est festival de musiques actuelles né en 1978, propose chaque année trois jours de concerts, début décembre. Gérées par une association, Les Trans ont derrière elles une réputation justifiée de dénicheur de jeunes pousses musicales. ', 'ASTRIX - GAZO - JUSTICE - MANDRAGORA - JAIN - MARTIN SOLVEIG - PLK - SCH - SEFA - TIAKOLA - VINI VICI - VLADIMIR CAUCHEMAR - ADIEL - ACID ARAB - BLOND:ISH - CERA KHIN - CARAVAN PALACE - CLARA CUVE - HECTOR OAKS - MATHAME - NICO MORENO', 3, 65, '2024-12-04', '2024-12-08', 'https://uploads.lebonbon.fr/source/2022/november/2037931/trans_1_2000.jpg', 'https://i.f1g.fr/media/cms/orig/2021/12/05/92a66f9678134d1e0db8a492f13628f4de7e5613feacb7ca414ac3d89caee3c9.jpg', 'https://static.actu.fr/uploads/2021/11/audience-g20e71d39e-1920.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int DEFAULT NULL,
  `question` text NOT NULL,
  `reponse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id`, `question`, `reponse`) VALUES
(NULL, 'zaza', 'zaza'),
(NULL, 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(45) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `nom`, `date_naissance`, `email`, `mdp`) VALUES
(1, 'Gauthier', 'Schmitt', '2024-04-11', 'gauthier.schmitt1@gmail.com', '$2y$10$7KZ8xaN3eWOth2C2HgM3tOCK2qFQB5pyvOSlBwY1YhJeY0oJa1Wmm'),
(3, 'Gauthier1', 'Schmitt', '2024-04-01', 'gauthier.schmitt1@gmail.com', '$2y$10$Yhcer/DfSxODMG2eIN6K2u13cl3uKUfwF65ttPqeoz.VxpZQsArDW');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billet`
--
ALTER TABLE `billet`
  ADD CONSTRAINT `user` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
