# Implementation Plan

## Tasks to Complete:

### 1. Fix Banner Image Display
**Issue**: Welcome page uses `asset($banner->image)` instead of `asset('storage/' . $banner->image)`
**Files to modify**:
- `resources/views/welcome.blade.php` - Fix image paths

### 2. Update Banner Creation Form
**Issue**: Date fields are confusing - users think they're event dates, not display dates
**Files to modify**:
- `resources/views/admin/banners/create.blade.php` - Add clear help text
- `resources/views/admin/banners/edit.blade.php` - Add clear help text

### 3. Delete Workshop System
**Files/Routes to remove**:
- Routes: `/workshops`, `/workshops/{workshop}`, `/workshops/{workshop}/register`, `/workshops/{workshop}/cancel`
- Admin routes: `/admin/workshops/*`, `/admin/workshop-registrations/*`
- Controllers: `WorkshopController.php`, `Admin/WorkshopController.php`
- Views: `resources/views/workshops/*`, `resources/views/admin/workshops/*`
- Models: Keep for data integrity but mark as deprecated
- Database: Keep tables but delete all data

### 4. Integrate Banner Applications into Dashboard
**Files to modify**:
- `resources/views/dashboard.blade.php` - Add banner applications section
- `app/Http/Controllers/JobseekerDashboardController.php` - Pass banner applications data

### 5. Update Admin Dashboard
**Files to modify**:
- `resources/views/admin/dashboard.blade.php` - Remove workshop quick action

## Best Implementation for Application Status:
Show all statuses (pending, approved, rejected) with:
- Visual indicators (icons + colors)
- Timestamp for when reviewed
- Admin feedback/notes if available
- Quick stats at the top

## Order of Implementation:
1. Fix banner image display (quick win)
2. Update banner forms with help text (quick win)
3. Delete workshop system (careful removal)
4. Integrate banner applications into dashboard (main feature)
5. Clean up admin dashboard
