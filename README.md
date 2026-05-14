# Spatie Roles & Permissions - Advanced Architecture Portfolio

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Spatie](https://img.shields.io/badge/Spatie-Permissions-7.4-blue?style=for-the-badge)](https://spatie.be/docs/laravel-permission/v6/introduction)
[![Pest](https://img.shields.io/badge/Pest-4.7-FF4B72?style=for-the-badge)](https://pestphp.com)

This project is an enterprise-grade demonstration of a Role-Based Access Control (RBAC) system combined with an Articles management module. Built on **Laravel 13**, it moves beyond simple MVC patterns to implement a robust, decoupled **Service-Repository Architecture**.

This repository is designed to showcase senior-level backend development practices, focusing on maintainability, dependency injection, and clean code.

---

## 🏗️ Architectural Deep Dive

To ensure the codebase scales effectively and remains testable, the logic is highly decoupled:

### 1. The Service-Repository Pattern
- **Repositories (`app/Repositories`):** Data access is abstracted away from Eloquent via strict interfaces (`ArticleRepositoryInterface`, `UserRepositoryInterface`, etc.). This means the underlying database logic can be swapped or mocked without affecting the rest of the app.
- **Services (`app/Services`):** Controllers do not contain business logic. Instead, `PermissionService`, `RoleService`, `UserService`, and `ArticleService` handle all core logic (e.g., password hashing, syncing roles/permissions, orchestrating data).

### 2. Dependency Injection (`DiServiceProvider`)
All Repositories are bound to their respective Interfaces within `app/Providers/DiServiceProvider.php`. The Application Container injects these dependencies seamlessly into the Service layer.

### 3. Dedicated Validation Layer
Controllers are kept entirely free of validation rules. All incoming data is rigorously validated through 8 dedicated **Form Requests** in `app/Http/Requests` (e.g., `StoreArticleRequest`, `UpdateUserRequest`, `ProfileUpdateRequest`).

### 4. Security & Access Control
- Middleware enforces Spatie permissions at the Controller level using the modern `HasMiddleware` interface (e.g., `new Middleware('permission:edit articles', only: ['edit'])`).
- User input is manually sanitized via a custom helper class (`App\Helpers\Input::filter()`) to prevent injection attacks before data reaches the service layer.
- Email verification automatically resets when a user changes their email address in the `UserService`.

---

## 🗂️ Core Modules

1. **User Management:** Complete CRUD, assigning Roles to Users, and Profile updating.
2. **Role Management:** Creating roles and syncing them with multiple specific permissions.
3. **Permission Management:** Managing granular system permissions (e.g., `view articles`, `edit users`).
4. **Article Management:** A content module acting as the protected resource, requiring specific permissions to view, create, edit, or delete articles.

---

## 🛠️ Tech Stack & Dependencies

- **Core:** PHP 8.3+, Laravel Framework 13.x
- **Authentication:** Laravel Breeze (Session-based)
- **Authorization:** `spatie/laravel-permission` (^7.4)
- **Frontend Assets:** Vite, Tailwind CSS 3, Alpine.js
- **Testing:** Pest PHP (^4.7)

---

## 🚀 Getting Started

### 1. Clone & Install
```bash
git clone https://github.com/your-username/spatie-roles-permissions.git
cd spatie-roles-permissions

composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```
*Configure your database credentials in the newly created `.env` file. The project supports MySQL, PostgreSQL, or SQLite.*

### 3. Migrations & Seeders
The project includes fully configured seeders to populate initial roles, permissions, and an admin user.
```bash
php artisan migrate --seed
```
*(Runs `DatabaseSeeder`, `PermissionSeeder`, `RoleSeeder`, and `UserSeeder`)*

### 4. Build Assets & Serve
```bash
npm run build
php artisan serve
```

---

## 🧪 Testing

The project is configured with **Pest PHP** for elegant testing syntax.
```bash
php artisan test
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
