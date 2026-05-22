# استخدام نسخة PHP الرسمية مدمجة مع سيرفر Apache
FROM php:8.2-apache

# تثبيت متطلبات PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && rm -rf /var/lib/apt/lists/*

# تفعيل موديل Rewrite الخاص بـ Apache
RUN a2enmod rewrite

# تثبيت الإضافات الخاصة بقاعدة البيانات لـ PHP للعمل مع PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

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

# تشغيل سيرفر Apache
CMD ["apache2-foreground"]