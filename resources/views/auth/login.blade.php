@extends('layouts.guest')

@section('title', 'Вход — GIDRA')

@section('content')
<div class="p-2">
    
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white tracking-wider">АДМИНИСТРИРОВАНИЕ</h2>
        <div class="w-16 h-px bg-gradient-to-r from-transparent via-white to-transparent mx-auto mt-3"></div>
    </div>

    
    <div id="error-alert" class="hidden mb-6 p-4 bg-[#1a1a1a] border border-red-500 rounded-2xl flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span id="error-text" class="text-gray-300 text-sm">Неверный email или пароль</span>
        <button onclick="this.parentElement.classList.add('hidden')" class="ml-auto text-gray-500 hover:text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        <div class="space-y-6">
            
            <div class="group">
                <label class="block text-xs uppercase tracking-[0.15em] text-gray-400 mb-3 group-focus-within:text-white transition-colors duration-300">
                    Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="pochta@gmail.com"
                        class="w-full bg-[#1a1a1a] border border-white/10 focus:border-white/30 rounded-2xl pl-12 pr-6 py-3 text-white text-base placeholder-gray-600 outline-none transition-all duration-300 focus:bg-[#1f1f1f]">
                </div>
            </div>

            
            <div class="group">
                <label class="block text-xs uppercase tracking-[0.15em] text-gray-400 mb-3 group-focus-within:text-white transition-colors duration-300">
                    Пароль
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        required 
                        placeholder="••••••••"
                        class="w-full bg-[#1a1a1a] border border-white/10 focus:border-white/30 rounded-2xl pl-12 pr-6 py-3 text-white text-base placeholder-gray-600 outline-none transition-all duration-300 focus:bg-[#1f1f1f]">
                </div>
            </div>

            
            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" class="sr-only peer">
                        <div class="w-5 h-5 border border-white/20 rounded bg-[#1a1a1a] peer-checked:bg-white peer-checked:border-white transition-all duration-200"></div>
                        <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-black opacity-0 peer-checked:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">Запомнить меня</span>
                </label>
            </div>

            
            <button type="submit"
                    class="relative w-full mt-6 px-8 py-3 bg-white text-black font-bold uppercase tracking-[0.15em] text-base rounded-2xl overflow-hidden group transition-all duration-300 hover:shadow-lg hover:shadow-white/10">
                <span class="relative z-10">Войти в панель</span>
                <div class="absolute inset-0 bg-gradient-to-r from-white to-gray-200 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            </button>
        </div>
    </form>

    
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-white/10"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-3 bg-[#111] text-gray-500">доступ ограничен</span>
        </div>
    </div>

    
    <a href="/" class="flex items-center justify-center gap-2 text-gray-500 hover:text-white text-sm transition-all duration-300 group">
        <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Вернуться на сайт
    </a>
</div>

<script>
     
    function showError(message) {
        const alertDiv = document.getElementById('error-alert');
        const errorText = document.getElementById('error-text');
        
        if (alertDiv && errorText) {
            errorText.textContent = message;
            alertDiv.classList.remove('hidden');
            
             
            setTimeout(() => {
                alertDiv.classList.add('hidden');
            }, 5000);
        }
    }
    
     
    @if(session('error'))
        showError('{{ session('error') }}');
    @endif
    
    @if($errors->any())
        showError('Неверный email или пароль');
    @endif
    
     
    document.getElementById('login-form')?.addEventListener('submit', function(e) {
        const email = document.getElementById('email')?.value.trim();
        const password = document.getElementById('password')?.value;
        
        if (!email || !password) {
            e.preventDefault();
            showError('Заполните все поля');
        }
    });
</script>
@endsection