<?php
// lang/ar/crm.php
//
// الترجمة العربية. كل المفاتيح تطابق lang/en/crm.php
// مهم: الـ keys تبقى بالإنجليزية، فقط القيم تتغيّر.

return [

    /* ----------------------------------------
     | اسم النظام والشعار
     ---------------------------------------- */
    'app' => [
        'name'      => 'لومن',
        'tagline'   => 'نظام إدارة المبيعات',
    ],

    /* ----------------------------------------
     | القائمة الجانبية
     ---------------------------------------- */
    'nav' => [
        'workspace'       => 'مساحة العمل',
        'account'         => 'الحساب',
        'dashboard'       => 'الرئيسية',
        'leads'           => 'العملاء المحتملون',
        'followups'       => 'المتابعات',
        'clients'         => 'العملاء',
        'reports'         => 'التقارير',
        'settings'        => 'الإعدادات',
        'sales_workspace' => 'مساحة المبيعات',
        'sign_out'        => 'تسجيل الخروج',
    ],

    /* ----------------------------------------
     | الشريط العلوي
     ---------------------------------------- */
    'topbar' => [
        'search_placeholder' => 'ابحث في العملاء، التقارير…',
        'notifications'      => 'التنبيهات',
        'new_lead'           => 'عميل جديد',
    ],

    /* ----------------------------------------
     | حالات العميل المحتمل
     ---------------------------------------- */
    'status' => [
        'new'        => 'جديد',
        'followup'   => 'متابعة',
        'interested' => 'مهتم',
        'converted'  => 'تم التحويل',
        'rejected'   => 'مرفوض',
        'active'     => 'نشط',
        'atrisk'     => 'في خطر',
        'churned'    => 'منسحب',
        'hot'        => 'ساخن',
        'won'        => 'ناجح',
        'lost'       => 'خاسر',
        'done'       => 'منجز',
    ],

    /* ----------------------------------------
     | الصفحة الرئيسية
     ---------------------------------------- */
    'dashboard' => [
        'greeting_morning'   => 'صباح الخير، :name',
        'greeting_afternoon' => 'مساء الخير، :name',
        'greeting_evening'   => 'مساء الخير، :name',
        'subtitle'           => 'هذا ما يحدث في خط مبيعاتك اليوم.',
        'kpi_leads_today'    => 'عملاء جدد اليوم',
        'kpi_followups_today'=> 'متابعات اليوم',
        'kpi_converted'      => 'عملاء محوّلون',
        'kpi_rejected'       => 'عملاء مرفوضون',
        'overdue_count'      => ':count متأخر',
        'done_progress'      => ':done من :total منجز',
        'total_value'        => 'إجمالي القيمة',
        'top_reason'         => 'أكثر سبب: :reason',
        'conversion_rate'    => 'معدل التحويل',
        'conversion_subtitle'=> 'تحويل العملاء خلال آخر ١٢ أسبوعًا',
        'this_period'        => 'الفترة الحالية',
        'previous'           => 'السابقة',
        'rejection_reasons'  => 'أسباب الرفض',
        'rejection_subtitle' => 'لماذا لم تُغلق الصفقات',
        'recent_activity'    => 'النشاط الأخير',
        'view_all'           => 'عرض الكل',
        'pipeline'           => 'خط المبيعات',
        'leads_count'        => ':count عميل',
    ],

    /* ----------------------------------------
     | العملاء المحتملون
     ---------------------------------------- */
    'leads' => [
        'title'           => 'العملاء المحتملون',
        'subtitle'        => ':total عميل في خط المبيعات · :closed تم إغلاقه هذا الشهر',
        'export'          => 'تصدير',
        'kanban'          => 'لوحة',
        'table'           => 'جدول',
        'filter'          => 'تصفية',
        'sort_by'         => 'الترتيب: :field',
        'sort_last_contact' => 'آخر تواصل',
        'agent'           => 'الموظف: :name',
        'agent_all'       => 'الكل',
        'search'          => 'ابحث في العملاء',
        'add_lead'        => 'إضافة عميل',
        'no_results'      => 'لا يوجد عملاء يطابقون التصفية.',
        'unassigned'      => 'غير مُعيَّن',

        // أعمدة الجدول
        'col_store'       => 'المتجر',
        'col_phone'       => 'الهاتف',
        'col_status'      => 'الحالة',
        'col_last_contact'=> 'آخر تواصل',
        'col_next_followup' => 'المتابعة القادمة',
        'col_agent'       => 'الموظف',

        // بطاقة العميل
        'last'            => 'آخر',
        'no_followup'     => 'لا توجد متابعة',

        // صفحة التفاصيل
        'breadcrumb'      => 'العملاء المحتملون',
        'mark_contacted'  => 'تم التواصل',
        'schedule_followup' => 'جدولة متابعة',
        'convert_to_client' => 'تحويل إلى عميل',
        'reject'          => 'رفض',
        'created_on'      => '#L-:id · أُنشئ في :date',
        'contact_info'    => 'معلومات التواصل',
        'owner'           => 'المالك',
        'phone'           => 'الهاتف',
        'email'           => 'البريد الإلكتروني',
        'city'            => 'المدينة',
        'branches'        => 'الفروع',
        'deal_value'      => 'قيمة الصفقة',
        'assignment'      => 'التعيين',
        'reassign'        => 'إعادة تعيين',
        'assign_agent'    => 'تعيين موظف',
        'tags'            => 'الوسوم',
        'add_tag'         => 'إضافة',
        'activity'        => 'النشاط',
        'all'             => 'الكل',
        'calls'           => 'المكالمات',
        'notes'           => 'الملاحظات',
        'newest_first'    => 'الأحدث أولًا',
        'composer_note'   => 'ملاحظة',
        'composer_call'   => 'مكالمة',
        'composer_email'  => 'بريد',
        'composer_schedule' => 'جدولة',
        'composer_placeholder' => 'أضف ملاحظة عن هذا العميل…',
        'post'            => 'نشر',
        'lead_created'    => 'تم إنشاء العميل',
        'imported_via'    => 'تم استيراده عبر :source.',
        'imported'        => 'تم استيراده.',
    ],

    /* ----------------------------------------
     | المتابعات
     ---------------------------------------- */
    'followups' => [
        'title'           => 'المتابعات',
        'today_label'     => 'اليوم، :date',
        'hero_count'      => 'لديك :count :leads للمتابعة اليوم',
        'lead_singular'   => 'عميل',
        'lead_plural'     => 'عملاء',
        'hero_message_overdue' => 'حافظ على إيقاعك. :count متأخر — ابدأ بهم لإبقاء الصفقات حية.',
        'hero_message_clear'   => 'حافظ على إيقاعك. أنجزت كل شيء — عمل رائع.',
        'start_overdue'   => 'ابدأ بالمتأخر',
        'view_calendar'   => 'عرض التقويم',
        'tab_overdue'     => 'متأخر',
        'tab_today'       => 'اليوم',
        'tab_tomorrow'    => 'غدًا',
        'tab_week'        => 'هذا الأسبوع',
        'tab_completed'   => 'منجز',
        'completed_at'    => 'تم الإنجاز في :time',
        'scheduled_at'    => ':note · مجدول في :time',
        'no_note'         => 'لا توجد ملاحظة',
        'call'            => 'اتصال',
        'reschedule'      => 'إعادة جدولة',
        'empty_title'     => 'لا توجد متابعات في هذا العرض',
        'empty_subtitle'  => 'أنجزت كل شيء.',
    ],

    /* ----------------------------------------
     | العملاء
     ---------------------------------------- */
    'clients' => [
        'title'         => 'العملاء',
        'subtitle'      => ':active نشط · :churned منسحب هذا الربع',
        'export_csv'    => 'تصدير CSV',
        'add_client'    => 'إضافة عميل',
        'search'        => 'ابحث في العملاء',
        'all_status'    => 'كل الحالات',
        'all_cities'    => 'كل المدن',
        'all_plans'     => 'كل الباقات',
        'col_client'    => 'العميل',
        'col_status'    => 'الحالة',
        'col_plan'      => 'الباقة',
        'col_mrr'       => 'الإيراد الشهري',
        'col_owner'     => 'المسؤول',
        'col_since'     => 'منذ',
        'view'          => 'عرض',
        'unassigned'    => 'غير مُعيَّن',
        'no_clients'    => 'لا يوجد عملاء بعد.',
        'plan_starter'    => 'مبتدئة',
        'plan_growth'     => 'نمو',
        'plan_enterprise' => 'مؤسسات',
    ],

    /* ----------------------------------------
     | التقارير
     ---------------------------------------- */
    'reports' => [
        'title'             => 'التقارير',
        'subtitle'          => 'نظرة عامة على الأداء · :range',
        'range_7d'          => 'آخر ٧ أيام',
        'range_30d'         => 'آخر ٣٠ يومًا',
        'range_90d'         => 'آخر ٩٠ يومًا',
        'range_ytd'         => 'منذ بداية العام',
        'export_pdf'        => 'تصدير PDF',
        'conversion_rate'   => 'معدل التحويل',
        'lead_to_client'    => 'محتمل ← عميل',
        'vs_prev'           => 'مقارنة بالسابق',
        'leads_per_agent'   => 'العملاء حسب الموظف',
        'leads_per_agent_subtitle' => 'العملاء المُغلقون في الفترة المختارة',
        'sales_funnel'      => 'قمع المبيعات',
        'sales_funnel_subtitle'    => 'من عميل جديد إلى صفقة مغلقة',
        'rejection_reasons' => 'أسباب الرفض',
        'lost_deals'        => ':count صفقة خاسرة',
        'top_reason'        => 'أكثر سبب',
        'funnel_new'        => 'عملاء جدد',
        'funnel_contacted'  => 'تم التواصل',
        'funnel_interested' => 'مهتمون',
        'funnel_converted'  => 'تم تحويلهم',
    ],

    /* ----------------------------------------
     | عناصر مشتركة
     ---------------------------------------- */
    'common' => [
        'cancel'    => 'إلغاء',
        'save'      => 'حفظ',
        'edit'      => 'تعديل',
        'delete'    => 'حذف',
        'close'     => 'إغلاق',
        'previous'  => 'السابق',
        'next'      => 'التالي',
        'showing'   => 'يعرض :from–:to من :total',
        'when'      => 'متى',
        'note'      => 'ملاحظة',
        'reason'    => 'السبب',
        'select_reason' => 'اختر سببًا…',
        'optional'  => 'اختياري',
        'loading'   => 'جارٍ التحميل…',
        'language'  => 'اللغة',
    ],

    /* ----------------------------------------
     | العدّاد الزمني
     ---------------------------------------- */
    'countdown' => [
        'just_now'   => 'الآن',
        'min_ago'    => 'قبل :n د',
        'hour_ago'   => 'قبل :n س',
        'day_ago'    => 'قبل :n ي',
        'in_min'     => 'بعد :n د',
        'in_hour'    => 'بعد :n س',
        'in_day'     => 'بعد :n يوم|بعد :n أيام',
        'tomorrow'   => 'غدًا',
        'today'      => 'اليوم',
        'overdue_h'  => 'متأخر :n س',
        'overdue_d'  => 'متأخر :n ي',
        'no_date'    => '—',
    ],

    /* ----------------------------------------
     | أسباب الرفض
     ---------------------------------------- */
    'rejection_reasons' => [
        'price'       => 'السعر مرتفع',
        'budget'      => 'لا توجد ميزانية',
        'competitor'  => 'اختار منافسًا',
        'timing'      => 'وقت غير مناسب',
        'other'       => 'أخرى',
    ],
];
