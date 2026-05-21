# استخدام نسخة PHP الرسمية مدمجة مع سيرفر Apache
FROM php:8.2-apache

# تثبيت خادم قاعدة البيانات MariaDB داخل نفس الحاوية لمنع أخطاء الاتصال الخارجية
RUN apt-get update && apt-get install -y mariadb-server mariadb-client && rm -rf /var/lib/apt/lists/*

# تفعيل موديل Rewrite الخاص بـ Apache
RUN a2enmod rewrite

# تثبيت الإضافات الخاصة بقاعدة البيانات لـ PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# تغيير مسار الـ DocumentRoot الخاص بـ Apache لكي يقرأ من مجلد public مباشرة
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ ملفات المشروع بالكامل إلى داخل الحاوية
COPY . /var/www/html/

# إعطاء الصلاحيات المناسبة للملفات والمجلدات
RUN chown -R www-data:www-data /var/www/html

# فتح المنفذ 80
EXPOSE 80

# إنشاء سكربت تشغيل تلقائي لتشغيل قاعدة البيانات واستيراد الجداول وتشغيل سيرفر Apache
RUN echo '#!/bin/bash\n\
service mariadb start\n\
mysql -e "CREATE DATABASE IF NOT EXISTS emc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"\n\
mysql emc_db < /var/www/html/database.sql\n\
apache2-foreground' > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# أمر تشغيل الحاوية عبر السكربت الذكي
CMD ["/usr/local/bin/start.sh"]