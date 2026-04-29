# Lumen CRM — UI/UX Layer

> A modern, **Stripe/Linear-quality** UI/UX for Laravel CRM applications.
> Pure **Blade + Tailwind CSS**, fully bilingual (English + Arabic with RTL support), no backend changes required.

[![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind](https://img.shields.io/badge/Tailwind-3.4-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

---

## ✨ Features

- 🎨 **Modern design system** — Inter + IBM Plex Sans Arabic, custom ink/brand color scales, refined shadows
- 🌐 **Bilingual** — English (LTR) + Arabic (RTL) with runtime switcher
- 📊 **5 polished pages** — Dashboard, Leads (Kanban + Table), Lead detail, Follow-ups, Clients, Reports
- 🧩 **15+ Blade components** — Reusable, well-named, documented
- 🎯 **Drag & drop Kanban** — Native HTML5, no external library
- ⌨️ **Keyboard shortcuts** — ⌘K for search
- ♿ **Accessible** — ARIA labels, keyboard nav, focus rings
- 🚀 **Vite + Tailwind** — Production-ready build pipeline

---

## 📸 Preview

Open [`lumen-crm-preview.html`](lumen-crm-preview.html) in your browser for a live, single-file demo with the language switcher.

---

## 📦 What's inside

```
lumen-crm/
├── app/Http/Middleware/
│   └── SetLocale.php              # Detects locale from query/session/user
├── config/
│   └── app.locales.snippet.php    # Snippet to merge into config/app.php
├── lang/
│   ├── ar.json                    # ~150 Arabic translations
│   └── en.json                    # English defaults
├── resources/
│   ├── css/app.css                # Tailwind + RTL fixes + custom utilities
│   ├── js/app.js                  # Modals, Kanban DnD, ⌘K, lang switcher
│   └── views/
│       ├── layouts/app.blade.php  # Main shell (dynamic dir/lang)
│       ├── partials/
│       │   ├── sidebar.blade.php
│       │   └── topbar.blade.php
│       ├── components/            # 15 reusable components
│       └── pages/                 # 6 fully-built pages
├── routes/
│   └── web.locale.snippet.php     # Snippet for /locale/{locale} route
├── tailwind.config.js
├── vite.config.js
├── postcss.config.js
├── package.json
└── README.md
```

---

## 🚀 Installation

### Prerequisites

- Laravel 10+ project
- Node.js 18+
- PHP 8.1+

### Step 1: Copy files into your Laravel app

```bash
# From your Laravel project root:
cp -r path/to/lumen-crm/resources/views/*       resources/views/
cp -r path/to/lumen-crm/resources/css/app.css   resources/css/
cp -r path/to/lumen-crm/resources/js/app.js     resources/js/
cp    path/to/lumen-crm/tailwind.config.js      ./
cp -r path/to/lumen-crm/lang                    ./
cp    path/to/lumen-crm/app/Http/Middleware/SetLocale.php  app/Http/Middleware/
```

### Step 2: Install dependencies

```bash
npm install -D tailwindcss @tailwindcss/forms postcss autoprefixer
```

### Step 3: Register the locale middleware

In `app/Http/Kernel.php`, add to the `web` middleware group:

```php
protected $middlewareGroups = [
    'web' => [
        // ... existing middleware ...
        \App\Http\Middleware\SetLocale::class,
    ],
];
```

### Step 4: Add `supported_locales` to `config/app.php`

```php
'supported_locales' => [
    'en' => ['name' => 'English', 'native' => 'English', 'dir' => 'ltr'],
    'ar' => ['name' => 'Arabic',  'native' => 'العربية', 'dir' => 'rtl'],
],
```

### Step 5: Add the language switcher route to `routes/web.php`

```php
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, array_keys(config('app.supported_locales', [])))) {
        session(['locale' => $locale]);
        if (auth()->check() && \Schema::hasColumn('users', 'locale')) {
            auth()->user()->update(['locale' => $locale]);
        }
    }
    return back();
})->name('locale.switch');
```

### Step 6: (Optional) Persist user preference

Create a migration to add a `locale` column:

```bash
php artisan make:migration add_locale_to_users_table
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('locale', 5)->default('en')->after('email');
});
```

### Step 7: Build assets

```bash
npm run dev      # Development with hot reload
npm run build    # Production build
```

---

## 🌐 Bilingual support

### How translations work

In any Blade file, use `__()` with the **English string as the key**:

```blade
<button>{{ __('New lead') }}</button>
{{-- Renders "New lead" in English, "فرصة جديدة" in Arabic --}}
```

With parameters:

```blade
{{ __('You have :count leads', ['count' => $count]) }}
```

### Adding new translations

1. Open `lang/ar.json`
2. Add: `"My new string": "نصي الجديد"`
3. Use in Blade: `{{ __('My new string') }}`

If a key is missing, Laravel falls back to the key itself.

### What flips in RTL

✅ **Auto-flips:**
- Sidebar (left → right)
- Margins via logical properties (`ms-`, `me-`, `ps-`, `pe-`)
- Directional icons (chevrons, arrows, logout) via `data-flip-rtl`
- Border accents on cards (`border-l-2` → `border-r-2`)
- Kanban column flow

❌ **Stays LTR (intentionally):**
- SVG line charts and data visualizations (`.chart-ltr`)
- Code blocks and monospace text
- Phone numbers and email addresses (`.force-ltr`)
- Numbers with `.num` class (tabular-nums)

---

## 🎨 Design system

### Colors

```js
ink:   { 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950 }  // Neutrals
brand: { 50, 100, 500, 600, 700 }                                 // Primary blue
```

### Typography

- **Latin:** Inter (400, 450, 500, 550, 600, 700)
- **Arabic:** IBM Plex Sans Arabic (400, 500, 600, 700)
- **Mono:** JetBrains Mono

### Shadows

```js
'soft' → subtle elevation
'card' → cards and panels
'pop'  → modals and dropdowns
```

### Status colors

| Status | Color |
|--------|-------|
| New | Gray |
| Follow-up | Amber |
| Interested | Brand blue |
| Converted | Emerald |
| Rejected | Rose |

---

## 🧩 Component library

| Component | Purpose |
|-----------|---------|
| `<x-card>` | Content container with consistent padding/radius |
| `<x-badge>` | Color-coded labels with optional dot/pulse |
| `<x-status-badge>` | Lead/client status — auto-translated |
| `<x-button>` | Primary, secondary, ghost, success, danger variants |
| `<x-icon>` | 22+ icons, directional ones auto-flip in RTL |
| `<x-modal>` | Dialog with header/body/footer slots |
| `<x-table>` | Header + slot for rows |
| `<x-kanban-column>` | Status column with badge counter |
| `<x-lead-card>` | Lead summary card (draggable in Kanban) |
| `<x-kpi-card>` | KPI metric with trend + sparkline |
| `<x-avatar>` | User avatar with initials fallback |
| `<x-countdown>` | Localized "In 2h" / "خلال ساعتين" |
| `<x-timeline>` + `<x-timeline-item>` | Activity feed |

---

## 🛠️ Pages

### Dashboard
KPI cards, conversion-rate chart, rejection-reasons breakdown, recent activity, pipeline overview.

### Leads (Kanban / Table)
- Kanban view with drag-and-drop status changes
- Table view with sorting and filtering
- Filter bar with status, sort, agent
- Quick-add lead button

### Lead detail
Split layout: contact info + assignment on one side, activity timeline + composer on the other.

### Follow-ups
Hero card with "today's count", tabbed views (Overdue / Today / Tomorrow / This week).

### Clients
Table with status, plan, MRR, owner, since-date columns.

### Reports
Sales funnel visualization, rejection-reasons donut chart, performance overview.

---

## 🤝 Integration with existing controllers

The views expect Eloquent models and standard Laravel patterns. Example for the Leads page:

```php
// LeadController.php
public function index()
{
    return view('pages.leads.index', [
        'leads' => Lead::with('agent')->latest()->get(),
        'pipeline' => Lead::groupBy('status')->selectRaw('status, count(*) as count')->get(),
    ]);
}
```

The Blade templates use route helpers like `route('leads.index')` and `route('locale.switch')` — make sure these named routes exist.

---

## 📄 License

MIT — see [LICENSE](LICENSE) file.

---

## 🙏 Credits

- [Inter](https://rsms.me/inter/) by Rasmus Andersson
- [IBM Plex Sans Arabic](https://www.ibm.com/plex/) by IBM
- [JetBrains Mono](https://www.jetbrains.com/lp/mono/) by JetBrains
- Icon designs inspired by [Lucide](https://lucide.dev) and [Heroicons](https://heroicons.com)
- Design language inspired by Stripe, Linear, and Notion

---

<div align="center">

**Built with ❤️ for Laravel developers who care about UI**

</div>
