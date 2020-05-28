FROM ubuntu:18.04
MAINTAINER 0x0d
ENV TZ "Asia/Shanghai"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update&& apt-get install -y tzdata php-fpm php-dev php-mysql php-gd php-curl php-pear nginx mysql-server

RUN mkdir -p /var/www/html
ADD source /var/www/html/
ADD default /etc/nginx/sites-enabled/default
ADD www.conf /etc/php/7.2/fpm/pool.d/www.conf
ADD start.sh start.sh
RUN chmod +x start.sh
RUN chmod -R 775 /var/www/html && chown www-data:www-data -R /var/www/html
ADD mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf
RUN usermod -d /var/lib/mysql/ mysql
ADD database.php /var/www/html/application/database.php
ADD install.lock /var/www/html/public/install/install.lock
ADD config.php /var/www/html/application/config.php
EXPOSE 80 443 3306
CMD ["/bin/bash", "start.sh"]
