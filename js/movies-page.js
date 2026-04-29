/**
 * DS Theme - Movies Page Functionality
 * OPTIMIZED: Lazy loading, debouncing, RAF optimization
 */

// Performance tracking
const perfMetrics = {
    renderTime: 0,
    imageLoadCount: 0,
    videoLoadCount: 0
};

jQuery(document).ready(function($) {
    console.log('Movies page initialized');
    
    // Initialize lazy loading for images
    initLazyLoadImages();
    
    // Debounced search functionality
    let searchTimeout;
    $('#movieSearch').on('keyup', function() {
        clearTimeout(searchTimeout);
        const $input = $(this);
        searchTimeout = setTimeout(function() {
            performFilterSearch($input.val().toLowerCase());
        }, 150); // Debounce 150ms
    });
    
    // Genre filter
    $('#genreFilters').on('click', '.filter-btn', function(e) {
        e.preventDefault();
        $('#genreFilters .filter-btn').removeClass('active');
        $(this).addClass('active');
    });
    
    // Bookmark functionality with localStorage
    $(document).on('click', '.btn-bookmark', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const movieTitle = $btn.closest('.movie-card').find('.movie-title').text();
        
        $btn.toggleClass('active');
        
        if ($btn.hasClass('active')) {
            $btn.text('❤');
            addToWatchlist(movieTitle);
        } else {
            $btn.text('♡');
            removeFromWatchlist(movieTitle);
        }
    });
    
    // Load saved bookmarks
    loadBookmarks();
});

// OPTIMIZED: Lazy load images only when visible
function initLazyLoadImages() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        perfMetrics.imageLoadCount++;
                    }
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '100px'
        });

        jQuery('img[data-src]').each(function() {
            imageObserver.observe(this);
        });
    } else {
        // Fallback for older browsers
        jQuery('img[data-src]').each(function() {
            jQuery(this).attr('src', jQuery(this).attr('data-src')).removeAttr('data-src');
        });
    }
}

// OPTIMIZED: Debounced search
function performFilterSearch(searchTerm) {
    const $cards = jQuery('.movie-card');
    let visibleCount = 0;
    
    $cards.each(function() {
        const title = jQuery(this).find('.movie-title').text().toLowerCase();
        const excerpt = jQuery(this).find('.movie-excerpt').text().toLowerCase();
        const genres = jQuery(this).find('.genre-tag').text().toLowerCase();
        
        const matches = title.includes(searchTerm) || 
                       excerpt.includes(searchTerm) || 
                       genres.includes(searchTerm) ||
                       searchTerm === '';
        
        if (matches) {
            jQuery(this).fadeIn(200);
            visibleCount++;
        } else {
            jQuery(this).fadeOut(200);
        }
    });
}

/**
 * Watchlist Management
 */
function addToWatchlist(movieTitle) {
    let watchlist = JSON.parse(localStorage.getItem('movieWatchlist')) || [];
    if (!watchlist.includes(movieTitle)) {
        watchlist.push(movieTitle);
        localStorage.setItem('movieWatchlist', JSON.stringify(watchlist));
    }
}

function removeFromWatchlist(movieTitle) {
    let watchlist = JSON.parse(localStorage.getItem('movieWatchlist')) || [];
    watchlist = watchlist.filter(movie => movie !== movieTitle);
    localStorage.setItem('movieWatchlist', JSON.stringify(watchlist));
}

function loadBookmarks() {
    const watchlist = JSON.parse(localStorage.getItem('movieWatchlist')) || [];
    
    jQuery('.movie-card').each(function() {
        const movieTitle = jQuery(this).find('.movie-title').text();
        if (watchlist.includes(movieTitle)) {
            jQuery(this).find('.btn-bookmark').addClass('active').text('❤');
        }
    });
}

// ====== CONFIG ====== 
const config = {
    currentPage: 1,
    isLoading: false,
    hasMore: true,
    hoverDelay: 800,  // Reduced from 1500ms for faster UX
    currentFilter: 'all'
};

// ====== 1. VIDEO TRAILER ON HOVER (OPTIMIZED) ======
initTrailerOnHover();

function initTrailerOnHover() {
    jQuery(document).on('mouseenter', '.movie-card', function() {
        const card = jQuery(this);
        const trailerVideo = card.find('.movie-trailer')[0];
        const posterImg = card.find('.movie-poster');
        
        if (!trailerVideo) return;
        
        // Set up lazy video loading
        if (!trailerVideo.src) {
            const source = trailerVideo.querySelector('source');
            if (source) {
                trailerVideo.src = source.src;
            }
        }
        
        // Delay hover effect
        card.data('hoverTimer', setTimeout(function() {
            // Check if card is still being hovered
            if (!card.is(':hover')) return;
            
            posterImg.fadeOut(200, function() {
                trailerVideo.style.display = 'block';
                trailerVideo.play().catch(err => {
                    console.log('Trailer autoplay prevented:', err);
                    posterImg.fadeIn(200);
                });
            });
        }, config.hoverDelay));
    });
    
    jQuery(document).on('mouseleave', '.movie-card', function() {
        const card = jQuery(this);
        clearTimeout(card.data('hoverTimer'));
        
        const trailerVideo = card.find('.movie-trailer')[0];
        const posterImg = card.find('.movie-poster');
        
        if (trailerVideo && trailerVideo.style.display !== 'none') {
            trailerVideo.pause();
            trailerVideo.currentTime = 0;
            trailerVideo.style.display = 'none';
            posterImg.fadeIn(200);
        }
    });
}
    
    // ====== 2. LIVE SEARCH WITH THUMBNAILS ======
    initLiveSearch();
    
    function initLiveSearch() {
        const searchInput = $('#movieLiveSearch');
        const resultsDropdown = $('#searchResultsDropdown');
        let searchTimeout;
        
        if (!searchInput.length) return;
        
        searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().trim();
            
            if (query.length < 2) {
                resultsDropdown.removeClass('active').empty();
                return;
            }
            
            searchTimeout = setTimeout(function() {
                performLiveSearch(query);
            }, 300);
        });
        
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.live-search-wrapper').length) {
                resultsDropdown.removeClass('active').empty();
            }
        });
    }
    
    function performLiveSearch(query) {
        const resultsDropdown = $('#searchResultsDropdown');
        
        $.ajax({
            url: dsMoviesData.ajaxUrl + 'search',
            method: 'GET',
            data: {
                q: query
            },
            success: function(response) {
                if (response.success && response.results.length > 0) {
                    let html = '';
                    $.each(response.results, function(i, movie) {
                        html += `
                            <a href="${movie.permalink}" class="search-result-item">
                                ${movie.thumbnail ? `<img src="${movie.thumbnail}" alt="${movie.title}" class="search-result-thumbnail">` : '<div class="search-result-thumbnail" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>'}
                                <div class="search-result-content">
                                    <div class="search-result-title">${movie.title}</div>
                                    <div class="search-result-excerpt">${movie.excerpt}</div>
                                </div>
                            </a>
                        `;
                    });
                    resultsDropdown.html(html).addClass('active');
                } else {
                    resultsDropdown.html('<div class="search-result-item" style="text-align: center; padding: 20px;">No results found</div>').addClass('active');
                }
            },
            error: function() {
                resultsDropdown.html('<div class="search-result-item" style="text-align: center; padding: 20px;">Error loading results</div>').addClass('active');
            }
        });
    }
    
    // ====== 3. INFINITE SCROLL / LOAD MORE ======
    initInfiniteScroll();
    
    function initInfiniteScroll() {
        const loadMoreBtn = $('#loadMoreBtn');
        const maxPages = parseInt($('#maxPages').val());
        
        if (!loadMoreBtn.length) return;
        
        loadMoreBtn.on('click', function() {
            loadMoreMovies();
        });
        
        // OPTIMIZED: Throttled scroll event with RAF
        let scrollTimeout;
        jQuery(window).on('scroll', function() {
            if (scrollTimeout) return;
            
            scrollTimeout = requestAnimationFrame(function() {
                if (shouldAutoLoad()) {
                    loadMoreMovies();
                }
                scrollTimeout = null;
            });
        });
    }
    
    function shouldAutoLoad() {
        if (config.isLoading || !config.hasMore) return false;
        
        const scrollPercent = jQuery(window).scrollTop() / (jQuery(document).height() - jQuery(window).height());
        return scrollPercent > 0.75; // Load when 75% scrolled
    }
    
    function loadMoreMovies() {
        if (config.isLoading || !config.hasMore) return;
        
        config.isLoading = true;
        const loadMoreBtn = jQuery('#loadMoreBtn');
        const currentPage = parseInt(jQuery('#currentPage').val());
        const nextPage = currentPage + 1;
        const maxPages = parseInt(jQuery('#maxPages').val());
        
        loadMoreBtn.addClass('loading').prop('disabled', true);
        
        jQuery.ajax({
            url: dsMoviesData.ajaxUrl + 'load-more',
            method: 'GET',
            data: {
                page: nextPage,
                genre: config.currentFilter
            },
            success: function(response) {
                if (response.success && response.movies.length > 0) {
                    let html = '';
                    jQuery.each(response.movies, function(i, movie) {
                        html += generateMovieCardHTML(movie);
                    });
                    
                    jQuery('#moviesGrid').append(html);
                    jQuery('#currentPage').val(nextPage);
                    
                    // OPTIMIZED: Initialize lazy loading and hover for new cards
                    initLazyLoadImages();
                    initTrailerOnHover();
                    
                    // Check if we've reached max pages
                    if (nextPage >= maxPages || response.movies.length < 12) {
                        config.hasMore = false;
                        loadMoreBtn.fadeOut();
                    } else {
                        config.hasMore = true;
                    }
                }
            },
            complete: function() {
                config.isLoading = false;
                loadMoreBtn.removeClass('loading').prop('disabled', false);
            }
        });
    }
    
    function generateMovieCardHTML(movie) {
        return `
            <div class="movie-card" data-movie-id="${movie.id}">
                <div class="movie-card-inner">
                    ${movie.badge ? `<div class="movie-badge">${movie.badge}</div>` : ''}
                    
                    <div class="movie-media">
                        ${movie.thumbnail ? `<img data-src="${movie.thumbnail}" alt="${movie.title}" class="movie-poster" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='150'%3E%3Crect fill='%23ddd' width='100' height='150'/%3E%3C/svg%3E">` : '<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>'}
                        ${movie.trailer_video ? `<video class="movie-trailer" muted preload="none"><source src="${movie.trailer_video}" type="video/mp4"></video>` : ''}
                    </div>
                    
                    <div class="movie-info">
                        <h3 class="movie-title">${movie.title}</h3>
                        
                        ${movie.imdb_rating ? `
                            <div class="movie-rating">
                                <span class="rating-stars">⭐</span>
                                <span class="rating-value">${movie.imdb_rating}</span>
                            </div>
                        ` : ''}
                        
                        <p class="movie-description">${movie.excerpt}</p>
                        
                        <div class="movie-actions">
                            <button class="action-btn watchlist-btn" title="Add to Watchlist">
                                <span class="btn-icon">➕</span>
                            </button>
                            ${movie.trailer_video ? `
                                <button class="action-btn play-trailer-btn" title="Play Trailer">
                                    <span class="btn-icon">▶</span>
                                </button>
                            ` : ''}
                            <a href="${movie.permalink}" class="action-btn view-btn" title="View Details">
                                <span class="btn-icon">👁</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // ====== 4. FILTER FUNCTIONALITY ======
    initFilters();
    
    function initFilters() {
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            config.currentFilter = filter;
            config.currentPage = 1;
            config.hasMore = true;
            
            // Update active state
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            // Reset grid and load filtered movies
            resetAndLoadMovies();
        });
    }
    
    function resetAndLoadMovies() {
        const moviesGrid = $('#moviesGrid');
        
        // Clear current movies
        moviesGrid.empty();
        $('#currentPage').val('1');
        
        // Load first page of filtered movies
        $.ajax({
            url: dsMoviesData.ajaxUrl + 'load-more',
            method: 'GET',
            data: {
                page: 1,
                genre: config.currentFilter
            },
            success: function(response) {
                if (response.success && response.movies.length > 0) {
                    let html = '';
                    $.each(response.movies, function(i, movie) {
                        html += generateMovieCardHTML(movie);
                    });
                    
                    moviesGrid.html(html);
                    initTrailerOnHover();
                    
                    // Update max pages
                    $('#maxPages').val(response.max_pages);
                    
                    // Show/hide load more button
                    if (response.max_pages > 1) {
                        $('#loadMoreContainer').show();
                        config.hasMore = true;
                    } else {
                        $('#loadMoreContainer').hide();
                        config.hasMore = false;
                    }
                } else {
                    moviesGrid.html('<div class="no-movies-message"><p>No movies found for this filter.</p></div>');
                    $('#loadMoreContainer').hide();
                }
            }
        });
    }
    
    // ====== 5. WATCHLIST FUNCTIONALITY ====== 
    initWatchlist();
    
    function initWatchlist() {
        $(document).on('click', '.watchlist-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const movieId = btn.closest('.movie-card').data('movie-id');
            
            // Toggle visual feedback
            btn.toggleClass('added');
            
            if (btn.hasClass('added')) {
                btn.css('background', 'rgba(229, 9, 20, 0.9)').find('.btn-icon').text('✓');
            } else {
                btn.css('background', 'rgba(255, 255, 255, 0.1)').find('.btn-icon').text('➕');
            }
            
            // Here you can add AJAX to save to backend
            // addToWatchlist(movieId);
        });
    }
    
    // ====== 6. PLAY TRAILER BUTTON ====== 
    initPlayTrailerButton();
    
    function initPlayTrailerButton() {
        $(document).on('click', '.play-trailer-btn', function(e) {
            e.preventDefault();
            const card = $(this).closest('.movie-card');
            const trailerVideo = card.find('.movie-trailer')[0];
            
            if (trailerVideo) {
                trailerVideo.play();
            }
        });
    }
    
    // ====== 7. SMOOTH SCROLLING ====== 
    $(document).on('click', 'a[href*="#"]', function(e) {
        if ($(this).attr('href') === '#') return;
        
        const target = $($(this).attr('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
    
});
