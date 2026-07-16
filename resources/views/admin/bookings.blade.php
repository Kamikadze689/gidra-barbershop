@extends('layouts.app')
@section('title', 'Записи — Админ GIDRA')
@section('content')
<div class="max-w-[95%] mx-auto py-12 px-6">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2 mb-6">
        ← Назад в админ-панель
    </a>

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-5xl font-bold">Записи на стрижку</h1>

        <div class="flex items-center gap-4">
            <a href="{{ route('admin.bookings.export.form') }}"
            class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-5 py-3 text-white focus:border-white outline-none">
                Экспорт
            </a>

            <span class="text-gray-400 text-sm">
                Всего записей: {{ $bookings->count() }}
            </span>
        </div>
    </div>
    
    
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-3 flex-wrap">
            <input type="text" id="searchInput" placeholder="Поиск по клиенту, телефону, мастеру..." 
                   class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-5 py-3 text-white w-80 focus:border-white outline-none">
            <select id="sortSelect" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="date_desc">Дата (сначала новые)</option>
                <option value="date_asc">Дата (сначала старые)</option>
                <option value="name_asc">Клиент (А-Я)</option>
                <option value="name_desc">Клиент (Я-А)</option>
                <option value="status">Статус</option>
            </select>
            <select id="statusFilter" class="bg-[#1a1a1a] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-white outline-none">
                <option value="all">Все статусы</option>
                <option value="pending" selected>Ожидает</option>
                <option value="confirmed">Подтверждена</option>
                <option value="completed">Выполнена</option>
                <option value="cancelled">Отменена</option>
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
                    <th class="px-6 py-5 text-left text-sm font-medium">Мастер</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Услуги</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Клиент</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Телефон</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Статус</th>
                    <th class="px-6 py-5 text-left text-sm font-medium">Отзыв</th>
                    <th class="px-6 py-5 text-center text-sm font-medium">Действия</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                @foreach($bookings as $booking)
                <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors">
                    <td class="px-6 py-5 whitespace-nowrap">{{ $booking->start_time->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $booking->master->name }}</td>
                    <td class="px-6 py-5">
                        @foreach($booking->services as $service)
                            <div class="text-sm">{{ $service->title }}</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $booking->customer_name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $booking->formatted_phone }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ $booking->customer_email ?: '—' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($booking->status == 'pending') bg-yellow-500/20 text-yellow-400 border border-yellow-500/50
                            @elseif($booking->status == 'confirmed') bg-green-500/20 text-green-400 border border-green-500/50
                            @elseif($booking->status == 'completed') bg-blue-500/20 text-blue-400 border border-blue-500/50
                            @else bg-red-500/20 text-red-400 border border-red-500/50 @endif">
                            @if($booking->status == 'pending') Ожидает
                            @elseif($booking->status == 'confirmed') Подтверждена
                            @elseif($booking->status == 'completed') Выполнена
                            @else Отменена @endif
                        </span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        ${booking.review ? '<span class="text-green-400 text-sm">✓ Оставлен</span>' : 
                        (booking.status === 'completed' && booking.review_sent ? '<span class="text-yellow-400 text-sm">На модерации</span>' :
                        (booking.status === 'completed' && !booking.review_sent ? 
                            (booking.customer_email ? '<span class="text-blue-400 text-sm">Письмо отправлено</span>' : 
                            `<a href="/review/${booking.review_token || ''}" target="_blank" class="text-green-400 hover:text-green-300 underline text-sm">Ссылка для отзыва</a>`) : 
                            '<span class="text-gray-600 text-sm">—</span>'))}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="bg-[#222] text-white rounded-xl px-3 py-2 text-sm border border-gray-700 focus:border-white cursor-pointer">
                                    <option value="pending" @selected($booking->status=='pending')>Ожидает</option>
                                    <option value="confirmed" @selected($booking->status=='confirmed')>Подтверждена</option>
                                    <option value="completed" @selected($booking->status=='completed')>Выполнена</option>
                                    <option value="cancelled" @selected($booking->status=='cancelled')>Отменена</option>
                                </select>
                            </form>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="inline" data-confirm="Удалить запись?">
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
        @if($bookings->isEmpty())
            <div class="text-center py-20" id="emptyState">
                <p class="text-gray-400 text-lg">Нет записей на стрижку</p>
                <a href="{{ route('booking') }}" class="inline-block mt-4 text-white underline">Создать первую запись</a>
            </div>
        @endif
    </div>
</div>

<script>
    const bookingsData = @json($bookings);
    
    function filterAndSortBookings() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const sortValue = document.getElementById('sortSelect').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        let filtered = bookingsData.filter(booking => {
            const matchesSearch = booking.customer_name.toLowerCase().includes(searchTerm) ||
                booking.customer_phone.includes(searchTerm) ||
                (booking.master?.name || '').toLowerCase().includes(searchTerm);
            const matchesStatus = statusFilter === 'all' || booking.status === statusFilter;
            return matchesSearch && matchesStatus;
        });
        
        const [sortField, sortOrder] = sortValue.split('_');
        
        filtered.sort((a, b) => {
            if (sortField === 'date') {
                const aVal = new Date(a.start_time);
                const bVal = new Date(b.start_time);
                return sortOrder === 'asc' ? aVal - bVal : bVal - aVal;
            } else if (sortField === 'name') {
                return sortOrder === 'asc' ? a.customer_name.localeCompare(b.customer_name) : b.customer_name.localeCompare(a.customer_name);
            } else if (sortField === 'status') {
                const statusOrder = { 'pending': 1, 'confirmed': 2, 'completed': 3, 'cancelled': 4 };
                return (statusOrder[a.status] || 0) - (statusOrder[b.status] || 0);
            }
            return 0;
        });
        
        const tbody = document.getElementById('bookingsTableBody');
        document.getElementById('resultCount').innerText = `Найдено: ${filtered.length}`;
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="px-8 py-16 text-center text-gray-400">Ничего не найдено</td></tr>';
            return;
        }
        
        tbody.innerHTML = filtered.map(booking => {
            const statusClass = { 'pending': 'bg-yellow-500/20 text-yellow-400 border-yellow-500/50', 'confirmed': 'bg-green-500/20 text-green-400 border-green-500/50', 'completed': 'bg-blue-500/20 text-blue-400 border-blue-500/50', 'cancelled': 'bg-red-500/20 text-red-400 border-red-500/50' }[booking.status];
            const statusText = { 'pending': 'Ожидает', 'confirmed': 'Подтверждена', 'completed': 'Выполнена', 'cancelled': 'Отменена' }[booking.status];
            
            let reviewHtml = '';
            if (booking.review) {
                reviewHtml = '<span class="text-green-400 text-sm">✓ Оставлен</span>';
            } else if (booking.status === 'completed' && booking.review_sent) {
                reviewHtml = '<span class="text-yellow-400 text-sm">На модерации</span>';
            } else if (booking.status === 'completed' && !booking.review_sent) {
                if (booking.customer_email) {
                    reviewHtml = '<span class="text-blue-400 text-sm">Письмо отправлено</span>';
                } else {
                    reviewHtml = `<a href="/review/${booking.review_token || ''}" target="_blank" class="text-green-400 hover:text-green-300 underline text-sm">Ссылка для отзыва</a>`;
                }
            } else {
                reviewHtml = '<span class="text-gray-600 text-sm">—</span>';
            }
            
            return `
            <tr class="border-b border-gray-700 hover:bg-[#1a1a1a] transition-colors">
                <td class="px-6 py-5 whitespace-nowrap">${new Date(booking.start_time).toLocaleString('ru-RU')}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(booking.master?.name || '—')}</td>
                <td class="px-6 py-5">${booking.services?.map(s => `<div class="text-sm">${escapeHtml(s.title)}</div>`).join('') || ''}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(booking.customer_name)}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(booking.customer_phone)}</td>
                <td class="px-6 py-5 whitespace-nowrap">${escapeHtml(booking.customer_email) || '—'}</td>
                <td class="px-6 py-5 whitespace-nowrap"><span class="px-3 py-1 rounded-full text-xs font-medium ${statusClass}">${statusText}</span></td>
                <td class="px-6 py-5 whitespace-nowrap">${reviewHtml}</td>
                <td class="px-6 py-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <form method="POST" action="/admin/bookings/${booking.id}/status" class="inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <select name="status" onchange="this.form.submit()" class="bg-[#222] text-white rounded-xl px-3 py-2 text-sm border border-gray-700">
                                <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Ожидает</option>
                                <option value="confirmed" ${booking.status === 'confirmed' ? 'selected' : ''}>Подтверждена</option>
                                <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Выполнена</option>
                                <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Отменена</option>
                            </select>
                        </form>
                        <form method="POST" action="/admin/bookings/${booking.id}" class="inline delete-form"
data-confirm="Удалить отклик?">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm">🗑️</button>
                        </form>
                    </div>
                </td>
             </tr>
            `;
        }).join('');
        initDeleteModals();
    }
    
    function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function(m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }
    
    document.getElementById('searchInput').addEventListener('input', filterAndSortBookings);
    document.getElementById('sortSelect').addEventListener('change', filterAndSortBookings);
    document.getElementById('statusFilter').addEventListener('change', filterAndSortBookings);
    filterAndSortBookings();
</script>
@endsection