@extends('layouts.app')

@section('title', 'Добавить мастера — Админ GIDRA')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('admin.masters.index') }}" class="text-gray-400 hover:text-white flex items-center gap-2">
        ← Назад к списку мастеров
    </a>
    <h1 class="text-4xl font-bold mb-10">Добавить мастера</h1>

    <div class="bg-[#111] border border-gray-800 rounded-3xl p-12">
        <form method="POST" action="{{ route('admin.masters.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-8">
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Имя мастера</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Специализация</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Опыт</label>
                    <select name="experience" required class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                        <option value="">Выберите уровень</option>
                        <option value="Младший мастер" {{ old('experience') == 'Младший мастер' ? 'selected' : '' }}>Младший мастер</option>
                        <option value="Мастер" {{ old('experience') == 'Мастер' ? 'selected' : '' }}>Мастер</option>
                        <option value="Топ-мастер" {{ old('experience') == 'Топ-мастер' ? 'selected' : '' }}>Топ-мастер</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Фото мастера</label>
                    <input type="file" name="photo" accept="image/*" 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <button type="submit" class="w-full py-4 bg-white text-black uppercase tracking-widest text-xl font-medium rounded-xl hover:bg-gray-200 transition">
                    Добавить мастера
                </button>
            </div>
        </form>
    </div>
</div>
@endsection