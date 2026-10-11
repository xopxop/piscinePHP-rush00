FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html

# Default to an empty string for local builds
ARG ENV_FILE_CONTENT=""

# Only write the .env file if the argument is provided
RUN if [ -n "$ENV_FILE_CONTENT" ]; then \
        echo "$ENV_FILE_CONTENT" > /var/www/html/.env; \
    fi

EXPOSE 80
