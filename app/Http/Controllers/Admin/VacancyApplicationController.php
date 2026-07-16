<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\VacancyApplication;

class VacancyApplicationController extends Controller
{
    public function index()
    {
        $applications = VacancyApplication::with('vacancy')->latest()->get();
        return view('admin.vacancy-applications', compact('applications'));
    }

    public function markReviewed(VacancyApplication $application)
    {
        $application->update(['status' => 'reviewed']);
        return back()->with('success', 'Отклик отмечен как просмотренный');
    }

    public function destroy(VacancyApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Отклик удален');
    }
}