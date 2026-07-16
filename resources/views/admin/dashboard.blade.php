@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] flex flex-col">

    <div class="max-w-7xl mx-auto px-6 py-16 flex-1">
        
        <div class="flex justify-between items-center border-b border-gray-800 pb-12 mb-16">
            <div>
                <h1 class="text-6xl font-black tracking-widest text-white">GIDRA</h1>
                <p class="text-gray-400 text-2xl mt-3">АДМИН-ПАНЕЛЬ</p>
            </div>
            
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl transition font-medium">
                    Выйти из админки
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <a href="{{ route('admin.bookings') }}" 
               class="group bg-[#111] border border-gray-800 hover:border-gray-400 p-10 rounded-3xl transition-all duration-300">
                <h3 class="text-3xl font-semibold text-white mb-4">Записи на стрижку</h3>
                <p class="text-gray-400 leading-relaxed">
                    Просмотр всех заявок, подтверждение и управление временем
                </p>
            </a>

            <a href="{{ route('admin.vacancy-applications') }}" 
               class="group bg-[#111] border border-gray-800 hover:border-gray-400 p-10 rounded-3xl transition-all duration-300">
                <h3 class="text-3xl font-semibold text-white mb-4">Отклики на вакансии</h3>
                <p class="text-gray-400 leading-relaxed">
                    Заявки от кандидатов на работу
                </p>
            </a>

            <a href="{{ route('admin.reviews') }}" 
               class="group bg-[#111] border border-gray-800 hover:border-gray-400 p-10 rounded-3xl transition-all duration-300">
                <h3 class="text-3xl font-semibold text-white mb-4">Отзывы на модерацию</h3>
                <p class="text-gray-400 leading-relaxed">
                    Проверка и публикация отзывов клиентов
                </p>
            </a>

        </div>

        <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8">
            <a href="{{ route('admin.masters.index') }}" 
               class="block bg-[#111] border border-gray-800 hover:border-gray-400 p-10 rounded-3xl transition-all">
                <h4 class="text-2xl font-medium text-white">Мастера</h4>
                <p class="text-gray-400 mt-2">Добавление, редактирование и удаление мастеров</p>
            </a>

            <a href="{{ route('admin.services.index') }}" 
               class="block bg-[#111] border border-gray-800 hover:border-gray-400 p-10 rounded-3xl transition-all">
                <h4 class="text-2xl font-medium text-white">Услуги</h4>
                <p class="text-gray-400 mt-2">Управление услугами и ценами</p>
            </a>
        </div>

    </div>

</div>
@endsection