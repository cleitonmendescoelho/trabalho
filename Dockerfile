# Exemplo - Estrutura base do DockerFile

FROM php:8.3

# Metadados
LABEL maintainer="dev@example.com"
LABEL version="1.0"

# Variáveis de ambiente
ENV APP_ENV=production

# Diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . .

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y unzip git curl \
    && docker-php-ext-install pdo pdo_mysql

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependências do PHP/Laravel
RUN composer install --no-dev --optimize-autoloader

# Expor a porta do servidor
EXPOSE 8080

# Comando para iniciar a aplicação
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]


# Option 1 - implementação rápida

# # Escolhe uma imagem base oficial do PHP com Composer instalado
# FROM php:8.3-cli

# # Instala dependências do sistema e extensões PHP necessárias para Laravel
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     libzip-dev \
#     zip \
#     libpng-dev \
#     libonig-dev \
#     curl \
#     && docker-php-ext-install pdo pdo_mysql mbstring zip

# # Instala o Composer manualmente
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Define o diretório de trabalho dentro do container
# WORKDIR /var/www/html

# # Copia os arquivos da sua máquina local para dentro do container
# COPY . .

# # Instala as dependências do Laravel
# RUN composer install

# # Expondo a porta padrão que o Laravel usa
# EXPOSE 8000

# # Comando para iniciar o servidor Laravel
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]





# Option 2 - Implementação mais completa

# # 1. Usar imagem base do PHP 8.3 com suporte a extensões
# FROM php:8.3-fpm

# # 2. Informações de quem mantém essa imagem (opcional)
# LABEL maintainer="seuemail@exemplo.com"

# # 3. Instalar dependências do sistema e extensões do PHP necessárias para o Laravel
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     curl \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install pdo pdo_mysql mbstring gd exif pcntl bcmath

# # 4. Instalar o Composer (gerenciador de pacotes PHP)
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # 5. Definir diretório de trabalho dentro do container
# WORKDIR /var/www

# # 6. Copiar os arquivos do projeto para dentro do container
# COPY . .

# # 7. Instalar dependências do Laravel (roda composer install)
# RUN composer install --prefer-dist --no-scripts --no-dev --optimize-autoloader

# # 8. Dar permissão para as pastas de cache/storage
# RUN chown -R www-data:www-data /var/www \
#     && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# # 9. Expor a porta (opcionalmente, para usar php artisan serve)
# EXPOSE 8000

# # 10. Definir o comando padrão ao rodar o container
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

