<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'GIDRA BARBERSHOP')</title>
    <meta name="description" content="@yield('description', 'Барбершоп GIDRA')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] text-white font-sans min-h-screen flex flex-col">

<header x-data="{open:false}" class="fixed w-full z-50 bg-black/80 backdrop-blur border-b border-gray-800 transition-all duration-300" id="main-header">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
        <a href="/" class="flex items-center header-logo" id="header-logo">
            <img src="{{ asset('storage/images/logo.png') }}"
                alt="GIDRA BARBERSHOP"
                class="h-10 w-auto object-contain">
        </a>

        
        <nav class="hidden md:flex space-x-8 text-sm uppercase">
            <a href="/#about" class="hover:text-gray-400">О нас</a>
            <a href="/#masters" class="hover:text-gray-400">Мастера</a>
            <a href="/#services" class="hover:text-gray-400">Услуги</a>
            <a href="/#reviews" class="hover:text-gray-400">Отзывы</a>
            <a href="/#contacts" class="hover:text-gray-400">Контакты</a>
            <a href="{{ route('vacancies') }}" class="hover:text-gray-400">Вакансии</a>
            
            @if(auth()->check())
                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-400 font-medium">Админ-панель</a>
            @endif
        </nav>

        
        <button @click="open = !open" class="md:hidden">
            ☰
        </button>
    </div>

    
    <div x-show="open" class="md:hidden bg-black px-6 pb-4 space-y-3">
        <a href="/#about" class="block">О нас</a>
        <a href="/#masters" class="block">Мастера</a>
        <a href="/#services" class="block">Услуги</a>
        <a href="/#reviews" class="block">Отзывы</a>
        <a href="/#contacts" class="block">Контакты</a>
        <a href="{{ route('vacancies') }}" class="block">Вакансии</a>
        
        @if(auth()->check())
            <a href="{{ route('admin.dashboard') }}" class="block font-medium">Админ-панель</a>
        @endif
    </div>
</header>

<main class="pt-20 flex-1">
    @yield('content')
</main>

<footer class="bg-black border-t border-gray-800 pt-12 pb-6 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid md:grid-cols-2 gap-12 pb-12 border-b border-gray-800">
            
            
            <div>
                <h3 class="text-white text-lg font-semibold mb-6 tracking-wider">СОЦИАЛЬНЫЕ СЕТИ</h3>
                <div class="flex flex-col space-y-4">
                    <a href="https://vk.com/gidrabarb" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center gap-3">
                        <span aria-hidden="true" style="width:24px;height:24px;border:1px solid currentColor;border-radius:0.375rem;display:inline-flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;line-height:1;flex-shrink:0;">VK</span>
                        <span>ВКонтакте</span>
                    </a>
                    <a href="https://t.me/gidra_barber" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.66-.35-1.02.22-1.61.15-.15 2.76-2.53 2.81-2.74.01-.03.02-.14-.07-.2-.09-.06-.23-.04-.33-.02-.14.03-2.36 1.5-3.33 2.11-.32.2-.6.3-.86.3-.28 0-.74-.14-1.1-.26-.44-.14-.8-.22-.77-.48.02-.2.28-.4.78-.61 1.38-.6 3.22-1.27 4.83-1.92 1.42-.57 2.58-.86 3.5-.87.33 0 .64.05.92.15.22.08.4.22.42.44.01.14-.02.3-.05.47z"/>
                        </svg>
                        <span>Telegram</span>
                    </a>
                    <a href="https://api.whatsapp.com/send/?phone=79125270666&text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5%21%0A%0A%D0%9F%D0%B8%D1%88%D1%83+%D0%B8%D0%B7+%D0%BF%D1%80%D0%B8%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%B8%D1%8F+2%D0%93%D0%98%D0%A1.%0A%0A&type=phone_number&app_absent=0" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-5.46-4.45-9.91-9.91-9.91zm0 18.23c-1.52 0-3-.41-4.29-1.17l-.31-.18-3.12.82.83-3.04-.2-.32c-.79-1.34-1.21-2.87-1.21-4.44 0-4.6 3.74-8.34 8.34-8.34 4.6 0 8.34 3.74 8.34 8.34 0 4.6-3.74 8.34-8.34 8.34zm4.57-6.25c-.25-.13-1.48-.73-1.71-.81-.23-.08-.4-.13-.57.13-.17.26-.66.81-.81.98-.15.17-.3.19-.55.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.15-.25-.02-.38.11-.51.11-.11.25-.29.38-.44.13-.15.17-.25.26-.42.09-.17.04-.32-.02-.45-.06-.13-.57-1.38-.78-1.89-.21-.5-.42-.42-.57-.43-.15 0-.32-.02-.49-.02-.17 0-.45.06-.68.31-.23.25-.88.86-.88 2.11 0 1.24.91 2.45 1.04 2.62.13.17 1.79 2.73 4.33 3.83.6.26 1.07.41 1.44.53.6.19 1.15.16 1.58.1.48-.07 1.48-.6 1.69-1.18.21-.58.21-1.07.15-1.18-.06-.11-.22-.17-.47-.3z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
            
            
            <div class="md:text-right">
                <h3 class="text-white text-lg font-semibold mb-6 tracking-wider">МЕНЮ</h3>
                <div class="flex flex-col space-y-3">
                    <a href="/#about" class="text-gray-400 hover:text-white transition-colors md:self-end">О нас</a>
                    <a href="/#masters" class="text-gray-400 hover:text-white transition-colors md:self-end">Мастера</a>
                    <a href="/#services" class="text-gray-400 hover:text-white transition-colors md:self-end">Услуги</a>
                    <a href="/#reviews" class="text-gray-400 hover:text-white transition-colors md:self-end">Отзывы</a>
                    <a href="/#contacts" class="text-gray-400 hover:text-white transition-colors md:self-end">Контакты</a>
                    <a href="{{ route('vacancies') }}" class="text-gray-400 hover:text-white transition-colors md:self-end">Вакансии</a>
                    @if(!auth()->check())
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-300 transition-colors text-sm pt-2 md:self-end">Для разработчиков</a>
                    @endif
                </div>
            </div>
        </div>
        
        
        <div class="text-center pt-8">
            <p class="text-gray-500 text-sm">GIDRA BARBERSHOP © {{ date('Y') }}. ВСЕ ПРАВА ЗАЩИЩЕНЫ.</p>
        </div>
        
        
        <div class="text-center pt-4">
            <p class="text-gray-600 text-xs">ИП ГИДРЕВИЧ ВАЛЕНТИНА ФЁДОРОВНА</p>
            <p class="text-gray-600 text-xs">ИНН 450127448340 | ОГРН 324774600689730</p>
        </div>
    </div>
</footer>

<div id="cursor-glow"
     class="fixed w-40 h-40 bg-white/10 blur-3xl rounded-full pointer-events-none -translate-x-1/2 -translate-y-1/2">
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>

<button id="scrollToTop" 
        class="fixed bottom-8 right-8 bg-white text-black w-16 h-16 rounded-full flex items-center justify-center shadow-2xl hover:bg-gray-100 active:scale-95 transition-all duration-300 opacity-0 invisible z-50 text-3xl font-light">
    ↑
</button>

<div id="deleteModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4">

    <div class="w-full max-w-md bg-[#111] border border-gray-800 rounded-3xl p-8 shadow-2xl animate-delete-modal">
        
        <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-10 h-10 text-red-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7H5m5 4v6m4-6v6m-5-10V4h6v3m-9 0h12l-1 13a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7z"/>
                </svg>
        </div>

        <h2 class="text-2xl font-bold text-center mb-3">
            Подтвердите удаление
        </h2>

        <p id="deleteModalText"
           class="text-gray-400 text-center mb-8">
            Вы уверены?
        </p>

        <div class="flex gap-4">
            <button id="cancelDeleteBtn"
                    class="flex-1 py-3 rounded-2xl border border-gray-700 bg-[#1a1a1a] hover:bg-[#222] transition text-white">
                Отмена
            </button>

            <button id="confirmDeleteBtn"
                    class="flex-1 py-3 rounded-2xl bg-red-600 hover:bg-red-500 transition text-white font-medium">
                Удалить
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes deleteModalShow {
        from {
            opacity: 0;
            transform: scale(.95) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .animate-delete-modal {
        animation: deleteModalShow .2s ease;
    }
</style>

<script>
    let activeDeleteForm = null;

    function initDeleteModals() {
        const modal = document.getElementById('deleteModal');
        const modalText = document.getElementById('deleteModalText');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const cancelBtn = document.getElementById('cancelDeleteBtn');

        document.querySelectorAll('.delete-form').forEach(form => {

            if (form.dataset.modalInitialized === 'true') {
                return;
            }

            form.dataset.modalInitialized = 'true';

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                activeDeleteForm = form;

                modalText.innerText =
                    form.dataset.confirm ||
                    'Вы уверены, что хотите удалить?';

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                document.body.classList.add('overflow-hidden');
            });
        });

        confirmBtn.onclick = function() {
            if (!activeDeleteForm) return;

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75"
                              fill="currentColor"
                              d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Удаление...
                </span>
            `;

            activeDeleteForm.submit();
        };

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');

            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Удалить';

            activeDeleteForm = null;
        }

        cancelBtn.onclick = closeModal;

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initDeleteModals);
</script>

<script>
    const scrollToTopBtn = document.getElementById('scrollToTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            scrollToTopBtn.classList.remove('opacity-0', 'invisible');
            scrollToTopBtn.classList.add('opacity-100', 'visible');
        } else {
            scrollToTopBtn.classList.add('opacity-0', 'invisible');
            scrollToTopBtn.classList.remove('opacity-100', 'visible');
        }
    });

    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
</body>
</html>
