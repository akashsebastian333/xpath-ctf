FROM php:8.2

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y git

EXPOSE 80

# Start Apache web server
CMD ["php", "-S", "0.0.0.0:80"]
