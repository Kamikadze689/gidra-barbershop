@extends('layouts.app')
@section('title', 'Оставить отзыв — GIDRA')
@section('content')
<div class="max-w-2xl mx-auto py-20 px-6">
    <h1 class="text-5xl font-bold mb-12 text-center">Оставить отзыв</h1>
    <form method="POST" action="{{ route('review.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Ваше имя" required class="w-full bg-[#111] p-6 rounded-2xl mb-6 text-lg">
        <textarea name="text" rows="6" placeholder="Ваш отзыв..." required class="w-full bg-[#111] p-6 rounded-2xl mb-8 text-lg"></textarea>
        <button type="submit" class="w-full py-6 bg-white text-black uppercase text-xl tracking-widest">Отправить отзыв на модерацию</button>
    </form>
</div>
@endsection