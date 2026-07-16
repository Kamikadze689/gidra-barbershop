@extends('layouts.app')
@section('title', 'Экспорт записей — Админ GIDRA')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">

    <a href="{{ route('admin.bookings') }}"
       class="text-gray-400 hover:text-white flex items-center gap-2 mb-8">
        ← Назад к записям
    </a>

    <div class="bg-[#111] rounded-3xl p-8">

        <h1 class="text-4xl font-bold mb-2">
            Экспорт записей
        </h1>

        <p class="text-gray-400 mb-8">
            Сформируйте отчёт по нужным параметрам
        </p>

        <form method="POST" action="{{ route('admin.bookings.export') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">

                {{-- Период --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Дата от
                    </label>

                    <input type="date"
                           name="date_from"
                           class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 text-gray-400">
                        Дата до
                    </label>

                    <input type="date"
                           name="date_to"
                           class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                </div>

                {{-- Мастер --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Мастер
                    </label>

                    <select name="master_id"
                            class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                        <option value="">Все мастера</option>

                        @foreach($masters as $master)
                            <option value="{{ $master->id }}">
                                {{ $master->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Услуга --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Услуга
                    </label>

                    <select name="service_id"
                            class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                        <option value="">Все услуги</option>

                        @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Статус --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Статус записи
                    </label>

                    <select name="status"
                            class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                        <option value="">Все статусы</option>
                        <option value="pending">Ожидает</option>
                        <option value="confirmed">Подтверждена</option>
                        <option value="completed">Выполнена</option>
                        <option value="cancelled">Отменена</option>
                    </select>
                </div>

                {{-- Имя --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Клиент
                    </label>

                    <input type="text"
                           name="customer_name"
                           placeholder="Иван"
                           class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                </div>

                {{-- Телефон --}}
                <div>
                    <label class="block mb-2 text-gray-400">
                        Телефон
                    </label>

                    <input type="text"
                           name="customer_phone"
                           placeholder="79123456789"
                           class="w-full bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3">
                </div>

            </div>

            {{-- Что включить в отчёт --}}
            <div class="mt-10">
                <h2 class="text-xl font-semibold mb-4">
                    Содержимое отчёта
                </h2>

                <div class="grid md:grid-cols-2 gap-3">

                    <label class="flex items-center gap-3">
                        <input type="checkbox" checked disabled>
                        Основная таблица записей
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                               name="include_master_stats"
                               value="1"
                               checked>
                        Статистика по мастерам
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                               name="include_service_stats"
                               value="1"
                               checked>
                        Статистика по услугам
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                               name="include_clients_stats"
                               value="1"
                               checked>
                        Постоянные клиенты
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                            name="include_analytics"
                            value="1"
                            checked>
                        BI-аналитика (итоги, конверсии, отмены)
                    </label>

                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <button type="submit"
                        class="bg-white text-black px-6 py-3 rounded-xl hover:bg-gray-200">
                    Скачать Excel
                </button>
            </div>

        </form>

    </div>

</div>
@endsection