service php7.2-fpm start
service mysql start
mysql -e 'update mysql.user set host="%",authentication_string=password("ld80cn"),plugin="mysql_native_password" where user="root";'
# fix 1364 errcode
mysql -e 'SET @@GLOBAL.sql_mode="NO_AUTO_Create_USER,NO_ENGINE_SUBSTITUTION";'
mysql -e 'create database shizhan;'
cd /var/www/html/public/install/
mysql --default-character-set=utf8 -e 'use shizhan;source install.sql;'
mysql -e 'INSERT INTO shizhan.ld_user (`user`, `password`, `isadmin`) VALUES ("admin", "adminadmin", 1)'
mysql -e 'flush privileges;'


nginx -g "daemon off;"
