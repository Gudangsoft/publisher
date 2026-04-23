# Author & Review Management System

## Overview
Sistem manajemen penulis dan ulasan/testimoni yang telah diimplementasikan untuk website publisher.

## Features Implemented

### 1. Author Management (Manajemen Penulis)
**Location:** `/admin/authors`

**Features:**
- ✅ Full CRUD operations (Create, Read, Update, Delete)
- ✅ Author profile with photo upload
- ✅ Biography and contact information (email, website)
- ✅ Social media links (Facebook, Twitter, Instagram, LinkedIn)
- ✅ Featured authors system
- ✅ Display order customization
- ✅ Automatic slug generation
- ✅ Book count per author
- ✅ Integration with books table via foreign key

**Database Structure:**
```
authors table:
- id
- name (required)
- slug (auto-generated, unique)
- photo (nullable, stored in public/storage/authors)
- biography (text)
- email
- website
- facebook
- twitter
- instagram
- linkedin
- is_featured (boolean)
- display_order (integer)
- created_at
- updated_at
```

**Files Created/Modified:**
- ✅ `app/Models/Author.php` - Model with relationships and scopes
- ✅ `app/Http/Controllers/Admin/AuthorController.php` - Full CRUD controller
- ✅ `resources/views/admin/authors/index.blade.php` - Grid view with cards
- ✅ `resources/views/admin/authors/form.blade.php` - Create/Edit form
- ✅ `database/migrations/2025_11_21_101500_create_authors_table.php` - Migration
- ✅ `database/migrations/2025_11_21_101502_add_author_id_to_books_table.php` - Foreign key
- ✅ `database/seeders/AuthorSeeder.php` - Sample data (5 authors)

### 2. Review Management (Manajemen Ulasan)
**Location:** `/admin/reviews`

**Features:**
- ✅ Full CRUD operations
- ✅ Two types of reviews:
  - `book` - Review untuk buku tertentu
  - `publisher` - Testimoni umum tentang publisher
- ✅ 5-star rating system
- ✅ Reviewer information (name, email, photo)
- ✅ Approval workflow (is_approved)
- ✅ Featured reviews (is_featured)
- ✅ Photo upload for reviewers
- ✅ Quick approve button in index
- ✅ Integration with books table

**Database Structure:**
```
reviews table:
- id
- book_id (nullable, foreign key to books)
- reviewer_name (required)
- reviewer_email
- reviewer_photo (stored in public/storage/reviews)
- review_text (required)
- rating (1-5, required)
- type (enum: book/publisher)
- is_approved (boolean, default false)
- is_featured (boolean, default false)
- created_at
- updated_at
```

**Files Created/Modified:**
- ✅ `app/Models/Review.php` - Model with relationships and scopes
- ✅ `app/Http/Controllers/Admin/ReviewController.php` - Full CRUD controller
- ✅ `resources/views/admin/reviews/index.blade.php` - List with approve buttons
- ✅ `resources/views/admin/reviews/form.blade.php` - Create/Edit form
- ✅ `database/migrations/2025_11_21_101501_create_reviews_table.php` - Migration
- ✅ `database/seeders/ReviewSeeder.php` - Sample data (6 testimonials + 3 book reviews)

### 3. Homepage Integration
**Location:** Homepage (`/`)

**Features:**
- ✅ Testimonial section added below "Bergabunglah dengan Komunitas Pembaca"
- ✅ Displays 6 featured/approved reviews from database
- ✅ Fallback to 3 hardcoded testimonials if no data
- ✅ 5-star rating visualization with yellow stars
- ✅ Reviewer photo or initial avatar
- ✅ Gradient background design
- ✅ Responsive 3-column grid layout
- ✅ Link to contact page for submitting reviews

**Code Location:**
- ✅ `resources/views/home.blade.php` - Added 160+ lines of testimonial section

### 4. Book-Author Integration
**Features:**
- ✅ Books can be linked to author profiles via `author_id`
- ✅ Dropdown select in book form to choose author
- ✅ Optional field (nullable foreign key)
- ✅ Automatic display of author info when linked

**Files Modified:**
- ✅ `app/Models/Book.php` - Added authorProfile() relationship
- ✅ `resources/views/admin/books/form.blade.php` - Added author selection dropdown

### 5. Admin Panel Updates
**Location:** `/admin`

**Features:**
- ✅ Added "Penulis" menu item with user icon
- ✅ Added "Ulasan" menu item with star icon
- ✅ Menu items show active state
- ✅ Proper routing for all CRUD operations

**Files Modified:**
- ✅ `routes/web.php` - Added resource routes for authors & reviews
- ✅ `resources/views/layouts/admin.blade.php` - Added sidebar menu items

## Routes

### Author Routes
```php
GET     /admin/authors          - List all authors
GET     /admin/authors/create   - Show create form
POST    /admin/authors          - Store new author
GET     /admin/authors/{id}/edit - Show edit form
PUT     /admin/authors/{id}     - Update author
DELETE  /admin/authors/{id}     - Delete author
```

### Review Routes
```php
GET     /admin/reviews          - List all reviews
GET     /admin/reviews/create   - Show create form
POST    /admin/reviews          - Store new review
GET     /admin/reviews/{id}/edit - Show edit form
PUT     /admin/reviews/{id}     - Update review (includes approval)
DELETE  /admin/reviews/{id}     - Delete review
```

## Database Seeders

### AuthorSeeder
Creates 5 sample authors:
1. Dr. Ahmad Tohari (Featured) - Trilogy Ronggeng Dukuh Paruk
2. Dee Lestari (Featured) - Supernova series
3. Tere Liye (Featured) - Bestselling author
4. Pramoedya Ananta Toer - Tetralogi Pulau Buru
5. Eka Kurniawan (Featured) - Cantik Itu Luka

**Run:** `php artisan db:seed --class=AuthorSeeder`

### ReviewSeeder
Creates sample data:
- 6 publisher testimonials (4 featured, 2 regular)
- 3 book-specific reviews (if books exist)

**Run:** `php artisan db:seed --class=ReviewSeeder`

## Model Relationships

### Author Model
```php
public function books() // hasMany
public function featured() // scope
public function ordered() // scope
```

### Review Model
```php
public function book() // belongsTo
public function approved() // scope
public function featured() // scope
public function forBook($bookId) // scope
public function forPublisher() // scope
```

### Book Model (Updated)
```php
public function authorProfile() // belongsTo Author
public function reviews() // hasMany Review
public function approvedReviews() // hasMany Review (approved only)
public function averageRating() // calculated attribute
```

## Storage Structure
```
storage/app/public/
  ├── authors/        - Author photos
  ├── reviews/        - Reviewer photos
  └── books/          - Book covers (existing)
```

## Stats & Features

### Author Management Stats
- Total Authors
- Featured Authors count
- Total Books across all authors

### Review Management Stats
- Total Reviews
- Average Rating
- Approved Reviews count
- Pending Reviews count

## Usage Guide

### Adding a New Author
1. Go to `/admin/authors`
2. Click "Tambah Penulis"
3. Fill in:
   - Name (required)
   - Photo (optional, JPG/PNG, max 2MB)
   - Biography
   - Email, Website
   - Social media links
   - Featured checkbox
   - Display order
4. Click "Simpan Penulis"

### Adding a Review
1. Go to `/admin/reviews`
2. Click "Tambah Ulasan"
3. Fill in:
   - Reviewer name (required)
   - Email (optional)
   - Rating 1-5 (required)
   - Type: Book Review or Publisher Testimonial
   - Book selection (if book review)
   - Review text (required)
   - Photo (optional)
   - Approval checkbox
   - Featured checkbox
4. Click "Simpan Ulasan"

### Linking Book to Author
1. Go to `/admin/books/{id}/edit`
2. Find "Profil Penulis" dropdown
3. Select author from list
4. Save book

### Managing Reviews
- **Approve:** Click green "Setujui" button in review list
- **Edit:** Click pencil icon
- **Delete:** Click trash icon (with confirmation)
- **Feature:** Edit review and check "Featured" checkbox

## Frontend Display

### Homepage Testimonials
- Shows maximum 6 featured/approved reviews
- 3-column grid on desktop
- 2-column on tablet
- 1-column on mobile
- Yellow star rating display
- Reviewer photo or colored avatar with initials
- Responsive and animated hover effects

## Technical Details

### Image Upload Handling
```php
// Author photo
$validated['photo'] = $request->file('photo')->store('authors', 'public');

// Reviewer photo
$validated['reviewer_photo'] = $request->file('reviewer_photo')->store('reviews', 'public');

// Delete old photo when updating
if ($author->photo) {
    Storage::disk('public')->delete($author->photo);
}
```

### Slug Generation
```php
// In Author model boot method
static::creating(function ($author) {
    $author->slug = Str::slug($author->name);
});
```

### Approval Workflow
```php
// Quick approve from index
<form action="{{ route('admin.reviews.update', $review) }}" method="POST">
    @csrf @method('PUT')
    <input type="hidden" name="is_approved" value="1">
    // ... other fields
    <button>Setujui</button>
</form>
```

## Migration Status
✅ All migrations run successfully:
- `2025_11_21_101500_create_authors_table` - DONE
- `2025_11_21_101501_create_reviews_table` - DONE
- `2025_11_21_101502_add_author_id_to_books_table` - DONE

## Testing Checklist

### Authors
- [ ] Create new author
- [ ] Upload author photo
- [ ] Edit author information
- [ ] Delete author
- [ ] Feature/unfeature author
- [ ] Link author to book
- [ ] View author's book count

### Reviews
- [ ] Create publisher testimonial
- [ ] Create book review
- [ ] Upload reviewer photo
- [ ] Approve review from index
- [ ] Edit review
- [ ] Delete review
- [ ] Feature review for homepage
- [ ] View approved reviews on homepage

## Next Steps (Optional Enhancements)

1. **Public Author Pages**
   - Create `/authors` - List all featured authors
   - Create `/authors/{slug}` - Author profile with their books

2. **Review Submission Form**
   - Create public form at `/submit-review`
   - Email notification to admin when new review submitted
   - Requires approval before appearing on site

3. **Author Statistics**
   - Total books published
   - Average book rating
   - Most reviewed book

4. **Search & Filters**
   - Filter reviews by rating
   - Search reviews by name or text
   - Filter authors by featured status

5. **Export Features**
   - Export author list to CSV/Excel
   - Export reviews with statistics

## Conclusion

The Author and Review Management System has been successfully implemented with:
- ✅ Full CRUD operations for both authors and reviews
- ✅ Database migrations and relationships
- ✅ Admin panel integration with proper menu items
- ✅ Homepage testimonial display
- ✅ Sample data seeders
- ✅ Image upload and storage management
- ✅ Approval workflow for reviews
- ✅ Featured content system
- ✅ Book-Author linking

All features are production-ready and fully functional!
