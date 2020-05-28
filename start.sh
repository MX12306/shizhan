service php7.2-fpm start
service mysql start
mysql -e 'update mysql.user set host="%",authentication_string=password("ld80cn"),plugin="mysql_native_password" where user="root";'
mysql -e 'create database shizhan;'
cd /var/www/html/public/install/
mysql --default-character-set=utf8 -e 'use shizhan;source install.sql;'
mysql -e 'INSERT INTO ld_user (`user`, `password`, `isadmin`) VALUES ("admin", "abc!!!", 1)'
mysql -e 'flush privileges;'


nginx -g "daemon off;"
