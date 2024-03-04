FROM hovakimyann/u-team-infrastructure:latest

WORKDIR /var/www/html
COPY . .
RUN composer install
CMD ["./run.sh"]
