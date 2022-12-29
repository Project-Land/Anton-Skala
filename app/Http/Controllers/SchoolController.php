<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('pages.schools.index', ['schools' => $schools]);
    }

    public function create()
    {
        return view('pages.schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:schools',
            'country' => 'required'
        ], [
            'name.required' => __('Unesite naziv'),
            'name.unique' => __('Već postoji škola sa takvim nazivom'),
            'country.required' => __('Unesite državu')
        ]);

        try {
            School::create([
                'name' => $request->name,
                'country' => $request->country,
            ]);

            return redirect()->route('schools.index')->with('message', __('Škola uspešno kreirana'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja škole: ' . $e->getMessage());
            return redirect()->route('schools.index')->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function show($id)
    {
        abort('404');
    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('pages.schools.edit', ['school' => $school]);
    }

    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'country' => 'required'
        ], [
            'name.required' => __('Unesite naziv'),
            'country.required' => __('Unesite državu')
        ]);

        try {
            $school->update([
                'name' => $request->name,
                'country' => $request->country,
            ]);

            return redirect()->route('schools.index')->with('message', __('Škola uspešno izmenjena'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom izmene škole: ' . $e->getMessage());
            return redirect()->route('schools.index')->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function destroy($id)
    {
        //
    }
}
