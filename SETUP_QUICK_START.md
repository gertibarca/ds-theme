# DS Theme - Modern Movies Page - Quick Setup

## ✨ What's New

Your WordPress Movies page now has:
1. **Hero Section** with full-width video background & gradient overlay
2. **Video Trailers** that play on hover (1.5s delay)
3. **Glassmorphism UI** with modern dark theme & blur effects
4. **Interactive Movie Cards** with badges, ratings, & quick action buttons
5. **Infinite Scroll** - Load more movies automatically as you scroll
6. **Live Search** - Real-time search with thumbnail previews

---

## 🚀 Quick Start (3 Steps)

### Step 1️⃣: Add Hero Video
Place a video file at: `/wp-content/themes/ds-theme/videos/hero-montage.mp4`
- Format: MP4, 1920x1080+, MUTED, ~3-5 min loop

### Step 2️⃣: Fill Movie Custom Fields
In WordPress Admin → Movies → Edit Movie:
- **IMDb Rating:** e.g., `8.5`
- **Trailer Video URL:** Direct MP4 link (not YouTube)
- **Badge Text:** e.g., `Trending` or `4K Ultra HD`

### Step 3️⃣: Add Genres
In WordPress Admin → Movies → Genres:
- Create 5-8 genres (they'll appear as filter buttons)
- Assign genres to movies

---

## 📁 New Files

| File | Purpose |
|------|---------|
| `page-movies.php` | Movies page template with hero & cards |
| `css/movies-page.css` | All styling (glassmorphism, animations) |
| `js/movies-page.js` | Trailer hover, infinite scroll, live search |
| `videos/` | Folder for hero video montage |

---

## 🎮 Features Explained

### Video Trailers on Hover
- Hover over movie poster
- After 1.5 seconds, poster fades → trailer plays
- Mouse leaves → back to poster
- Click "▶" button to force play

### Infinite Scroll
- Scroll to bottom of page
- "Load More" button appears
- Auto-loads when 80% scrolled down
- Shows 12 movies per batch

### Live Search
- Type in search bar (min. 2 characters)
- Dropdown shows results with thumbnails
- Click result to go to movie page

### Filter by Genre
- Click genre buttons at top
- Grid auto-filters to selected genre
- All genres = show all movies

---

## 🎨 Customization Cheat Sheet

### Change Primary Color (Netflix Red → Your Color)
**File:** `css/movies-page.css`
```css
/* Find & Replace: */
#e50914 → your color
#ff6b6b → lighter shade
```

### Change Grid Columns
**File:** `css/movies-page.css` (line 226)
```css
grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                                           ↑
                                   Change this for width
```

### Change Hover Delay
**File:** `js/movies-page.js` (line 20)
```javascript
hoverDelay: 1500  // milliseconds
```

### Change Movies Per Load
**File:** `page-movies.php` (line 39)
```php
'posts_per_page' => 12
```

---

## ❓ FAQ

**Q: Trailer not playing on hover?**
A: Check in WordPress Admin that `_movie_trailer_video` URL is a direct MP4 link (not YouTube)

**Q: Search dropdown not showing?**
A: Search needs at least 2 characters + check browser console for errors

**Q: Load More button not working?**
A: Clear WordPress transients/cache, check that REST API is enabled

**Q: Images blurry?**
A: Use high-res images (2000px wide minimum). WordPress auto-crops to 400x600

---

## 🔗 API Endpoints

```
GET /wp-json/ds-theme/v1/load-more?page=2&genre=action
GET /wp-json/ds-theme/v1/search?q=avatar
```

---

## 💡 Pro Tips

1. **Hero Video:** Use a short montage of your best movies (3-5 min)
2. **Trailer Videos:** Keep under 30 seconds, MP4 format, muted
3. **Badges:** Use sparingly - "Trending", "New Release", "4K Ultra HD"
4. **Ratings:** Sync with actual IMDb ratings for authenticity
5. **Genres:** 5-8 genres work best (more = overcrowded filters)

---

**You're all set! Happy streaming! 🎬**
