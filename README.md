# Course Management System

A university course catalogue. Visitors can browse subject areas, search courses, and send enquiries. Staff manage the catalogue. Superadmins manage staff accounts.

The site runs in Docker: nginx, PHP-FPM, and MariaDB. Pages are served from `https://v.je`.

## Requirements

- Docker with Docker Compose
- These names in your hosts file, pointing at `127.0.0.1`:

```
127.0.0.1 v.je www.v.je mail.v.je
```

On macOS and Linux that file is `/etc/hosts`.

## Run

From this directory:

```bash
docker compose up --build
```

Open [https://v.je](https://v.je). The `updatecerts` service creates a local certificate, so the browser will warn on the first visit until you trust it.

| Service | Address |
| --- | --- |
| Website | https://v.je |
| MariaDB | `127.0.0.1:3306` |
| Mail catcher | https://mail.v.je |

Stop the stack with `docker compose down`. Database files stay in the `mysqldata` volume. `docker compose down -v` removes that volume and the local certificates.

The `databaseimportexport` service loads `websites/database.sql` into MariaDB. The application database is `CSY2089-AS1`.

## Sign in

Seeded superadmin account:

- Username: `master3`
- Password: `master3`

Login: [https://v.je/index.php?destination=admin&action=login](https://v.je/index.php?destination=admin&action=login)

Two roles are stored on `users.role`:

- `user` is a staff account. It can manage subject areas, courses, modules, and enquiries.
- `superadmin` can do that, and can also create accounts and delete accounts that are not superadmins.

Passwords are stored with `password_hash`.

## What you can do

**Anyone**

- Browse subject areas. Each subject page lists its courses, 10 per page.
- Open a course and see its modules (code, title, and description).
- Search by subject area, type (`BSc`, `MSc`, `PhD`), duration, and part-time availability. Any combination of those filters works.
- Submit an enquiry without an account.

**Staff** (`user` or `superadmin`)

- Add, rename, and delete subject areas.
- Add, edit, and delete courses. A course has a title, type, length in years, description, subject area, and a part-time flag.
- Add, edit, and delete modules on a course.
- Read enquiries and mark one as responded. The logged-in username is stored as the person who responded.

**Superadmin**

- Create a `user` or `superadmin` account.
- Delete accounts other than superadmin accounts.

## Routes

`websites/default/public/index.php` reads `destination` and `action` from the query string and calls that method on the matching controller. The default destination is `home`. The default action is `list`.

| Destination | Actions | Controller |
| --- | --- | --- |
| `admin` | `login`, `logout`, `dashboard`, `add`, `staffList`, `delete` | `AdminController` |
| `subject` | `list`, `show`, `edit`, `delete` | `SubjectAreaController` |
| `course` | `list`, `search`, `edit`, `delete` | `CourseController` |
| `module` | `edit`, `delete` | `ModuleController` |
| `enquiry` | `list`, `manage`, `complete` | `EnquiryController` |

Examples:

- Subject list: `index.php?destination=subject&action=list`
- One subject: `index.php?destination=subject&action=show&id=10`
- Course search: `index.php?destination=course&action=search`
- Enquiry form: `index.php?destination=enquiry`

## Layout

```
.
├── docker-compose.yml
├── PHP.Dockerfile          # PHP-FPM, PDO MySQL, Xdebug, sendmail to Maildev
├── nginx.conf              # HTTPS for v.je, document root /websites/default/public
└── websites/
    ├── database.sql        # CSY2089-AS1 dump, including sample courses and users
    └── default/
        ├── classes/        # controllers, DatabaseTable, database connection
        ├── LayoutFiles/    # shared layout and navigation
        ├── pageTemplates/  # page HTML
        └── public/         # nginx document root (index.php, CSS, images)
```

Inside the containers, `./websites` is mounted at `/websites`. PHP includes use those absolute paths.

The application connects with PDO in `websites/default/classes/DatabaseConnection.php`:

- Host: `mysql`
- Database: `CSY2089-AS1`
- User: `student`
- Password: `student`

MariaDB’s root and `v.je` accounts, set in `docker-compose.yml`, both use the password `v.je`.

`websites/default/public` is listed in `.gitignore`. The site needs that directory: `index.php` is the front controller, and the layout loads `/uon.css`, `/logo.jpg`, and `/uni.jpg` from it.

## Data

| Table | Holds |
| --- | --- |
| `subjectAreas` | Subject names shown in the menu |
| `courses` | Title, description, duration, type, subject, part-time flag (`Y` or `N`) |
| `modules` | Module code, name, and description for a course |
| `enquires` | Contact details, course name, message, response status, and who responded |
| `users` | Username, password hash, and role |
