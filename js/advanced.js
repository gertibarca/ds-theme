// Advanced Movie Theme Enhancements
jQuery(document).ready(function($) {
    
    // ====== Parallax Effect ======
    $(window).on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        $('.featured-hero').css('background-position', 'center ' + (scrollTop * 0.5) + 'px');
    });

    // ====== Smooth Scroll for Anchors ======
    $('a[href*="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if(target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // ====== Movie Card Hover Animation ======
    $('.movie-card').each(function() {
        $(this).on('mouseenter', function() {
            $(this).find('.card-img').css('transform', 'scale(1.15)');
        }).on('mouseleave', function() {
            $(this).find('.card-img').css('transform', 'scale(1)');
        });
    });

    // ====== Filter Animation ======
    $('.filter-btn').on('click', function() {
        $(this).css('transform', 'scale(1.1)');
        setTimeout(() => {
            $(this).css('transform', 'scale(1)');
        }, 150);
    });

    // ====== Enhanced Search ======
    $('.search-input').on('focus', function() {
        $(this).parent().css({
            'box-shadow': '0 8px 24px rgba(229, 9, 20, 0.3)'
        });
    }).on('blur', function() {
        $(this).parent().css({
            'box-shadow': 'none'
        });
    });

    // ====== Number Counter Animation ======
    if($('.rating-value').length) {
        $('.rating-value').each(function() {
            var value = parseFloat($(this).text());
            $(this).on('mouseover', function() {
                var stars = Math.round(value / 2);
                $(this).prev('.stars').text('★'.repeat(stars) + '☆'.repeat(5 - stars));
            });
        });
    }

    // ====== Modal Enhancement ======
    $('.modal').on('show.bs.modal', function() {
        $(this).find('.modal-content').css({
            'animation': 'slideInUp 0.4s ease-out'
        });
    });

    // ====== Page Load Animation ======
    $('.movie-card, .featured-hero, .filter-btn').css('opacity', '0');
    
    $(window).on('load', function() {
        $('.featured-hero').animate({ opacity: 1 }, 600);
        
        $('.movie-card').each(function(index) {
            $(this).delay(index * 50).animate({ opacity: 1 }, 400);
        });
        
        $('.filter-btn').each(function(index) {
            $(this).delay(index * 30).animate({ opacity: 1 }, 300);
        });
    });

    // ====== Scroll Animation ======
    $(window).on('scroll', function() {
        var scrollPos = $(window).scrollTop();
        $('.featured-title, .featured-description').css({
            'opacity': 1 - (scrollPos / 600),
            'transform': 'translateY(' + (scrollPos / 2) + 'px)'
        });
    });

    // ====== Click Ripple Effect for Buttons ======
    $('.btn').on('click', function(e) {
        var $btn = $(this);
        var x = e.pageX - $btn.offset().left;
        var y = e.pageY - $btn.offset().top;
        
        var $ripple = $('<span></span>').css({
            'position': 'absolute',
            'left': x + 'px',
            'top': y + 'px',
            'width': '0',
            'height': '0',
            'border-radius': '50%',
            'background': 'rgba(255,255,255,0.6)',
            'pointer-events': 'none'
        });
        
        $btn.append($ripple);
        
        $ripple.animate({
            'width': '300px',
            'height': '300px',
            'left': (x - 150) + 'px',
            'top': (y - 150) + 'px',
            'opacity': 0
        }, 600, function() {
            $ripple.remove();
        });
    });

    // ====== Active Filter Pulse ======
    setInterval(function() {
        $('.filter-btn.active').css({
            'box-shadow': '0 8px 24px rgba(229, 9, 20, 0.6)'
        });
        setTimeout(function() {
            $('.filter-btn.active').css({
                'box-shadow': '0 8px 24px rgba(229, 9, 20, 0.4)'
            });
        }, 500);
    }, 1000);

});

// Intersection Observer for fade-in animations
if('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.movie-card, .section-title').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}