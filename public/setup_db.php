<?php
// Setup script to create DB tables
$config = require dirname(__DIR__) . '/app/Config/database.php';
$driver = $config['driver'] ?? 'pgsql';
$host = $config['host'];
$port = $config['port'];
$dbname = $config['dbname'];
$user = $config['user'];
$password = $config['password'];

echo "<h2>إعداد قاعدة البيانات تلقائياً...</h2>";

$dsn = "$driver:host=$host;port=$port;dbname=$dbname";

try {
    $conn = new \PDO($dsn, $user, $password);
    $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    echo "<p>تم الاتصال بخادم PostgreSQL بنجاح.</p>";
    
    $sqlFile = dirname(__DIR__) . '/database.sql';
    if (!file_exists($sqlFile)) {
        die("لم يتم العثور على ملف database.sql");
    }

    $queries = file_get_contents($sqlFile);
    $conn->exec($queries);
    
    echo "<h3 style='color:green;'>تم استيراد الجداول والبيانات بنجاح! 🎉</h3>";
    echo "<p>الآن يمكنك <a href='/'>العودة إلى النظام وتسجيل الدخول</a></p>";
} catch (\PDOException $e) {
    echo "<h3 style='color:red;'>حدث خطأ: " . $e->getMessage() . "</h3>";
}
