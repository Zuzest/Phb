# Phb
базовый шаблон для проекта на ***Phalcon*** с использованием шаблонизатора Smarty

после клонирования необходимо переименовать **local.cfg.php.example** в **local.cfg.php** `(local.cfg.php исключен из git)`
далее заполнить необходимые поля в новом файле
затем определиться с расположением вспомогательных служб/плагинов

текущий шаблон в качестве плагина использует **Smarty**, **Mobile-Detect** и **phpClickHouse**
создайте папку **PLUGINS**
в ней последовательно выполнить 
```
git clone https://github.com/serbanghita/Mobile-Detect.git
git clone https://github.com/smarty-php/smarty.git
git clone https://github.com/smi2/phpClickHouse.git
```
  для phpClickHouse необходимо войти в папку проекта и выполнить compose update

далее в файле local.cfg.php поправить константу так что бы она указывала на нашу папку PLUGINS


для установки phalcon в ubuntu:
```
sudo apt install -y php-phalcon
```

конфигурация nginx:
```nginx
server {
  listen 80;
  server_name server_name;
  root /var/www/sites/server_name/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_index index.php;
    fastcgi_param REMOTE_ADDR $http_x_real_ip;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_pass unix:/run/php/php7.2-fpm.sock; # заменить на вашу версию php
  }

  location ~ /\.ht {
    deny all;
  }
}
```
