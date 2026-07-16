@extends('layouts.app')

@section('title', 'Вакансии GIDRA')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <h1 class="text-6xl font-black tracking-widest">ВАКАНСИИ</h1>
        <p class="text-gray-400 mt-4 text-xl">Присоединяйтесь к команде GIDRA</p>
    </div>

    @foreach($vacancies as $vacancy)
    <div class="bg-[#111] border border-gray-800 rounded-3xl mb-12">
        <div class="grid md:grid-cols-2 gap-8 p-10">
            <div>
                <h2 class="text-3xl font-bold mb-6">{{ $vacancy->title }}</h2>
                <div class="mb-6">
                    <p class="text-gray-300 leading-relaxed">{{ $vacancy->description }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3 text-white">Требования:</h3>
                    <div class="text-gray-400 leading-relaxed space-y-2">
                        {!! nl2br(e($vacancy->requirements)) !!}
                    </div>
                </div>
                <div class="mb-0">
                    <h3 class="text-xl font-semibold mb-3 text-white">Условия:</h3>
                    <div class="text-gray-400 leading-relaxed space-y-2">
                        {!! nl2br(e($vacancy->conditions)) !!}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-center">
                <img src="{{ asset('storage/images/vacancies.jpg') }}" 
                     alt="Работа в GIDRA"
                     class="w-full h-auto max-h-[400px] object-cover rounded-2xl">
            </div>
        </div>
        
        <div class="border-t border-gray-800 p-10">
            <h3 class="text-2xl font-semibold mb-6">Откликнуться на вакансию</h3>
            
            <form method="POST" action="{{ route('vacancies.apply') }}">
                @csrf
                <input type="hidden" name="vacancy_id" value="{{ $vacancy->id }}">
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Ваше имя *</label>
                        <input type="text" name="name"
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Телефон *</label>
                        <input type="tel" name="phone" placeholder="0(000)000-00-00"
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">Email (необязательно)</label>
                        <input type="email" name="email" 
                               class="w-full bg-[#1a1a1a] border border-gray-700 focus:border-white rounded-xl px-4 py-3 text-white">
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
                        class="w-full mt-6 py-4 bg-white text-black uppercase tracking-widest text-xl font-medium rounded-xl hover:bg-gray-200 transition">
                    Отправить отклик
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[name="phone"]');
    
    phoneInputs.forEach(phoneInput => {
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
    });
});


function showVacancyAlert(message, type = 'error') {
    const oldAlert = document.querySelector('.vacancy-alert');
    if (oldAlert) oldAlert.remove();
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `vacancy-alert fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md animate-slide-down`;
    alertDiv.innerHTML = `
        <div class="bg-[#1a1a1a] border ${type === 'error' ? 'border-red-500' : 'border-green-500'} rounded-2xl px-6 py-4 shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6 ${type === 'error' ? 'text-red-500' : 'text-green-500'} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'error' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                }
            </svg>
            <span class="text-gray-300 flex-1">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv) alertDiv.remove();
    }, 5000);
}


document.addEventListener('DOMContentLoaded', function() {
    @if($errors->any())
        @foreach($errors->all() as $error)
            showVacancyAlert('{{ $error }}', 'error');
        @endforeach
    @endif

    @if(session('success'))
        showVacancyAlert('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showVacancyAlert('{{ session('error') }}', 'error');
    @endif
});

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action="{{ route('vacancies.apply') }}"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let hasErrors = false;
            let errorMessage = '';
            
            const name = form.querySelector('input[name="name"]')?.value.trim();
            if (!name) {
                errorMessage = 'Введите ваше имя';
                hasErrors = true;
            }
            
            const phone = form.querySelector('input[name="phone"]')?.value.trim();
            if (!hasErrors && !phone) {
                errorMessage = 'Введите номер телефона';
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                showVacancyAlert(errorMessage, 'error');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.fixed.top-24');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.remove();
        }, 5000);
    });
});
</script>
@endsection