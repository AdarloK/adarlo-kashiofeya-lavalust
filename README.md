# Kashiofeya Student Portal — LavaLust Lab Activity

A Student Information Page built with the **LavaLust PHP framework**,
covering **routing → middleware → controller → view**, per *Laboratory
Activity 3: Routing, Controllers, Views, and Middleware*.

Design: a dark "access-control system" theme — glass panels, a glowing
blue/violet gradient field, and monospace route/log readouts that make the
routing → middleware → controller → view flow visible on the page itself.
Two panels on the home page (hero + PIN terminal) and a security-clearance
dashboard (not an ID card) on the profile page.

- `GET  /student` — access terminal (enter a PIN to unlock the profile)
- `POST /student/verify` — checks the submitted PIN
- `GET  /student/lock` — revokes access, so you can re-test the denial flow
- `GET  /student/profile` — protected by `StudentMiddleware`

---

## 1. What's inside

```
app/
  controllers/StudentController.php   -> index(), verify(), lock(), profile()
  middlewares/StudentMiddleware.php   -> guards /student/profile
  views/student_home.php              -> access terminal (PIN form)
  views/student_profile.php           -> Student Record card
  config/routes.php                   -> route -> controller/middleware map
public/index.php                      -> front controller (Apache doc root)
Dockerfile                            -> used by Render to build & run the app
```

---

## 2. How the access flow works

```
GET /student
    |
    v
Access Terminal (PIN form) --submits--> POST /student/verify
    |                                          |
    | correct PIN                              | wrong PIN
    v                                          v
session['portal_unlocked'] = true    session['portal_unlocked'] = false
    |                                          |
    v                                          v
GET /student/profile                  redirected back to /student
    |                                  with an "Incorrect PIN" message
    v
StudentMiddleware checks the flag -> allowed -> profile view
```

The default PIN is **`0050`**. To change it, open
`app/controllers/StudentController.php` and edit:

```php
private $portal_pin = '0050';
```

Visit `GET /student/lock` any time to revoke access again and re-test the
"unauthorized access redirected by StudentMiddleware" behavior.

---

## 3. Personalize your information

Open `app/controllers/StudentController.php` → `profile()` and edit the
`$student` array with your own real information:

```php
$student = [
    'student_id'  => 'MCC2024-00050',
    'name'        => 'Kashiofeya S. Adarlo',
    'course'      => 'BS Information Technology',
    'year'        => '3rd Year',
    'section'     => '3F1',
    'email'       => 'kashiofeyaa@gmail.com',

    // optional — uncomment any of these to show them on the profile card
    // 'address'     => 'City, Province, Philippines',
    // 'contact'     => '09XX-XXX-XXXX',
    // 'skills'      => 'List your own skills here',
    // 'hobbies'     => 'List your own hobbies here',
    // 'description' => 'A short one- or two-sentence bio about yourself.',
    // 'social'      => 'github.com/your-username',
];
```

The profile view only renders optional fields that are present — no need to
touch the HTML for those.

To restyle colors, edit the `:root { ... }` block at the top of
`student_home.php` / `student_profile.php` (`--bg`, `--accent`,
`--accent-2`, `--danger`, `--text`, `--muted`).

---

## 4. Run it locally

Requires PHP 7.4+ (PHP 8.x recommended).

```bash
# from the project root (the folder containing "public/")
php -S localhost:8000 -t public
```

Then open:
- http://localhost:8000/student
- http://localhost:8000/student/profile *(redirects back until you unlock it)*

If you'd rather use Laragon/XAMPP/WAMP, point the virtual host's document
root to the `public/` folder.

---

## 5. Push to GitHub (first time)

```bash
cd path/to/LavaLust
git init
git add .
git commit -m "Initial commit: Kashiofeya Student Portal"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git push -u origin main
```

---

## 6. Deploy on Render

1. Go to https://dashboard.render.com and log in.
2. **New +** → **Web Service** → **Build and deploy from a Git repository**
   → select your repo.
3. Render auto-detects the included `Dockerfile`. Confirm:
   - **Environment**: `Docker`
   - **Branch**: `main`
   - **Instance Type**: `Free` is fine
4. **Create Web Service** and wait for the status to show **Live**.
5. Test both routes on the live URL, e.g.:
   - `https://your-service-name.onrender.com/student`
   - `https://your-service-name.onrender.com/student/profile`

---

## 7. Terminal commands to update Render after a change

Render is connected to your GitHub repo and **auto-deploys on every push**
to `main`. So any time you personalize a file (info, PIN, colors, etc.),
run this from the project folder:

```bash
git add .
git commit -m "Update student info / design"
git push
```

That's it — Render detects the new commit and redeploys automatically
(watch it happen live under your service → **Events** tab in the Render
dashboard). If you ever want to trigger a rebuild without a new commit,
use the dashboard button instead:

**Render dashboard → your service → Manual Deploy → Deploy latest commit**

If `git push` is rejected with `(fetch first)`, it means the remote has
commits you don't have locally yet — run:

```bash
git pull origin main --allow-unrelated-histories
git push
```

---

## 8. Submission checklist

- [ ] Screenshot of `/student`
- [ ] Screenshot of `/student/profile`
- [ ] Screenshot showing the middleware-protected route (e.g. the
      "Locked" message, or `StudentMiddleware.php`)
- [ ] Screenshot of `app/config/routes.php`
- [ ] Screenshot of `app/controllers/StudentController.php`
- [ ] Screenshot of `app/middlewares/StudentMiddleware.php`
- [ ] Screenshot of a view file (`student_home.php` or `student_profile.php`)
- [ ] Your Render link

---

*Original LavaLust framework documentation preserved at
[`docs/FRAMEWORK.md`](docs/FRAMEWORK.md).*
