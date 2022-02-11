# edit in case you need a different PHP version
FROM php:7.2-fpm

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update -qq && \
	apt-get install -y locales -qq && \
	echo "nl_NL.UTF-8 UTF-8" >> /etc/locale.gen && \
	locale-gen && \
	dpkg-reconfigure locales && \
	rm -r /var/lib/apt/lists/*

RUN apt-get update -qq && \
	apt-get install -y \
    $PHPIZE_DEPS \
    unzip \
    openssl \
    wget \
    git \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN apt-get update -qq && \
    apt-get install -y \
    libpng-dev \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN apt-get update -qq && \
    apt-get install -y \
    libicu-dev \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN apt-get update -qq && \
    apt-get install -y \
    libxml2-dev \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN apt-get update -qq && \
    apt-get install -y \
    libgmp3-dev \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo pdo_mysql mbstring tokenizer xml gmp opcache json dom zip exif fileinfo intl
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/d3e09029468023aa4e9dcd165e9b6f43df0a9999/web/installer \
	-O - -q | php -- --quiet --install-dir=/bin --filename=composer && chmod +x /bin/composer && /bin/composer self-update
