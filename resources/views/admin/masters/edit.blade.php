@extends('layouts.app')

@section('title', 'Редактировать мастера — Админ GIDRA')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('admin.masters.index') }}" class="text-gray-400 hover:text-white flex items-center gap-2">
        ← Назад к списку мастеров
    </a>
    <h1 class="text-4xl font-bold mb-10">Редактировать мастера</h1>

    <div class="bg-[#111] border border-gray-800 rounded-3xl p-12">
        <form method="POST" action="{{ route('admin.masters.update', $master) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500 rounded-2xl">
                    @foreach($errors->all() as $error)
                        <p class="text-red-400 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-8">
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Имя мастера</label>
                    <input type="text" name="name" value="{{ old('name', $master->name) }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Специализация</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $master->specialization) }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Опыт</label>
                    <select name="experience" required class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                        <option value="Младший мастер" {{ old('experience', $master->experience) == 'Младший мастер' ? 'selected' : '' }}>Младший мастер</option>
                        <option value="Мастер" {{ old('experience', $master->experience) == 'Мастер' ? 'selected' : '' }}>Мастер</option>
                        <option value="Топ-мастер" {{ old('experience', $master->experience) == 'Топ-мастер' ? 'selected' : '' }}>Топ-мастер</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Текущее фото</label>
                    @if($master->photo)
                        <img src="{{ asset('storage/' . ltrim($master->photo, '/')) }}" 
                             alt="{{ $master->name }}" class="w-40 h-40 object-cover rounded-3xl mb-6">
                    @else
                        <div class="w-40 h-40 bg-gray-800 rounded-2xl flex items-center justify-center text-gray-500 text-sm mb-6">
                            Нет фото
                        </div>
                    @endif
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Новое фото (необязательно)</label>
                    <input type="file" name="photo" accept="image/*" 
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