<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
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
        Subject::create($request->all());
        return redirect()->route('subjects.index')->with('message', __('Predmet uspešno kreiran'));
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
        $subject->update(['name' => $request->name]);
        return redirect()->route('subjects.index')->with('message', __('Predmet izmenjen'));
    }

    public function destroy(Subject $subject)
    {
        //
    }
}
