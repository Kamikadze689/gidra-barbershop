@extends('layouts.app')

@section('title', 'Записаться на стрижку — GIDRA')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <h1 class="text-6xl font-black tracking-widest">ЗАПИСАТЬСЯ</h1>
        <p class="text-gray-400 mt-4 text-xl">Выберите мастера и услуги</p>
    </div>

    <div class="bg-[#111] border border-gray-800 rounded-3xl p-14">
        <form method="POST" action="{{ route('booking.store') }}" id="booking-form">
            @csrf

            
            <div id="form-alert" class="hidden mb-6 p-5 rounded-2xl border transition-all duration-300"></div>

            <div class="grid md:grid-cols-2 gap-12">
                
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-4">Мастер</label>
                    <select name="master_id" id="master_id" required 
                            class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-2xl px-5 py-3 text-white text-lg">
                        <option value="">Выберите мастера</option>
                        @foreach($masters as $master)
                            <option value="{{ $master->id }}" {{ $preselectedMaster == $master->id ? 'selected' : '' }}>
                                {{ $master->name }} — {{ $master->experience }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-4">Услуги (можно несколько)</label>
                    <div id="services-list" class="grid grid-cols-1 gap-4 max-h-[460px] overflow-y-auto pr-2">
                        @foreach($services as $service)
                        <div class="service-card bg-[#1a1a1a] border border-gray-700 hover:border-gray-500
                         rounded-2xl p-4 transition-all cursor-pointer flex items-center gap-5"
                             data-price-men="{{ $service->price_men }}"
                             data-price-master="{{ $service->price_master }}"
                             data-price-top="{{ $service->price_top }}">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                   class="w-5 h-5 accent-white mt-0.5">
                            <div class="flex-1">
                                <div class="font-medium text-lg">{{ $service->title }}</div>
                                <div class="text-sm text-gray-400">{{ $service->duration }} мин</div>
                                <div id="price-display-{{ $service->id }}" class="text-white font-medium mt-2 text-lg">
                                    от {{ number_format($service->price_men, 0, '', ' ') }} ₽
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            
            <div class="mt-14">
                <label class="block text-sm uppercase tracking-widest text-gray-400 mb-4">Дата и время</label>
                <div class="flex gap-10">
                    <div class="flex-1">
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">День</label>
                        <div id="date-picker" class="grid grid-cols-7 gap-3"></div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Время</label>
                        <div id="time-slots" class="grid grid-cols-3 gap-4 min-h-[300px]"></div>
                        <input type="hidden" name="start_time" id="start_time_hidden" required>
                    </div>
                </div>
            </div>

            
            <div class="grid md:grid-cols-3 gap-6 mt-14">
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Имя</label>
                    <input type="text" name="customer_name" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-2xl px-5 py-3 text-white">
                </div>
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Телефон</label>
                    <input type="tel" name="customer_phone" required 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-2xl px-5 py-3 text-white">
                </div>
                <div>
                    <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Email (необязательно)</label>
                    <input type="email" name="customer_email" 
                           class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-2xl px-5 py-3 text-white">
                </div>
            </div>

            
            <div class="mt-8">
                <div class="captcha-wrapper">
                    <div class="flex justify-center">
                        {!! NoCaptcha::display([
                            'theme' => 'dark',
                            'data-theme' => 'dark'
                        ]) !!}
                    </div>
                </div>
                @error('g-recaptcha-response')
                    <p class="text-red-500 text-sm text-center mt-3">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="mt-8 w-full py-4 bg-white text-black uppercase tracking-widest text-xl font-medium rounded-2xl hover:bg-gray-100 transition">
                Отправить заявку на запись
            </button>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const masterSelect = document.getElementById('master_id');
    const datePicker = document.getElementById('date-picker');
    const timeSlotsContainer = document.getElementById('time-slots');
    const startTimeHidden = document.getElementById('start_time_hidden');
    let selectedDate = null;

    function generateDatePicker() {
        datePicker.innerHTML = '';
        const today = new Date();

        for (let i = 0; i < 14; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            const dayEl = document.createElement('div');
            dayEl.className = `text-center py-2 rounded-2xl cursor-pointer transition-all border border-transparent hover:border-gray-600 ${i === 0 ? 'bg-white text-black' : 'bg-[#1a1a1a]'}`;
            dayEl.innerHTML = `
                <div class="text-xs text-gray-400">${date.toLocaleString('ru-RU', {weekday: 'short'})}</div>
                <div class="text-2xl font-medium">${date.getDate()}</div>
            `;

            dayEl.onclick = function() {
                document.querySelectorAll('#date-picker > div').forEach(el => el.classList.remove('bg-white', 'text-black'));
                this.classList.add('bg-white', 'text-black');
                selectedDate = date.toISOString().split('T')[0];
                loadAvailableSlots();
            };
            datePicker.appendChild(dayEl);
        }
    }

    function loadAvailableSlots() {
        const masterId = masterSelect.value;
        if (!masterId || !selectedDate) return;

        fetch(`/available-slots?master_id=${masterId}&date=${selectedDate}`)
            .then(r => r.json())
            .then(slots => {
                timeSlotsContainer.innerHTML = '';

                if (slots.length === 0) {
                    timeSlotsContainer.innerHTML = '<p class="col-span-4 text-gray-400 text-center py-12">Нет свободного времени на этот день</p>';
                    return;
                }

                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'py-3 bg-[#1a1a1a] border border-gray-700 hover:border-white rounded-2xl text-base transition font-medium';
                    btn.textContent = slot;
                    btn.onclick = () => {
                        startTimeHidden.value = selectedDate + ' ' + slot;
                        document.querySelectorAll('#time-slots button').forEach(b => b.classList.remove('bg-white', 'text-black'));
                        btn.classList.add('bg-white', 'text-black');
                    };
                    timeSlotsContainer.appendChild(btn);
                });
            });
    }

    masterSelect.addEventListener('change', () => {
        const masterExp = masterSelect.options[masterSelect.selectedIndex].text.split('—')[1]?.trim() || '';

        document.querySelectorAll('.service-card').forEach(card => {
            let price = parseInt(card.dataset.priceMen);
            if (masterExp.includes('Топ')) price = parseInt(card.dataset.priceTop);
            else if (masterExp.includes('Мастер')) price = parseInt(card.dataset.priceMaster);

            const priceEl = card.querySelector('[id^="price-display-"]');
            if (priceEl) priceEl.textContent = `${price} ₽`;
        });

        if (selectedDate) loadAvailableSlots();
    });

    generateDatePicker();
});

document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="customer_phone"]');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            let formattedValue = '';
            if (value.length > 0) {
                if (value.length >= 1) formattedValue = value[0];
                if (value.length >= 2) formattedValue += ' (' + value.slice(1, 4);
                if (value.length >= 5) formattedValue += ') ' + value.slice(4, 7);
                if (value.length >= 8) formattedValue += '-' + value.slice(7, 9);
                if (value.length >= 10) formattedValue += '-' + value.slice(9, 11);
            }
            e.target.value = formattedValue;
        });
        
        phoneInput.addEventListener('keydown', function(e) {
            const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Escape', 'Enter', 'Home', 'End'];
            if (allowedKeys.includes(e.key) || (e.key >= '0' && e.key <= '9')) return;
            e.preventDefault();
        });
        
        phoneInput.addEventListener('focus', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
        
        phoneInput.addEventListener('blur', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                let formattedValue = '';
                if (value.length >= 1) formattedValue = value[0];
                if (value.length >= 2) formattedValue += ' (' + value.slice(1, 4);
                if (value.length >= 5) formattedValue += ') ' + value.slice(4, 7);
                if (value.length >= 8) formattedValue += '-' + value.slice(7, 9);
                if (value.length >= 10) formattedValue += '-' + value.slice(9, 11);
                e.target.value = formattedValue;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('booking-form');
    const alertDiv = document.getElementById('form-alert');
    
    function showAlert(message, type = 'error') {
        alertDiv.classList.remove('hidden', 'border-red-500', 'border-green-500', 'bg-red-500/10', 'bg-green-500/10');
        
        if (type === 'error') {
            alertDiv.classList.add('border-red-500', 'bg-red-500/10');
            alertDiv.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-red-400">${message}</span>
                </div>
            `;
        } else {
            alertDiv.classList.add('border-green-500', 'bg-green-500/10');
            alertDiv.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-400">${message}</span>
                </div>
            `;
        }
        
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        if (type === 'success') {
            setTimeout(() => {
                alertDiv.classList.add('hidden');
            }, 5000);
        }
    }
    
    function hideAlert() {
        alertDiv.classList.add('hidden');
    }

    @if(session('success'))
        showAlert('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showAlert('{{ session('error') }}', 'error');
    @endif
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            let hasErrors = false;
            let errorMessage = '';
            
            const masterId = document.getElementById('master_id').value;
            if (!masterId) {
                errorMessage = 'Выберите мастера';
                hasErrors = true;
            }
            
            const selectedServices = document.querySelectorAll('input[name="service_ids[]"]:checked');
            if (!hasErrors && selectedServices.length === 0) {
                errorMessage = 'Выберите хотя бы одну услугу';
                hasErrors = true;
            }
            
            const startTime = document.getElementById('start_time_hidden').value;
            if (!hasErrors && !startTime) {
                errorMessage = 'Выберите дату и время записи';
                hasErrors = true;
            }
            
            const customerName = document.querySelector('input[name="customer_name"]').value.trim();
            if (!hasErrors && !customerName) {
                errorMessage = 'Введите ваше имя';
                hasErrors = true;
            }
            
            const customerPhone = document.querySelector('input[name="customer_phone"]').value.trim();
            if (!hasErrors && !customerPhone) {
                errorMessage = 'Введите номер телефона';
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                showAlert(errorMessage, 'error');
            } else {
                const submitBtn = bookingForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Отправка...';
                }
            }
        });
    }
});
</script>