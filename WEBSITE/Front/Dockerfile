# Utilisez une image officielle de PHP avec Apache
FROM php:apache

# Installer les extensions PDO et PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Créez les répertoires nécessaires dans le conteneur
RUN mkdir -p /var/www/HTML /var/www/CSS /var/www/Images

# Copiez le contenu du dossier HTML dans le répertoire HTML du conteneur
COPY HTML/ /var/www/HTML/

# Copiez le contenu du dossier CSS dans le répertoire CSS du conteneur
COPY CSS/ /var/www/CSS/

COPY Images/ /var/www/Images/
