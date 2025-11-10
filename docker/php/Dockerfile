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
    libzip-dev \
    netcat-openbsd

# Limpa o cache do apt para manter a imagem pequena
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o Composer (gerenciador de dependências do PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- FIX 1: Add the git safe.directory configuration ---
# This fixes the "dubious ownership" warning.
RUN git config --global --add safe.directory /var/www/html

# --- FIX 2: Copy the application code BEFORE running commands that need it ---
# Copy all application code
COPY src/ .

RUN composer install --optimize-autoloader --no-interaction --no-scripts

# (Add this near where you copy the entrypoint.sh)
COPY docker/php/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Copy the entrypoint script
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

# Make the script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the entrypoint
ENTRYPOINT ["entrypoint.sh"]

# The default command to run after the entrypoint (from the base image)
CMD ["php-fpm"]

# Altera o dono do diretório para o usuário que o PHP-FPM usa
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 9000 para comunicação com o Nginx
EXPOSE 9000