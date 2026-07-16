<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|in:Основные услуги,Дополнительные услуги',
            'price_men'  => 'required|integer|min:0',
            'price_master'=> 'required|integer|min:0',
            'price_top'  => 'required|integer|min:0',
            'duration'   => 'required|integer|min:1',
        ]);

        $maxOrder = Service::max('sort_order') ?? 0;

        Service::create([
            'title'       => $request->title,
            'category'    => $request->category,
            'price_men'   => $request->price_men,
            'price_master'=> $request->price_master,
            'price_top'   => $request->price_top,
            'duration'    => $request->duration,
            'sort_order'  => $maxOrder + 1,
        ]);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга успешно добавлена');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|in:Основные услуги,Дополнительные услуги',
            'price_men'  => 'required|integer|min:0',
            'price_master'=> 'required|integer|min:0',
            'price_top'  => 'required|integer|min:0',
            'duration'   => 'required|integer|min:1',
        ]);

        $service->update($request->only(['title', 'category', 'price_men', 'price_master', 'price_top', 'duration']));

        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга успешно обновлена');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга удалена');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $id) {
            Service::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}