<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index() { return view('admin.vacancies.index', ['vacancies' => Vacancy::all()]); }
    public function create() { return view('admin.vacancies.create'); }
    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required', 'description' => 'required', 'requirements' => 'required', 'conditions' => 'required']);
        Vacancy::create($data);
        return redirect()->route('admin.vacancies.index')->with('success', 'Вакансия добавлена');
    }
     
}