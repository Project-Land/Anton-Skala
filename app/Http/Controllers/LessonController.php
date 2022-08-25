<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = Auth::user()->lang == 'sr' ? ['sr_lat', 'sr_cir'] : [Auth::user()->lang];

        return view('pages.lessons.index', [
            'lessons' => Lesson::whereIn('lang', $lang)->where('field_id', $request->field_id)->get(),
            'subject_name' => Field::findOrFail($request->field_id)->subject->name,
            'subject_id' => Field::findOrFail($request->field_id)->subject_id,
            'field_name' => Field::findOrFail($request->field_id)->name,
            'field_id' => Field::findOrFail($request->field_id)->id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.lessons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Lesson::create($request->all());
        return redirect()->route('lessons.index', ['field_id' => $request->field_id])->with('message', __('Lekcija kreirana'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
