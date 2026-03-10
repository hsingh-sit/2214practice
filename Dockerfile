
# Simple Apache + PHP image for the IAM Tri-Lab
FROM php:8.2-apache

# Copy app into Apache docroot
COPY . /var/www/html/

# Ensure the app (including data/*.json) is writable by Apache (www-data)
RUN chown -R www-data:www-data /var/www/html

# Apache listens on 80; map host 8000->80 when running.
EXPOSE 80
