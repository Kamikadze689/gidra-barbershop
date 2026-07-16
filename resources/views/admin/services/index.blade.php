@extends('layouts.app')

@section('title', 'Услуги — Админ GIDRA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-10">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2">
            ← Назад в админ-панель
        </a>
        <h1 class="text-4xl font-bold tracking-wide">Услуги</h1>
        <a href="{{ route('admin.services.create') }}" 
           class="bg-white text-black px-8 py-4 rounded-2xl hover:bg-gray-200 transition font-medium">
            + Добавить услугу
        </a>
    </div>

    <div class="bg-[#111] border border-gray-800 rounded-3xl overflow-hidden">
        <div class="table-wrapper">
        <table class="w-full" id="services-table">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-8 py-6 text-left w-12"></th>
                    <th class="px-8 py-6 text-left">Название</th>
                    <th class="px-8 py-6 text-left">Категория</th>
                    <th class="px-8 py-6 text-right">Младший</th>
                    <th class="px-8 py-6 text-right">Мастер</th>
                    <th class="px-8 py-6 text-right">Топ</th>
                    <th class="px-8 py-6 text-center">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr class="border-b border-gray-700 hover:bg-[#1a1a1a]" data-id="{{ $service->id }}">
                    <td class="px-8 py-6 text-center cursor-move text-gray-400">↕</td>
                    <td class="px-8 py-6">{{ $service->title }}</td>
                    <td class="px-8 py-6">{{ $service->category }}</td>
                    <td class="px-8 py-6 text-right">{{ number_format($service->price_men, 0, '', ' ') }} ₽</td>
                    <td class="px-8 py-6 text-right">{{ number_format($service->price_master, 0, '', ' ') }} ₽</td>
                    <td class="px-8 py-6 text-right">{{ number_format($service->price_top, 0, '', ' ') }} ₽</td>
                    <td class="px-8 py-6 text-center space-x-6">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-400 hover:text-blue-300">Редактировать</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline" 
                              data-confirm="Удалить услугу?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    new Sortable(document.querySelector('#services-table tbody'), {
        animation: 150,
        ghostClass: 'bg-gray-800',
        onEnd: function () {
            const order = [];
            document.querySelectorAll('#services-table tbody tr').forEach((row, index) => {
                order.push(row.dataset.id);
            });

            fetch('{{ route("admin.services.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: order })
            });
        }
    });
</script>
@endsection