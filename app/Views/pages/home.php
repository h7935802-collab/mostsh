<div class="row">
    <div class="col-12">
        <h1 class="mb-4 fw-bold">مرحباً بك، <?php echo \App\Core\Application::$app->user->full_name ?? ''; ?></h1>
        <p class="lead text-muted">لوحة التحكم التفاعلية لمركز الطوارئ الطبي.</p>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3 shadow-sm border-0 rounded-4">
            <div class="card-header border-0 fs-5">حالات الطوارئ النشطة</div>
            <div class="card-body">
                <h2 class="card-title display-4 fw-bold"><?php echo $active_cases ?? 0; ?> حالة</h2>
                <p class="card-text">جميع الحالات التي لم يتم تخريجها بعد.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning mb-3 shadow-sm border-0 rounded-4 text-dark">
            <div class="card-header border-0 fs-5">في قسم الفرز (Triage)</div>
            <div class="card-body">
                <h2 class="card-title display-4 fw-bold"><?php echo $triage_cases ?? 0; ?> مريض</h2>
                <p class="card-text">في انتظار التقييم الحيوي في الفرز.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow-sm border-0 rounded-4">
            <div class="card-header border-0 fs-5">أسرّة متاحة</div>
            <div class="card-body">
                <h2 class="card-title display-4 fw-bold"><?php echo $available_beds ?? 15; ?> سرير</h2>
                <p class="card-text">جاهزة لاستقبال مرضى في العناية.</p>
            </div>
        </div>
    </div>
</div>

<?php if (\App\Core\Application::$app->user->role === 'admin'): ?>
<!-- ───────────── قسم خاص بالمدير ───────────── -->
<div class="row mt-5">
    <div class="col-12 mb-3">
        <h4 class="fw-bold" style="color: var(--primary-color);"><i class="fas fa-user-shield me-2"></i>لوحة تحكم المدير</h4>
        <hr style="border-color: var(--primary-color); opacity: 0.2;">
    </div>

    <!-- بطاقة إدارة الموظفين والأطباء -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="/users" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #0d47a1, #1976d2);">
                <div class="card-body text-white d-flex flex-column align-items-center justify-content-center text-center py-4">
                    <div class="mb-3" style="width:64px; height:64px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-1">إدارة الموظفين والأطباء</h5>
                    <p class="small mb-0 opacity-75">عرض وإدارة كوادر العمل الطبي</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <span class="text-white small"><i class="fas fa-arrow-left me-1"></i>الدخول للإدارة</span>
                </div>
            </div>
        </a>
    </div>

    <!-- بطاقة إعدادات المركز الطبي -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="/settings" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #00796b, #009688);">
                <div class="card-body text-white d-flex flex-column align-items-center justify-content-center text-center py-4">
                    <div class="mb-3" style="width:64px; height:64px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-hospital-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-1">إعدادات المركز الطبي</h5>
                    <p class="small mb-0 opacity-75">تعديل بيانات وإعدادات المنشأة</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <span class="text-white small"><i class="fas fa-arrow-left me-1"></i>الدخول للإعدادات</span>
                </div>
            </div>
        </a>
    </div>

    <!-- بطاقة النظام المالي والفواتير -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="/invoices" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #e65100, #ff9800);">
                <div class="card-body text-white d-flex flex-column align-items-center justify-content-center text-center py-4">
                    <div class="mb-3" style="width:64px; height:64px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-1">النظام المالي والفواتير</h5>
                    <p class="small mb-0 opacity-75">إدارة الفواتير والحسابات المالية</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <span class="text-white small"><i class="fas fa-arrow-left me-1"></i>الدخول للحسابات</span>
                </div>
            </div>
        </a>
    </div>

    <!-- بطاقة عدد الزيارات الكلية -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #4a148c, #7b1fa2);">
            <div class="card-body text-white d-flex flex-column align-items-center justify-content-center text-center py-4">
                <div class="mb-3" style="width:64px; height:64px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h5 class="fw-bold mb-1">إجمالي الزيارات</h5>
                <h2 class="display-5 fw-bold mb-0"><?php echo $total_visits ?? 0; ?></h2>
                <p class="small mb-0 opacity-75 mt-1">زيارة مسجلة في النظام</p>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>
