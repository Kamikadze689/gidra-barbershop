@extends('layouts.app')

@section('title', 'Оставить отзыв — GIDRA')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold tracking-wide">Оставить отзыв</h1>
        <p class="text-gray-400 mt-4">Расскажите о своём визите в GIDRA</p>
    </div>

    <div class="bg-[#111] border border-gray-800 rounded-3xl p-12">
        <form method="POST" action="{{ route('review.store', $booking->review_token) }}">
            @csrf

            <div class="space-y-8">
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Ваше имя</label>
                    <input type="text" name="name" value="{{ $booking->customer_name }}" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-2xl px-6 py-3 text-white">
                </div>

                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Ваш отзыв</label>
                    <textarea name="text" rows="7" required 
                              placeholder="Поделитесь впечатлениями о визите..."
                              class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-3xl px-6 py-3 text-white"></textarea>
                </div>

                <button type="submit" 
                        class="w-full py-4 bg-white text-black uppercase tracking-widest text-xl font-medium rounded-2xl hover:bg-gray-200 transition">
                    Отправить отзыв
                </button>
            </div>
        </form>
    </div>
</div>
@endsection