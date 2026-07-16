@extends('layouts.app')
@section('title', 'Отзывы на модерацию — Админ GIDRA')
@section('content')
<div class="max-w-[95%] mx-auto py-12 px-6">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2 mb-6">
        ← Назад в админ-панель
    </a>
    
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-5xl font-bold">Отзывы на модерацию</h1>
        <span class="text-gray-400 text-sm" id="totalCount">На модерации: {{ $reviews->count() }}</span>
    </div>
    
    
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-3 flex-wrap">
            <input type="text" id="searchInput" placeholder="Поиск по имени, отзыву, мастеру..." 
                   class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-5 py-3 text-white w-80 focus:border-white outline-none">
            <select id="sortSelect" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="date_desc">Дата (сначала новые)</option>
                <option value="date_asc">Дата (сначала старые)</option>
                <option value="name_asc">Клиент (А-Я)</option>
                <option value="name_desc">Клиент (Я-А)</option>
            </select>
        </div>
        <span class="text-gray-400 text-sm" id="resultCount"></span>
    </div>

    <div class="bg-[#111] rounded-3xl overflow-hidden">
        <div class="table-wrapper">        
        <table class="w-full table-auto">
            <thead>
                <tr class="border-b border-gray-700 bg-[#1a1a1a]">
                    <th class="px-6 py-5 text-left text-sm font-medium">Дата и время</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Клиент</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Отзыв</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Мастер</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Услуги</th>
                    <th class="px-6 py-5 text-center text-sm font-medium">Действия</th>
                </tr>
            </thead>
            <tbody id="reviewsTableBody">
                @foreach($reviews as $review)
                <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors review-row" data-name="{{ $review->name }}" data-text="{{ $review->text }}" data-master="{{ $review->booking->master->name ?? '' }}" data-date="{{ $review->created_at }}">
                    <td class="px-6 py-5 whitespace-nowrap">{{ $review->created_at ? $review->created_at->format('d.m.Y H:i') : $review->date->format('d.m.Y') }}</td>
                    <td class="px-6 py-5 whitespace-nowrap font-medium">{{ $review->name }}</td>
                    <td class="px-6 py-5">
                        <div class="max-w-md">
                            <p class="text-gray-300 line-clamp-2">{{ $review->text }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $review->booking->master->name ?? '—' }}</td>
                    <td class="px-6 py-5">
                        @if($review->booking && $review->booking->services->count() > 0)
                            @foreach($review->booking->services as $service)
                                <div class="text-sm">{{ $service->title }}</div>
                            @endforeach
                        @else
                            <span class="text-gray-600">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-sm transition-colors duration-200">✅ Одобрить</button>
                            </form>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline" data-confirm="Удалить отзыв?">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm transition-colors duration-200">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div> 
        @if($reviews->isEmpty())
            <div class="text-center py-20" id="emptyState">
                <p class="text-gray-400 text-lg">Нет отзывов на модерацию</p>
            </div>
        @endif
    </div>
</div>

<script>
    const reviewsData = @json($reviews);
    
    function formatDateTime(dateStr) {
        if (!dateStr) return '—';
        const date = new Date(dateStr);
        return date.toLocaleString('ru-RU', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    function filterAndSortReviews() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const sortValue = document.getElementById('sortSelect').value;
        
        let filtered = reviewsData.filter(review => {
            return review.name.toLowerCase().includes(searchTerm) ||
                   review.text.toLowerCase().includes(searchTerm) ||
                   (review.booking?.master?.name || '').toLowerCase().includes(searchTerm);
        });
        
        const [sortField, sortOrder] = sortValue.split('_');
        
        filtered.sort((a, b) => {
            if (sortField === 'date') {
                const aVal = new Date(a.created_at || a.date);
                const bVal = new Date(b.created_at || b.date);
                return sortOrder === 'asc' ? aVal - bVal : bVal - aVal;
            } else if (sortField === 'name') {
                return sortOrder === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name);
            }
            return 0;
        });
        
        const tbody = document.getElementById('reviewsTableBody');
        const resultSpan = document.getElementById('resultCount');
        resultSpan.innerText = `Найдено: ${filtered.length}`;
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="px-8 py-16 text-center text-gray-400">Ничего не найдено</td></tr>';
            return;
        }
        
        tbody.innerHTML = filtered.map(review => `
            <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors">
                <td class="px-6 py-5 whitespace-nowrap">${formatDateTime(review.created_at || review.date)}</td>
                <td class="px-6 py-5 whitespace-nowrap font-medium">${escapeHtml(review.name)}</td>
                <td class="px-6 py-5"><div class="max-w-md"><p class="text-gray-300 line-clamp-2">${escapeHtml(review.text)}</p></div></td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(review.booking?.master?.name || '—')}</td>
                <td class="px-6 py-5">${review.booking?.services?.map(s => `<div class="text-sm">${escapeHtml(s.title)}</div>`).join('') || '<span class="text-gray-600">—</span>'}</td>
                <td class="px-6 py-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <form method="POST" action="/admin/reviews/${review.id}/approve" class="inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-sm">✅ Одобрить</button>
                        </form>
                        <form method="POST" action="/admin/reviews/${review.id}" class="inline delete-form"
data-confirm="Удалить отклик?">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
        `).join('');
        initDeleteModals();
    }
    
    function escapeHtml(str) { 
        if (!str) return ''; 
        return str.replace(/[&<>]/g, function(m) { 
            if (m === '&') return '&amp;'; 
            if (m === '<') return '&lt;'; 
            if (m === '>') return '&gt;'; 
            return m; 
        }); 
    }
    
    document.getElementById('searchInput').addEventListener('input', filterAndSortReviews);
    document.getElementById('sortSelect').addEventListener('change', filterAndSortReviews);
    filterAndSortReviews();
</script>

<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection