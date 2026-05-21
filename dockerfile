# استخدام نسخة PHP الرسمية مدمجة مع سيرفر Apache
FROM php:8.2-apache

# تفعيل موديل Rewrite الخاص بـ Apache (مهم جداً لتوجيه الروابط في PHP)
RUN a2enmod rewrite

# تثبيت الإضافات الخاصة بقاعدة البيانات MySQL لكي يتصل الكود بها
RUN docker-php-ext-install pdo pdo_mysql mysqli

# تغيير مسار الـ DocumentRoot الخاص بـ Apache لكي يقرأ من مجلد public مباشرة
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ ملفات المشروع بالكامل إلى داخل الحاوية (Container)
COPY . /var/www/html/

# إعطاء الصلاحيات المناسبة للملفات والمجلدات
RUN chown -R www-data:www-data /var/www/html

# فتح المنفذ 80 الذي يشتغل عليه Apache تلقائياً
EXPOSE 80