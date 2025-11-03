# Usa a imagem oficial do PHP 8.2 com FPM (gerenciador de processos FastCGI)
FROM php:8.2-fpm

# Define o diretório de trabalho padrão
WORKDIR /var/www/html

# Instala dependências do sistema e extensões PHP necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev

# Limpa o cache do apt para manter a imagem pequena
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o Composer (gerenciador de dependências do PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Altera o dono do diretório para o usuário que o PHP-FPM usa
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 9000 para comunicação com o Nginx
EXPOSE 9000