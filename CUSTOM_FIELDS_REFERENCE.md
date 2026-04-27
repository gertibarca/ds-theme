/**
 * DS Theme - Movie Custom Fields Reference
 * 
 * All custom fields are stored with "_movie_" prefix in WordPress post meta
 * Edit these fields in WordPress Admin → Movies → Edit Movie → "Movie Details" metabox
 */

// ====== REQUIRED CUSTOM FIELDS ======

/**
 * Movie Trailer Video URL
 * Meta Key: _movie_trailer_video
 * Type: URL
 * Format: Direct MP4 file URL
 * Example: https://example.com/uploads/trailers/avatar-trailer.mp4
 * 
 * ⚠️ IMPORTANT:
 * - Must be a direct MP4 file link (NOT YouTube URL)
 * - Must be MP4 format for compatibility
 * - Should be 15-30 seconds long
 * - MUST be muted (no audio)
 * - Can be hosted on your server or CDN
 * 
 * Display: Shown on hover (replaces poster after 1.5s)
 */

/**
 * IMDb Rating
 * Meta Key: _movie_imdb_rating
 * Type: Number (0-10)
 * Example: 8.5
 * 
 * Display: Shows as ⭐ 8.5 on movie card
 */

/**
 * Movie Badge
 * Meta Key: _movie_badge
 * Type: Text
 * Example values:
 *  - "Trending"
 *  - "New Release"
 *  - "4K Ultra HD"
 *  - "Oscar Winner"
 *  - "Award-Winning"
 *  - "Director's Cut"
 * 
 * Display: Red gradient badge in top-right corner of card
 * Leave blank: No badge shown
 */

// ====== OPTIONAL CUSTOM FIELDS ======

/**
 * YouTube URL (for single.php / details page)
 * Meta Key: _movie_youtube_url
 * Type: URL
 * Example: https://www.youtube.com/watch?v=dQw4w9WgXcQ
 */

/**
 * Movie Rating (different from IMDb)
 * Meta Key: _movie_rating
 * Type: Number (0-10)
 * Can be your custom rating system
 */

/**
 * Movie Duration
 * Meta Key: _movie_duration
 * Type: Number (minutes)
 * Example: 142
 */

/**
 * Release Year
 * Meta Key: _movie_year
 * Type: Number (YYYY)
 * Example: 2024
 */

// ====== STANDARD WORDPRESS FIELDS ======

/**
 * Featured Image (Movie Poster)
 * Required for: Movie card display
 * Recommended size: 400x600px (will be cropped)
 * Used in: All grid views, search results
 * 
 * How to upload:
 * 1. Click "Set featured image"
 * 2. Upload poster image
 * 3. Crop to 400x600 (portrait)
 * 4. Click "Set featured image"
 */

/**
 * Movie Title
 * Required: Yes
 * Used in: Card title, search results
 * Example: "Avatar: The Way of Water"
 */

/**
 * Movie Description/Content
 * Type: Rich text editor
 * Used in: Single movie page (single-movies.php)
 * Can include: Story, cast, crew, reviews
 */

/**
 * Movie Excerpt
 * Required for: Card preview text
 * Length: ~50-100 characters (shows truncated to 15 words)
 * Used in: Card description, search results
 * Example: "A paraplegic Marine dispatched to the moon Pandora..."
 */

/**
 * Genres (Taxonomy)
 * Type: Multiple select
 * How to assign:
 * 1. On right sidebar, find "Genres" box
 * 2. Check boxes for applicable genres
 * 3. Or type to create new genre
 * 
 * Used for: Filter buttons on movies archive
 * Example: Science Fiction, Fantasy, Adventure
 */

/**
 * Tags (Taxonomy)
 * Type: Multiple select/freeform
 * Can assign: Any custom tags
 * Example: "space", "alien", "dystopian"
 */

// ====== FIELD MAPPING ======

/**
 * Frontend Display Locations:
 * 
 * Movie Grid Card:
 * ┌─────────────────────────────┐
 * │ [POSTER/TRAILER]  [BADGE]   │  _movie_badge (top-right)
 * │   (featured image)           │  _movie_trailer_video (on hover)
 * │                               │
 * │  Title                       │  post_title
 * │  ⭐ 8.5                      │  _movie_imdb_rating + rating-stars
 * │  Description...              │  post_excerpt (15 words)
 * │  [➕] [▶] [👁]              │  Action buttons
 * └─────────────────────────────┘
 * 
 * Live Search Result:
 * ┌──────┐ ─────────────────────
 * │[IMG] │ Avatar: The Way...
 * │ 400  │ A paraplegic Marine...
 * │ 600  │
 * └──────┘ ─────────────────────
 *   |         |         |
 *   |         |         └─ post_excerpt
 *   |         └─ post_title
 *   └─ Featured image (thumbnail)
 */

// ====== RECOMMENDED VALUES ======

/**
 * BADGES:
 * 🔴 Trending        = Currently popular
 * 🎬 New Release     = Released in last 30 days
 * 🎥 4K Ultra HD     = 4K resolution available
 * 🏆 Award-Winner    = Won major awards
 * 📺 Oscar Nominated = Oscar nomination
 * 👑 Director's Cut  = Special edition
 * 💎 Premium         = High-quality content
 * 🔥 Blockbuster     = Highest grossing
 */

/**
 * IMDB RATINGS:
 * 0.0 - 2.0: Critically panned
 * 2.0 - 4.0: Below average
 * 4.0 - 6.0: Average
 * 6.0 - 7.5: Good
 * 7.5 - 8.5: Very good
 * 8.5 - 9.5: Excellent
 * 9.5 - 10.0: Masterpiece
 */

// ====== EXAMPLE MOVIE SETUP ======

/*
Movie: Avatar: The Way of Water

Title: Avatar: The Way of Water

Featured Image: [poster-2000x3000px]

Excerpt: 
Join the Sully family as they explore the 
stunning underwater world of Pandora.

Description: [Full plot summary and details]

Genres: Science Fiction, Fantasy, Adventure

Tags: alien, space, 3D, action

Custom Fields:
┌─────────────────────────────┐
│ YouTube URL:                │
│ https://youtube.com/...     │
│                             │
│ Trailer Video URL:          │
│ https://cdn.../avatar.mp4   │
│                             │
│ IMDb Rating: 7.3            │
│ Movie Rating: 8.5           │
│ Duration: 192               │
│ Release Year: 2022          │
│ Badge: 4K Ultra HD          │
└─────────────────────────────┘
*/

// ====== WORDPRESS FUNCTIONS TO ACCESS ======

/**
 * In page-movies.php or single-movies.php:
 */

// Get custom field values:
$imdb = get_post_meta(get_the_ID(), '_movie_imdb_rating', true);
$trailer = get_post_meta(get_the_ID(), '_movie_trailer_video', true);
$badge = get_post_meta(get_the_ID(), '_movie_badge', true);
$youtube = get_post_meta(get_the_ID(), '_movie_youtube_url', true);
$rating = get_post_meta(get_the_ID(), '_movie_rating', true);
$duration = get_post_meta(get_the_ID(), '_movie_duration', true);
$year = get_post_meta(get_the_ID(), '_movie_year', true);

// Get standard values:
$title = get_the_title();
$excerpt = get_the_excerpt();
$content = get_the_content();
$featured_img = get_the_post_thumbnail_url(get_the_ID(), 'movie-card');
$genres = get_the_terms(get_the_ID(), 'movie_genres');
$tags = get_the_terms(get_the_ID(), 'post_tag');

// ====== REST API RESPONSE EXAMPLE ======

/**
 * GET /wp-json/ds-theme/v1/load-more?page=1
 * 
 * Response:
 * {
 *   "success": true,
 *   "movies": [
 *     {
 *       "id": 123,
 *       "title": "Avatar: The Way of Water",
 *       "permalink": "https://site.com/movie/avatar-2/",
 *       "thumbnail": "https://cdn.../avatar.jpg",
 *       "excerpt": "Join the Sully family...",
 *       "imdb_rating": "7.3",
 *       "trailer_video": "https://cdn.../avatar.mp4",
 *       "badge": "4K Ultra HD"
 *     },
 *     ...
 *   ],
 *   "max_pages": 5,
 *   "total_movies": 48
 * }
 */

// ====== CUSTOM FIELD REQUIREMENTS CHECKLIST ======

/*
For full functionality, ensure every movie has:

☐ Featured Image (poster, 400x600px min)
☐ Title
☐ Excerpt (50-100 chars)
☐ Description
☐ 1-3 Genres assigned
☐ _movie_imdb_rating (0-10)
☐ _movie_trailer_video (MP4 URL, 15-30 sec)
☐ _movie_badge (optional but recommended)

Optional but recommended:
☐ _movie_youtube_url (for single page)
☐ _movie_duration (movie length in minutes)
☐ _movie_year (release year)
*/
