<?php

namespace App\Http\Controllers;

use App\Models\VacancyApplication;
use App\Models\Vacancy;
use App\Mail\VacancyApplicationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VacancyController extends Controller
{
    public function index()
    {
        return view('pages.vacancies', [
            'vacancies' => Vacancy::all()
        ]);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response.required' => 'Подтвердите, что вы не робот',
            'g-recaptcha-response.captcha' => 'Ошибка проверки капчи'
        ]);
        
         
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'vacancy_id' => 'required|exists:vacancies,id',
            'email' => 'nullable|email'
        ]);
        
         
        $data['phone'] = $phone;

        $application = VacancyApplication::create($data);

        Mail::to('anooneofficial@gmail.com')
            ->send(new VacancyApplicationMail([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? 'не указан',
                'vacancy_id' => $data['vacancy_id']
            ]));

        return back()->with('success', 'Отклик отправлен! Мы свяжемся с вами.');
    }
}