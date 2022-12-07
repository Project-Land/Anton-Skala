<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $lang = in_array(Auth::user()->lang, ['sr', 'sr_lat', 'sr_cir']) ? ['sr', 'sr_lat', 'sr_cir'] : [Auth::user()->lang];

        return view('pages.subjects.index', [
            'subjects' => Subject::whereIn('lang', $lang)->get()
        ]);
    }

    public function create()
    {
        return view('pages.subjects.create');
    }

    public function store(Request $request)
    {
        try {
            Subject::create($request->all());
            return redirect()->route('subjects.index')->with('message', __('Predmet uspešno kreiran'));
        } catch (Exception $e){
            Log::error('Greška prilikom kreiranja predmeta: '.$e->getMessage());
            return redirect()->route('subjects.index')->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function show(Subject $subject)
    {
        abort(404);
    }

    public function edit(Subject $subject)
    {
        return view('pages.subjects.edit', [
            'subject' => $subject
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        try {
            $subject->update(['name' => $request->name]);
            return redirect()->route('subjects.index')->with('message', __('Predmet izmenjen'));
        } catch (Exception $e){
            Log::error('Greška prilikom izmene predmeta: '.$e->getMessage());
            return redirect()->route('subjects.index')->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function destroy(Subject $subject)
    {
        //
    }
}
