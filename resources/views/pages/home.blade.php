@extends('layouts.app')

@section('content')

@vite(['resources/css/app.css', 'resources/js/app.js'])


@if(session('success'))
    <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md animate-slide-down">
        <div class="bg-[#1a1a1a] border border-green-500 rounded-2xl px-6 py-4 shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-gray-300 flex-1">{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md animate-slide-down">
        <div class="bg-[#1a1a1a] border border-red-500 rounded-2xl px-6 py-4 shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-gray-300 flex-1">{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif


<section id="hero" class="h-screen relative flex items-center justify-center text-center overflow-hidden">
    <video autoplay muted loop class="absolute w-full h-full object-cover opacity-50">
        <source src="{{ asset('videos/background-video.mp4') }}" type="video/mp4">
    </video>

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-3xl reveal">
        
        <div id="hero-logo" class="hero-logo-container">
            <img src="{{ asset('storage/images/favicon.png') }}" 
                 alt="GIDRA" 
                 class="w-64 h-64 mx-auto mb-6">
        </div>

        <p class="mt-8 text-gray-400 text-lg">Барбершоп GIDRA — больше, чем просто стрижка</p>
        <a href="{{ route('booking') }}" class="mt-10 inline-block border border-white px-10 py-4 uppercase tracking-widest glow hover:bg-white hover:text-black transition duration-300">
            Записаться
        </a>
    </div>
</section>


<section id="about" class="py-24 max-w-4xl mx-auto text-center px-6">
    <h2 class="text-4xl font-bold mb-6">О нас</h2>

    <p class="text-gray-400 leading-relaxed text-lg">
        Барбершоп GIDRA — больше, чем просто стрижка<br>
        Стиль, атмосфера и качество в одном месте<br>
        Приходите в барбершоп GIDRA и убедитесь в этом лично
    </p>
</section>


<section id="masters" class="py-32 max-w-7xl mx-auto px-6 reveal">
    <h2 class="text-5xl mb-16">Мастера</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
        @foreach($masters as $master)
            <div class="group relative overflow-hidden rounded-3xl">
                <img src="{{ $master->photo ? asset('storage/' . ltrim($master->photo, '/')) : asset('storage/images/nophoto.jpg') }}"
                     class="w-full h-[480px] object-cover transition duration-700 group-hover:scale-105"
                     alt="{{ $master->name }}">

                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>

                <div class="absolute bottom-0 left-0 right-0 p-8 translate-y-6 group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="text-3xl font-bold text-white">{{ $master->name }}</h3>
                    <p class="text-gray-300 mt-1">{{ $master->experience }}</p>
                    <p class="text-gray-400 text-sm mt-2">{{ $master->specialization }}</p>

                    <div class="mt-8">
                        <a href="{{ route('booking', $master->slug) }}"
                           class="block text-center border border-white/80 py-3.5 rounded-2xl hover:bg-white hover:text-black transition text-sm font-medium">
                            Записаться
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="services" class="py-32 bg-[#111]">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-5xl mb-12 text-white">Услуги</h2>

        <div x-data="{ open: 0 }">
            
            <div class="py-6">
                <button @click="open === 0 ? open = null : open = 0"
                        class="w-full flex items-center justify-between text-left text-2xl gap-4 text-white cursor-pointer hover:text-gray-300 transition duration-300">
                    <span class="tracking-widest uppercase text-gray-300">Основные</span>
                    <span class="shrink-0 text-3xl transition-transform duration-300" 
                          :class="{ 'rotate-180': open === 0 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="open === 0" x-transition class="mt-4 space-y-3">
                    <div class="bg-[#111] text-gray-300 rounded-lg shadow-lg overflow-hidden">
                        <div style="width:100%; overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling:touch;">
                            <table style="width:100%; min-width:720px;">
                                <thead>
                                    <tr class="bg-[#111]">
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Услуга</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Младший Мастер</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Мастер</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Топ Мастер</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services->where('category', 'Основные услуги') as $service)
                                        <tr class="hover:bg-[#333] transition duration-300">
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ $service->title }}</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_men, 0, '', ' ') }} ₽</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_master, 0, '', ' ') }} ₽</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_top, 0, '', ' ') }} ₽</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="py-6">
                <button @click="open === 1 ? open = null : open = 1"
                        class="w-full flex items-center justify-between text-left text-2xl gap-4 text-white cursor-pointer hover:text-gray-300 transition duration-300">
                    <span class="tracking-widest uppercase text-gray-300">Дополнительные</span>
                    <span class="shrink-0 text-3xl transition-transform duration-300" 
                          :class="{ 'rotate-180': open === 1 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="open === 1" x-transition class="mt-4 space-y-3">
                    <div class="bg-[#111] text-gray-300 rounded-lg shadow-lg overflow-hidden">
                        <div style="width:100%; overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling:touch;">
                            <table style="width:100%; min-width:720px;">
                                <thead>
                                    <tr class="bg-[#111]">
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Услуга</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Младший Мастер</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Мастер</th>
                                        <th class="py-3 px-6 text-left font-semibold text-gray-300" style="white-space:nowrap;">Топ Мастер</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services->where('category', 'Дополнительные услуги') as $service)
                                        <tr class="hover:bg-[#333] transition duration-300">
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ $service->title }}</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_men, 0, '', ' ') }} ₽</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_master, 0, '', ' ') }} ₽</td>
                                            <td class="py-3 px-6" style="white-space:nowrap;">{{ number_format($service->price_top, 0, '', ' ') }} ₽</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="reviews" class="py-32 w-full bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-6 mb-10 text-center">
        <h2 class="text-5xl">Отзывы</h2>
    </div>

    @if($reviews->isEmpty())
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-gray-400">Пока нет отзывов.</p>
        </div>
    @else
        <div class="reviews-container">
            <div class="reviews-track" id="reviewsTrack">
                {{-- Оригинальные отзывы --}}
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-content">
                            <p class="review-text">{{ $review->text }}</p>
                        </div>
                        <div class="client-info">
                            <p class="client-name">{{ $review->name }}</p>
                            <p class="client-date">{{ \Carbon\Carbon::parse($review->date)->locale('ru')->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>


<section id="contacts" class="py-24 bg-black">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10">
        <div>
            <h2 class="text-3xl mb-6">Контакты</h2>
            <p>ул. Куйбышева, д. 67, Курган</p>
            <p class="mt-2">+7 (912) 527-06-66</p>
            <p class="mt-2">Ежедневно 9:00–21:00</p>
            <a href="https://yandex.ru/maps/?ll=65.349547,55.435374&z=17"
               target="_blank"
               class="inline-block mt-6 border border-white px-6 py-3 uppercase hover:bg-white hover:text-black transition">
                Открыть в Яндекс.Картах
            </a>
        </div>
        <div id="map" class="w-full h-[400px] rounded-xl border border-gray-800 overflow-hidden"></div>
    </div>
</section>
<style>
    #header-logo {
        position: relative;
        display: inline-flex;
        transform: translateX(-40px);
        opacity: 0;
        transition: transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1), opacity 0.6s ease-out;
    }

    #header-logo.visible {
        transform: translateX(0);
        opacity: 1;
    }
</style>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initMap() {
        try {
            const map = new ymaps.Map('map', {
                center: [55.435374, 65.349547],
                zoom: 17,
                controls: ['zoomControl', 'fullscreenControl']
            });
            
            const placemark = new ymaps.Placemark(
                [55.435374, 65.349547],
                {
                    hintContent: 'GIDRA BARBERSHOP',
                    balloonContent: '<strong>GIDRA BARBERSHOP</strong><br/>ул. Куйбышева, д. 67<br/>+7 (912) 527-06-66'
                },
                {
                    iconLayout: 'default#image',
                    iconImageHref: '{{ asset("storage/images/logo-map.png") }}',
                    iconImageSize: [60, 60],
                    iconImageOffset: [-30, -30]
                }
            );
            
            map.geoObjects.add(placemark);
            placemark.events.add('click', function() {
                map.setZoom(18);
            });
        } catch (error) {
            console.error('Ошибка инициализации карты:', error);
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                mapContainer.innerHTML = '<iframe src="https://yandex.ru/map-widget/v1/?ll=65.349547%2C55.435374&z=17&pt=65.349547%2C55.435374" width="100%" height="100%" frameborder="0"></iframe>';
            }
        }
    }
    
    if (typeof ymaps !== 'undefined') {
        ymaps.ready(initMap);
    } else {
        window.addEventListener('load', function() {
            if (typeof ymaps !== 'undefined') {
                ymaps.ready(initMap);
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.fixed.top-24');
    alerts.forEach(alert => {
        setTimeout(() => alert.remove(), 5000);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const headerLogo = document.getElementById('header-logo');
    const heroSection = document.getElementById('hero');
    
    if (headerLogo && heroSection) {
        function checkHeaderLogoVisibility() {
            const heroBottom = heroSection.offsetTop + heroSection.offsetHeight;
            const scrollPosition = window.scrollY;
            
            if (scrollPosition > heroBottom - 100) {
                headerLogo.classList.add('visible');
            } else {
                headerLogo.classList.remove('visible');
            }
        }
        
        window.addEventListener('scroll', checkHeaderLogoVisibility);
        checkHeaderLogoVisibility();
    }
});
</script>

@endsection