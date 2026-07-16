<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $masters = Master::all();
        return view('admin.masters.index', compact('masters'));
    }

    public function create()
    {
        return view('admin.masters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience'     => 'required|in:Младший мастер,Мастер,Топ-мастер',
            'review_link'    => 'nullable|url',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'specialization', 'experience', 'review_link']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('masters', 'public');
        }

        Master::create($data);

        return redirect()->route('admin.masters.index')
                         ->with('success', 'Мастер успешно добавлен');
    }

    public function edit(Master $master)
    {
        return view('admin.masters.edit', compact('master'));
    }

     
    public function update(Request $request, Master $master)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience'     => 'required|in:Младший мастер,Мастер,Топ-мастер',
            'review_link'    => 'nullable|url',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'specialization', 'experience', 'review_link']);

         
        if ($master->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('photo')) {
            if ($master->photo && Storage::disk('public')->exists($master->photo)) {
                Storage::disk('public')->delete($master->photo);
            }
            $data['photo'] = $request->file('photo')->store('masters', 'public');
        }

        $master->update($data);

        return redirect()->route('admin.masters.index')
                        ->with('success', 'Мастер успешно обновлён');
    }

    public function destroy(Master $master)
    {
        try {
             
            if ($master->photo && \Storage::disk('public')->exists($master->photo)) {
                \Storage::disk('public')->delete($master->photo);
            }
            
            $master->delete();
            
            return redirect()->route('admin.masters.index')
                            ->with('success', 'Мастер успешно удалён');
        } catch (\Exception $e) {
            return redirect()->route('admin.masters.index')
                            ->with('error', 'Ошибка при удалении мастера: ' . $e->getMessage());
        }
    }
}