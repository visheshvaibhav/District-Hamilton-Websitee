@extends('layouts.app')

@section('title', 'Daily Offers')

@push('styles')
<style>
    .offers-hero {
        position: relative;
        height: 40vh;
        min-height: 300px;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/tapas-hero.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .offers-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.6) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 1s ease forwards;
    }

    .offers-container {
        position: relative;
        padding: 4rem 0;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        min-height: 60vh;
    }

    .offers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .offer-card {
        position: relative;
        height: 400px;
        perspective: 2000px;
        cursor: pointer;
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .offer-card:hover .card-inner {
        transform: rotateY(180deg);
    }

    .card-face {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .card-front {
        background-position: center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
    }

    .card-back {
        background: rgba(255, 255, 255, 0.95);
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        text-align: center;
    }

    .tuesday-card .card-front {
        background: linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%);
    }

    .wednesday-card .card-front {
        background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
    }

    .thursday-card .card-front {
        background: linear-gradient(135deg, #1CB5E0 0%, #000851 100%);
    }

    .offer-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .offer-subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 1rem;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease 0.2s forwards;
    }

    .offer-details {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .offer-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .offer-button {
        background: var(--primary-color);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid var(--primary-color);
    }

    .offer-button:hover {
        background: transparent;
        color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(184, 134, 11, 0.2);
    }

    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 1;
    }

    .floating-element {
        position: absolute;
        opacity: 0.1;
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }
        50% {
            transform: translate(30px, -30px) rotate(180deg);
        }
        100% {
            transform: translate(0, 0) rotate(360deg);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Optimizations */
    @media (max-width: 768px) {
        .offers-hero {
            height: 30vh;
        }

        .offer-card {
            height: 350px;
        }

        .offers-grid {
            padding: 1rem;
            gap: 1.5rem;
        }

        .offer-title {
            font-size: 2rem;
        }

        .offer-details {
            font-size: 1.75rem;
        }

        /* Touch device interaction */
        .offer-card.touched .card-inner {
            transform: rotateY(180deg);
        }

        .floating-elements {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="offers-hero">
    <div class="hero-content">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Weekly Specials</h1>
        <p class="text-xl text-gray-200">Discover our exclusive offers for an unforgettable dining experience</p>
    </div>
</div>

<div class="offers-container">
    <div class="floating-elements">
        @for ($i = 1; $i <= 5; $i++)
            <div class="floating-element" style="
                top: {{ rand(10, 90) }}%;
                left: {{ rand(10, 90) }}%;
                width: {{ rand(50, 150) }}px;
                height: {{ rand(50, 150) }}px;
                background: url('/images/tapas-icon-{{ rand(1, 3) }}.svg') no-repeat center/contain;
                animation-delay: -{{ rand(1, 10) }}s;
                animation-duration: {{ rand(15, 25) }}s;
            "></div>
        @endfor
    </div>

    <div class="offers-grid">
        <!-- Tuesday Offer -->
        <div class="offer-card tuesday-card" data-day="tuesday">
            <div class="card-inner">
                <div class="card-face card-front">
                    <div>
                        <h2 class="offer-title">Terrific Tuesday</h2>
                        <p class="offer-subtitle">Triple the taste, double the value</p>
                    </div>
                </div>
                <div class="card-face card-back">
                    <h3 class="offer-details">3 Tapas for 2</h3>
                    <p class="offer-description">Choose any three tapas from our signature menu and only pay for two. Perfect for exploring new flavors or enjoying your favorites.</p>
                    <a href="{{ route('menu.index') }}" class="offer-button">View Menu</a>
                </div>
            </div>
        </div>

        <!-- Wednesday Offer -->
        <div class="offer-card wednesday-card" data-day="wednesday">
            <div class="card-inner">
                <div class="card-face card-front">
                    <div>
                        <h2 class="offer-title">Wine Wednesday</h2>
                        <p class="offer-subtitle">Uncork the savings</p>
                    </div>
                </div>
                <div class="card-face card-back">
                    <h3 class="offer-details">50% Off Wines</h3>
                    <p class="offer-description">Enjoy half-price bottles from our carefully curated wine selection. The perfect complement to your tapas experience.</p>
                    <a href="{{ route('menu.index') }}#wines" class="offer-button">View Wines</a>
                </div>
            </div>
        </div>

        <!-- Thursday Offer -->
        <div class="offer-card thursday-card" data-day="thursday">
            <div class="card-inner">
                <div class="card-face card-front">
                    <div>
                        <h2 class="offer-title">Tapas Thursday</h2>
                        <p class="offer-subtitle">A feast for the senses</p>
                    </div>
                </div>
                <div class="card-face card-back">
                    <h3 class="offer-details">5 Tapas for $50</h3>
                    <p class="offer-description">Create your perfect tapas combination with any five dishes from our menu for just $50. An incredible value for a memorable dining experience.</p>
                    <a href="{{ route('menu.index') }}" class="offer-button">View Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const hero = document.querySelector('.offers-hero');
        const scrolled = window.pageYOffset;
        hero.style.backgroundPositionY = (scrolled * 0.5) + 'px';
    });

    // Handle touch interactions for mobile devices
    const offerCards = document.querySelectorAll('.offer-card');
    let touchStartTime;
    let touchTimeout;

    offerCards.forEach(card => {
        card.addEventListener('touchstart', () => {
            touchStartTime = Date.now();
            touchTimeout = setTimeout(() => {
                card.classList.add('touched');
            }, 100);
        });

        card.addEventListener('touchend', () => {
            if (Date.now() - touchStartTime < 100) {
                clearTimeout(touchTimeout);
            }
        });

        // Reset card state when another card is touched
        card.addEventListener('touchstart', () => {
            offerCards.forEach(otherCard => {
                if (otherCard !== card) {
                    otherCard.classList.remove('touched');
                }
            });
        });
    });

    // Highlight current day's offer
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const today = days[new Date().getDay()];
    const todayCard = document.querySelector(`.offer-card[data-day="${today}"]`);
    
    if (todayCard) {
        todayCard.classList.add('today');
        todayCard.style.transform = 'scale(1.02)';
        todayCard.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.3)';
    }

    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    document.querySelectorAll('.offer-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        observer.observe(card);
    });
});
</script>
@endpush
@endsection 