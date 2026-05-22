<?php
/** @var \Exception $exception */
$code = isset($exception) ? ($exception->getCode() ?: 500) : 500;
$code = is_numeric($code) && $code >= 100 && $code < 600 ? (int)$code : 500;
$message = isset($exception) ? htmlspecialchars($exception->getMessage()) : 'حدث خطأ غير متوقع';
$titles = [
    400 => 'طلب غير صالح',
    403 => 'غير مصرح',
    404 => 'الصفحة غير موجودة',
    500 => 'خطأ في الخادم',
];
$title = $titles[$code] ?? 'خطأ';
?>
<div class="d-flex flex-column align-items-center justify-content-center py-5 text-center">
    <div class="mb-4">
        <i class="fas fa-exclamation-triangle text-danger" style="font-size:5rem;"></i>
    </div>
    <h1 class="display-1 fw-bold text-danger"><?php echo $code; ?></h1>
    <h2 class="mb-3"><?php echo $title; ?></h2>
    <p class="text-muted fs-5 mb-4"><?php echo $message; ?></p>
    <a href="/" class="btn btn-primary px-5 py-2">
        <i class="fas fa-home me-2"></i> العودة إلى الرئيسية
    </a>
</div>
