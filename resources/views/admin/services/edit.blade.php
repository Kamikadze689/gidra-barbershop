@extends('layouts.app')

@section('title', 'Редактировать услугу — Админ GIDRA')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('admin.services.index') }}" class="text-gray-400 hover:text-white flex items-center gap-2">
        ← Назад к списку услуг
    </a>
    <h1 class="text-4xl font-bold mb-10">Редактировать услугу</h1>

    <div class="bg-[#111] border border-gray-800 rounded-3xl p-12">
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Название услуги</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Категория</label>
                    <select name="category" required class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                        <option value="Основные услуги" {{ $service->category == 'Основные услуги' ? 'selected' : '' }}>Основные услуги</option>
                        <option value="Дополнительные услуги" {{ $service->category == 'Дополнительные услуги' ? 'selected' : '' }}>Дополнительные услуги</option>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Младший мастер</label>
                        <input type="number" name="price_men" value="{{ old('price_men', $service->price_men) }}" required 
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                    </div>
                    <div>
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Мастер</label>
                        <input type="number" name="price_master" value="{{ old('price_master', $service->price_master) }}" required 
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                    </div>
                    <div>
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Топ мастер</label>
                        <input type="number" name="price_top" value="{{ old('price_top', $service->price_top) }}" required 
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Длительность (минут)</label>
                    <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <button type="submit" class="w-full py-4 bg-white text-black uppercase tracking-widest text-xl font-medium rounded-xl hover:bg-gray-200 transition">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection