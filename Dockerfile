# Base PHP image tags
ARG php_composer_tag=8.0-v1


# Build temp image to install composer dependencies
FROM stephenneal/php-composer:${php_composer_tag} AS composer

# Set working directory
WORKDIR /var/www

# Composer install flags
ARG composer_flags="--no-scripts --no-autoloader"

# Copy composer & phpunit files
COPY ["composer.json", "composer.lock", "phpunit.xml.dist", "/var/www/"]

# Copy Package source
COPY config  /var/www/config/
COPY src  /var/www/src/
COPY tests  /var/www/tests/

# Install composer dependencies
RUN composer install

ENTRYPOINT ["vendor/bin/phpunit"]
