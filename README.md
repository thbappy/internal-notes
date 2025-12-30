# Internal Notes Module (Symfony 4.4)

## Project Overview

A simple **Internal Notes** module built with Symfony 4.4 using Doctrine ORM and Twig templates.
This module allows you to **create, view, edit, and delete notes**.

---

## Requirements

* PHP 7.2 - 7.4
* Composer
* MySQL
* Symfony 4.4
* Web server (Apache/Nginx) or PHP built-in server

---

## Installation Steps

1. **Clone the repository**

```bash
git clone https://github.com/thbappy/internal-notes.git
cd internal-notes
```

2. **Install dependencies**

```bash
composer install
```

3. **Configure Database**

Open `.env` and set your MySQL credentials:

```env
DATABASE_URL="mysql://root:password@127.0.0.1:3306/internal_notes?serverVersion=5.7"
```

Create the database and run migrations:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4. **Run the Project**

### Option 1: PHP Built-in server (recommended)

```bash
php -S 127.0.0.1:8000 -t public/
```

Open browser: `http://127.0.0.1:8000/notes`

### Option 2: Symfony Web Server Bundle (optional)

```bash
composer require symfony/web-server-bundle --dev
php bin/console server:run
```

---

## CRUD URLs

| Action      | URL                  |
| ----------- | -------------------- |
| List Notes  | `/notes`             |
| Create Note | `/notes/new`         |
| Edit Note   | `/notes/{id}/edit`   |
| Delete Note | `/notes/{id}/delete` |

---

## Project Structure

```
src/
 ├─ Controller/NoteController.php   # CRUD logic
 ├─ Entity/Note.php                 # Note model / DB table
 ├─ Form/NoteType.php               # Note create/edit form
 └─ Repository/NoteRepository.php   # Optional DB queries

templates/note/
 ├─ index.html.twig
 ├─ new.html.twig
 └─ edit.html.twig
```

## Future Improvements

* Add **User-specific notes** (after authentication)
* Add **CSRF protection** on delete
* Add **validation rules** for title/content
* Pagination for large number of notes
* Tests for controller and repository

---

## Quick Test

1. Open `/notes` → should list notes
2. Click **New Note** → create a new note
3. Click **Edit** → update note
4. Click **Delete** → remove note

Everything should work in browser.

---

## Contact

For questions, email: `tanbeerhasan7@gmail.com`
