# Lumen CRM — واجهة استخدام احترافية

> طبقة واجهة استخدام بجودة **Stripe / Linear** لتطبيقات CRM في Laravel.
> مبني بـ **Blade + Tailwind CSS**، يدعم **العربية والإنجليزية** مع RTL كامل، بدون أي تعديل على الـ Backend.

---

## ✨ المميزات

- 🎨 **نظام تصميم حديث** — خط Inter + IBM Plex Sans Arabic، ألوان متناسقة، ظلال ناعمة
- 🌐 **ثنائي اللغة** — عربي (RTL) + إنجليزي (LTR) مع زر تبديل فوري
- 📊 **6 صفحات كاملة** — لوحة التحكم، الفرص (Kanban + جدول)، تفاصيل الفرصة، المتابعات، العملاء، التقارير
- 🧩 **15+ مكون Blade قابل للإعادة**
- 🎯 **Kanban بسحب وإفلات** — HTML5 أصلي بدون مكتبات خارجية
- ⌨️ **اختصارات لوحة المفاتيح** — ⌘K للبحث
- ♿ **يدعم إمكانية الوصول** — ARIA، تنقل بلوحة المفاتيح
- 🚀 **Vite + Tailwind** — جاهز للإنتاج

---

## 🚀 التثبيت السريع

### المتطلبات

- مشروع Laravel 10+
- Node.js 18+
- PHP 8.1+

### الخطوات

**1. انسخ الملفات إلى مشروعك:**

```bash
cp -r path/to/lumen-crm/resources/views/*       resources/views/
cp -r path/to/lumen-crm/resources/css/app.css   resources/css/
cp -r path/to/lumen-crm/resources/js/app.js     resources/js/
cp    path/to/lumen-crm/tailwind.config.js      ./
cp -r path/to/lumen-crm/lang                    ./
cp    path/to/lumen-crm/app/Http/Middleware/SetLocale.php  app/Http/Middleware/
```

**2. ثبّت الحزم:**

```bash
npm install -D tailwindcss @tailwindcss/forms postcss autoprefixer
```

**3. سجّل الـ Middleware في `app/Http/Kernel.php`:**

```php
protected $middlewareGroups = [
    'web' => [
        // ... الـ middleware الموجود ...
        \App\Http\Middleware\SetLocale::class,
    ],
];
```

**4. أضف اللغات المدعومة في `config/app.php`:**

```php
'supported_locales' => [
    'en' => ['name' => 'English', 'native' => 'English', 'dir' => 'ltr'],
    'ar' => ['name' => 'Arabic',  'native' => 'العربية', 'dir' => 'rtl'],
],
```

**5. أضف route تبديل اللغة في `routes/web.php`:**

```php
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, array_keys(config('app.supported_locales', [])))) {
        session(['locale' => $locale]);
    }
    return back();
})->name('locale.switch');
```

**6. ابنِ الأصول:**

```bash
npm run dev      # وضع التطوير
npm run build    # وضع الإنتاج
```

---

## 🌐 إضافة ترجمات جديدة

افتح `lang/ar.json` وأضف زوج مفتاح/قيمة:

```json
{
    "Save": "حفظ",
    "My new string": "نصي الجديد"
}
```

ثم استخدم في أي Blade:

```blade
<button>{{ __('My new string') }}</button>
```

---

## 📂 هيكل المشروع

```
lumen-crm/
├── app/Http/Middleware/SetLocale.php
├── config/app.locales.snippet.php
├── lang/
│   ├── ar.json                     ← 150+ ترجمة
│   └── en.json
├── resources/
│   ├── css/app.css                 ← Tailwind + إصلاحات RTL
│   ├── js/app.js                   ← Modals, Kanban, ⌘K
│   └── views/
│       ├── layouts/app.blade.php   ← الهيكل الرئيسي
│       ├── partials/
│       ├── components/             ← 15 مكون
│       └── pages/                  ← 6 صفحات
├── routes/web.locale.snippet.php
├── tailwind.config.js
├── vite.config.js
└── package.json
```

---

## 📄 الترخيص

MIT — راجع ملف [LICENSE](LICENSE).

---

## 🙏 شكر

- خط [Inter](https://rsms.me/inter/) — Rasmus Andersson
- خط [IBM Plex Sans Arabic](https://www.ibm.com/plex/) — IBM
- التصميم مستوحى من Stripe و Linear و Notion
