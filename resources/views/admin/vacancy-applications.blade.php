@extends('layouts.app')
@section('title', 'Отклики на вакансии — Админ GIDRA')
@section('content')
<div class="max-w-[95%] mx-auto py-12 px-6">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2 mb-6">
        ← Назад в админ-панель
    </a>
    
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-5xl font-bold">Отклики на вакансии</h1>
        <span class="text-gray-400 text-sm" id="totalCount">Всего откликов: {{ $applications->count() }}</span>
    </div>
    
    
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-3 flex-wrap">
            <input type="text" id="searchInput" placeholder="Поиск по имени, телефону, вакансии..." 
                   class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-5 py-3 text-white w-80 focus:border-white outline-none">
            <select id="sortSelect" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="date_desc">Дата (сначала новые)</option>
                <option value="date_asc">Дата (сначала старые)</option>
                <option value="name_asc">Имя (А-Я)</option>
                <option value="name_desc">Имя (Я-А)</option>
            </select>
            <select id="statusFilter" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="all">Все статусы</option>
                <option value="pending">Новые</option>
                <option value="reviewed">Просмотренные</option>
            </select>
        </div>
        <span class="text-gray-400 text-sm" id="resultCount"></span>
    </div>

    <div class="bg-[#111] rounded-3xl overflow-hidden">
        <div class="table-wrapper">
        <table class="w-full table-auto">
            <thead>
                <tr class="border-b border-gray-700 bg-[#1a1a1a]">
                    <th class="px-6 py-5 text-left text-sm font-medium">Дата</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Вакансия</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Имя</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Телефон</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Статус</th>
                    <th class="px-6 py-5 text-center text-sm font-medium">Действия</th>
                </tr>
            </thead>
            <tbody id="applicationsTableBody">
                @foreach($applications as $app)
                <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors">
                    <td class="px-6 py-5 whitespace-nowrap">{{ $app->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $app->vacancy->title ?? '—' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $app->name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $app->phone }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $app->email ?? '—' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $app->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/50' : 'bg-green-500/20 text-green-400 border border-green-500/50' }}">
                            {{ $app->status == 'pending' ? 'Новый' : 'Просмотрено' }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            @if($app->status == 'pending')
                            <form method="POST" action="{{ route('admin.vacancy-applications.mark-reviewed', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-sm">Отметить просмотренным</button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.vacancy-applications.destroy', $app) }}" class="inline" data-confirm="Удалить отклик?">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>        
        @if($applications->isEmpty())
            <div class="text-center py-20" id="emptyState">
                <p class="text-gray-400 text-lg">Нет откликов на вакансии</p>
            </div>
        @endif
    </div>
</div>

<script>
    const applicationsData = @json($applications);
    
    function filterAndSortApps() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const sortValue = document.getElementById('sortSelect').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        let filtered = applicationsData.filter(app => {
            const matchesSearch = app.name.toLowerCase().includes(searchTerm) ||
                app.phone.includes(searchTerm) ||
                (app.vacancy?.title || '').toLowerCase().includes(searchTerm);
            const matchesStatus = statusFilter === 'all' || app.status === statusFilter;
            return matchesSearch && matchesStatus;
        });
        
        const [sortField, sortOrder] = sortValue.split('_');
        
        filtered.sort((a, b) => {
            if (sortField === 'date') {
                const aVal = new Date(a.created_at);
                const bVal = new Date(b.created_at);
                return sortOrder === 'asc' ? aVal - bVal : bVal - aVal;
            } else if (sortField === 'name') {
                return sortOrder === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name);
            }
            return 0;
        });
        
        const tbody = document.getElementById('applicationsTableBody');
        document.getElementById('resultCount').innerText = `Найдено: ${filtered.length}`;
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="px-8 py-16 text-center text-gray-400">Ничего не найдено</td></tr>';
            return;
        }
        
        tbody.innerHTML = filtered.map(app => `
            <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors">
                <td class="px-6 py-5 whitespace-nowrap">${new Date(app.created_at).toLocaleString('ru-RU')}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(app.vacancy?.title || '—')}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(app.name)}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(app.phone)}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(app.email) || '—'}</td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <span class="px-3 py-1 rounded-full text-xs font-medium ${app.status === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/50' : 'bg-green-500/20 text-green-400 border border-green-500/50'}">
                        ${app.status === 'pending' ? 'Новый' : 'Просмотрено'}
                    </span>
                </td>
                <td class="px-6 py-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        ${app.status === 'pending' ? `
                        <form method="POST" action="/admin/vacancy-applications/${app.id}/mark-reviewed" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-sm">Отметить просмотренным</button>
                        </form>` : ''}
                        <form method="POST" action="/admin/vacancy-applications/${app.id}" class="inline delete-form"
data-confirm="Удалить отклик?">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
        `).join('');
        initDeleteModals();
    }
    
    function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function(m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }
    
    document.getElementById('searchInput').addEventListener('input', filterAndSortApps);
    document.getElementById('sortSelect').addEventListener('change', filterAndSortApps);
    document.getElementById('statusFilter').addEventListener('change', filterAndSortApps);
    filterAndSortApps();
</script>
@endsection