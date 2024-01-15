FROM arm64v8/debian:stable-slim

# Get Debian up-to-date
RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y git \
    mariadb-client wget curl \
    ca-certificates lsb-release apt-transport-https gnupg bsdmainutils

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list \
    && curl https://packages.sury.org/php/apt.gpg | apt-key add - \
    && apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y php8.3 php8.3-common php8.3-cli \
    php8.3-curl php8.3-xml php8.3-mbstring \
    php8.3-intl php8.3-redis php8.3-zip php8.3-mysql \
    php8.3-bcmath php8.3-gd php8.3-imagick php8.3-memcached \
    php8.3-sqlite php8.3-mysql php8.3-pdo-mysql


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash

RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN apt -y install libapache2-mod-php8.3

RUN sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php/8.3/apache2/php.ini

RUN sed -i 's/.*max_input_vars = .*/max_input_vars = 10000/' /etc/php/8.3/apache2/php.ini

RUN sed -i 's/post_max_size = .*/post_max_size = 256M/' /etc/php/8.3/apache2/php.ini

RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 256M/' /etc/php/8.3/apache2/php.ini

RUN a2enmod headers

RUN a2enmod rewrite

ADD 000-default.conf /etc/apache2/sites-available/000-default.conf

CMD ["apachectl", "-D", "FOREGROUND"]