# Plan (Part 1/2)

1. Add `Modules\\` PSR-4 autoload entry in composer.json and dump-autoload.
2. Implement `app/Providers/ModulesServiceProvider` to auto-register module providers; register in `config/app.php`.
3. Create `app/Console/Kernel.php` with scheduling stub.
4. Build **Org** module:
   - Migration for `companies`, `branches`, `departments`, `titles` with safe checks.
   - Create `Company` model and link existing Branch/Department/Title models to it.
   - Add simple translations.
5. Extend **Employees** module:
   - Safe migration for `employment_statuses`, `work_statuses`, `sponsorship_statuses`, `employees` table.
   - Update `Employee` model relationships.
   - Create `HrBaseSeeder` for status tables.
   - Add `hr.employees` routes and ensure controller loads relations.
   - Insert documents list include in show view and add translation keys.
6. Build **Documents** module:
   - Migration and model with accessors/scopes.
   - Controller for store/destroy; routes under HR prefix.
   - Blade partial `documents::_list` and translations.
   - Command `hr:check-document-expiry` and notification.
7. Schedule command in Console Kernel at 09:00 Asia/Riyadh.
8. Update README with usage instructions.
9. Run `composer dump-autoload`, `php artisan migrate`, `php artisan db:seed --class=HrBaseSeeder`, `php artisan route:list`, and test command.
