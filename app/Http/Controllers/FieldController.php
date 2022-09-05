<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Field;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = in_array(Auth::user()->lang, ['sr', 'sr_lat', 'sr_cir']) ? ['sr', 'sr_lat', 'sr_cir'] : [Auth::user()->lang];

        if(!in_array(Subject::findOrFail($request->subject_id)->lang, $lang)){
            return abort('404');
        }

        return view('pages.fields.index', [
            'fields' => Field::whereIn('lang', $lang)->where('subject_id', $request->subject_id)->get(),
            'subject_name' => Subject::findOrFail($request->subject_id)->name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Field::create($request->all());
        return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('message', __('Oblast kreirana'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        return view('pages.fields.edit', ['field' => $field]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $field->update(['name' => $request->name]);
        return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('message', __('Oblast izmenjena'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Field $field)
    {
        try{
            $field->delete();
        return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('message', __('Oblast obrisana'));
        } catch(Exception $e){
            return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }
}
