/**
 * Gospel Ambition Theme JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile menu toggle
        $('.mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('mobile-active');
        });
        
        // Mobile sub-menu toggle
        $('.main-navigation .menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() <= 768) {
                e.preventDefault();
                $(this).parent().toggleClass('mobile-open');
            }
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('mobile-active');
                $('.menu-item-has-children').removeClass('mobile-open');
            }
        });
        
        // Handle window resize
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('mobile-active');
                $('.menu-item-has-children').removeClass('mobile-open');
            }
        });

        // Smooth scrolling for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                    return false;
                }
            }
        });

        // Add class to header on scroll
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });

        // Animate elements on scroll
        function animateOnScroll() {
            $('.tool-card, .post-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animate-in');
                }
            });
        }

        // Run animation on scroll and page load
        $(window).on('scroll resize', animateOnScroll);
        animateOnScroll();

        // Form validation
        $('form').on('submit', function(e) {
            var isValid = true;
            
            $(this).find('input[required], textarea[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    isValid = false;
                } else {
                    $(this).removeClass('error');
                }
            });

            // Email validation
            $(this).find('input[type="email"]').each(function() {
                var email = $(this).val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    $(this).addClass('error');
                    isValid = false;
                } else if (email) {
                    $(this).removeClass('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                $('.form-error').remove();
                $(this).prepend('<div class="form-error">Please fill in all required fields correctly.</div>');
            }
        });

        // Remove error class on input focus
        $('input, textarea').on('focus', function() {
            $(this).removeClass('error');
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Search functionality enhancement
        $('.search-form input[type="search"]').on('focus', function() {
            $(this).closest('.search-form').addClass('focused');
        }).on('blur', function() {
            $(this).closest('.search-form').removeClass('focused');
        });

        // Back to top button
        if ($('.back-to-top').length) {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });

            $('.back-to-top').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({scrollTop: 0}, 600);
            });
        }
    });

})(jQuery);
