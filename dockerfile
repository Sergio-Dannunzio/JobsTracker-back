# Eliminar directorios de dependencias previas
RUN rm -rf /app/vendor
RUN rm -f /app/composer.lock

# Ejecutar instalación de dependencias
RUN composer install --no-autoloader --ignore-platform-reqs

# Usar una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto al contenedor
COPY . .

# Instalar dependencias con Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer install --no-scripts

# Exponer el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]
