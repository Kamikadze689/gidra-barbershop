@extends('layouts.app')

@section('title', 'Мастера — Админ GIDRA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-10">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2">
            ← Назад в админ-панель
        </a>
        <h1 class="text-4xl font-bold tracking-wide">Мастера</h1>
        <a href="{{ route('admin.masters.create') }}" 
           class="bg-white text-black px-8 py-4 rounded-2xl hover:bg-gray-200 transition font-medium">
            + Добавить мастера
        </a>
    </div>

    
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-3">
            <input type="text" id="searchInput" placeholder="Поиск по имени, специализации..." 
                   class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-5 py-3 text-white w-80 focus:border-white outline-none">
            <select id="sortSelect" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="name_asc">Имя (А-Я)</option>
                <option value="name_desc">Имя (Я-А)</option>
                <option value="experience_asc">Опыт (возрастание)</option>
                <option value="experience_desc">Опыт (убывание)</option>
                <option value="created_asc">Дата добавления (сначала старые)</option>
                <option value="created_desc">Дата добавления (сначала новые)</option>
            </select>
        </div>
        <span class="text-gray-400 text-sm" id="resultCount"></span>
    </div>

    <div class="bg-[#111] border border-gray-800 rounded-3xl overflow-hidden">
        <div class="table-wrapper">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-8 py-6 text-left">Фото</th>
                    <th class="px-8 py-6 text-left">Имя</th>
                    <th class="px-8 py-6 text-left">Специализация</th>
                    <th class="px-8 py-6 text-left">Опыт</th>
                    <th class="px-8 py-6 text-center">Действия</th>
                </tr>
            </thead>
            <tbody id="mastersTableBody">
                @foreach($masters as $master)
                <tr class="border-b border-gray-700 hover:bg-[#1a1a1a]" data-id="{{ $master->id }}">
                    <td class="px-8 py-6">
                        @if($master->photo)
                            <img src="{{ asset('storage/' . ltrim($master->photo, '/')) }}" 
                                 alt="{{ $master->name }}" 
                                 class="w-16 h-16 object-cover rounded-2xl">
                        @else
                            <div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center text-gray-500 text-xs">
                                Нет фото
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-medium">{{ $master->name }}</td>
                    <td class="px-8 py-6">{{ $master->specialization }}</td>
                    <td class="px-8 py-6">{{ $master->experience }}</td>
                    <td class="px-8 py-6 text-center space-x-6">
                        <a href="{{ route('admin.masters.edit', $master) }}" class="text-blue-400 hover:text-blue-300">Редактировать</a>
                        <form method="POST" action="{{ route('admin.masters.destroy', $master) }}" class="inline delete-form" data-confirm="Удалить мастера?">
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

<script>
    const mastersData = @json($masters);
    const csrfToken = '{{ csrf_token() }}';
    const baseUrl = '{{ url('admin/masters') }}';

    function escapeHtml(str) {
        return str ? str.replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m])) : '';
    }

    function filterAndSort() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const sortValue = document.getElementById('sortSelect').value;

        let filtered = mastersData.filter(master =>
            master.name.toLowerCase().includes(searchTerm) ||
            (master.specialization && master.specialization.toLowerCase().includes(searchTerm)) ||
            (master.experience && master.experience.toLowerCase().includes(searchTerm))
        );

        const [sortField, sortOrder] = sortValue.split('_');

        filtered.sort((a, b) => {
            let aVal, bVal;

            if (sortField === 'name') {
                aVal = a.name.toLowerCase();
                bVal = b.name.toLowerCase();
            } 
            else if (sortField === 'experience') {
                const expOrder = { 'Младший мастер': 1, 'Мастер': 2, 'Топ-мастер': 3 };
                aVal = expOrder[a.experience] || 0;
                bVal = expOrder[b.experience] || 0;
            } 
            else if (sortField === 'created') {
                aVal = new Date(a.created_at);
                bVal = new Date(b.created_at);
            }

            if (sortOrder === 'asc') return aVal > bVal ? 1 : (aVal < bVal ? -1 : 0);
            return aVal < bVal ? 1 : (aVal > bVal ? -1 : 0);
        });

        const tbody = document.getElementById('mastersTableBody');
        document.getElementById('resultCount').innerText = `Найдено: ${filtered.length}`;

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-8 py-16 text-center text-gray-400">Ничего не найдено</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(master => `
            <tr class="border-b border-gray-700 hover:bg-[#1a1a1a]">
                <td class="px-8 py-6">
                    ${master.photo 
                        ? `<img src="/storage/${master.photo.replace(/^\/storage\//, '')}" alt="${escapeHtml(master.name)}" class="w-16 h-16 object-cover rounded-2xl">` 
                        : `<div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center text-gray-500 text-xs">Нет фото</div>`}
                </td>
                <td class="px-8 py-6 font-medium">${escapeHtml(master.name)}</td>
                <td class="px-8 py-6">${escapeHtml(master.specialization || '')}</td>
                <td class="px-8 py-6">${escapeHtml(master.experience || '')}</td>
                <td class="px-8 py-6 text-center space-x-6">
                    <a href="${baseUrl}/${master.id}/edit" 
                       class="text-blue-400 hover:text-blue-300">Редактировать</a>
                    
                    <form method="POST" action="${baseUrl}/${master.id}" class="inline delete-form"
      data-confirm="Удалить мастера?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300">Удалить</button>
                    </form>
                </td>
            </tr>
        `).join('');
        initDeleteModals();
    }

    
    document.getElementById('searchInput').addEventListener('input', filterAndSort);
    document.getElementById('sortSelect').addEventListener('change', filterAndSort);
    filterAndSort();
</script>
@endsection