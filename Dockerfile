# Imagem base
FROM php:8.2-cli

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
