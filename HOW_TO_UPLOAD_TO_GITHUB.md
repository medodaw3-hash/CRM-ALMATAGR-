# دليل رفع المشروع على GitHub

ملف سريع يشرح كيفية رفع هذا المشروع على GitHub خطوة بخطوة.

---

## ✅ الطريقة الأولى — عبر الموقع (الأسهل)

### 1. أنشئ مستودع جديد

- ادخل على [github.com/new](https://github.com/new)
- اسم المستودع: `lumen-crm` (أو أي اسم تختاره)
- الوصف: `Modern Laravel CRM UI with Arabic/English support`
- اختر **Public** أو **Private**
- ❌ **لا تختر** "Initialize with README" (سنرفع README جاهز)
- اضغط **Create repository**

### 2. ارفع الملفات

في صفحة المستودع الفارغ، اضغط **"uploading an existing file"** ثم:

- اسحب وأفلت **كل محتويات** مجلد `lumen-crm` (وليس المجلد نفسه)
- في خانة Commit: اكتب `Initial commit`
- اضغط **Commit changes**

تم! المشروع الآن على GitHub.

---

## 💻 الطريقة الثانية — عبر سطر الأوامر

إذا كان لديك Git مثبت:

```bash
# 1. ادخل إلى مجلد المشروع
cd path/to/lumen-crm

# 2. هيّئ Git
git init
git add .
git commit -m "Initial commit"

# 3. اربط المستودع البعيد (استبدل USERNAME باسمك)
git branch -M main
git remote add origin https://github.com/USERNAME/lumen-crm.git

# 4. ارفع
git push -u origin main
```

---

## 🔐 إذا طلب منك تسجيل الدخول

GitHub لم يعد يدعم كلمة المرور في سطر الأوامر. تحتاج **Personal Access Token**:

1. ادخل [github.com/settings/tokens](https://github.com/settings/tokens)
2. اضغط **Generate new token (classic)**
3. اختر صلاحيات `repo`
4. انسخ الـ Token
5. عند `git push`، استخدم الـ Token بدل كلمة المرور

أو الأسهل — استخدم [GitHub Desktop](https://desktop.github.com/) (واجهة رسومية).

---

## 📝 نصائح

### لتحديث المشروع لاحقاً:

```bash
git add .
git commit -m "وصف التحديث"
git push
```

### لإضافة ميزة "Topics" لزيادة الظهور:

في صفحة المستودع، اضغط على ⚙️ بجانب "About" وأضف topics مثل:
- `laravel`
- `tailwindcss`
- `crm`
- `arabic`
- `rtl`
- `blade`

### لتفعيل GitHub Pages لعرض المعاينة مباشرة:

1. ادخل **Settings → Pages**
2. اختر Branch: `main` و Folder: `/ (root)`
3. احفظ
4. سيكون رابط المعاينة:
   `https://USERNAME.github.io/lumen-crm/lumen-crm-preview.html`

---

## ❓ مشاكل شائعة

**❌ "fatal: refusing to merge unrelated histories"**
```bash
git pull origin main --allow-unrelated-histories
```

**❌ "remote: Permission denied"**
- تأكد من اسم المستخدم الصحيح في الرابط
- تأكد من Personal Access Token

**❌ ملفات حساسة لا يجب رفعها**
ملف `.gitignore` الموجود يحجب تلقائياً:
- `.env` (إذا أضفته لاحقاً)
- `node_modules/`
- `vendor/`
- ملفات IDE
