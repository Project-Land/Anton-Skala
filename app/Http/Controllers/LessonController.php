<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Field;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $lang = in_array(Auth::user()->lang, ['sr', 'sr_lat', 'sr_cir']) ? ['sr_lat', 'sr_cir'] : [Auth::user()->lang];

        return view('pages.lessons.index', [
            'lessons' => Lesson::whereIn('lang', $lang)->where('field_id', $request->field_id)->get(),
            'subject_name' => Field::findOrFail($request->field_id)->subject->name,
            'subject_id' => Field::findOrFail($request->field_id)->subject_id,
            'field_name' => Field::findOrFail($request->field_id)->name,
            'field_id' => Field::findOrFail($request->field_id)->id,
        ]);
    }

    public function create()
    {
        return view('pages.lessons.create');
    }

    public function store(Request $request)
    {
        if ($request->image) {
            $request->validate([
                'image' => 'max:500|mimes:jpg,png,webp,gif'
            ], [
                'image.max' => __('Slika ne sme biti veća od 500kb'),
                'image.mimes' => __('Neispravan format. Dozvoljeni formati: .jpg, .png, .webp, .gif')
            ]);

            $image = $request->image;
            $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/covers'), $image_name);
            $cover_image = "images/covers/" . $image_name;
        } else {
            $cover_image = null;
        }

        Lesson::create($request->except('image') + ['image' => $cover_image]);
        return redirect()->route('lessons.index', ['field_id' => $request->field_id])->with('message', __('Lekcija kreirana'));
    }

    public function show($id)
    {
        abort(404);
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('pages.lessons.edit', ['lesson' => $lesson]);
    }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        if ($request->image) {
            $request->validate([
                'image' => 'max:500|mimes:jpg,png,webp,gif'
            ], [
                'image.max' => __('Slika ne sme biti veća od 500kb'),
                'image.mimes' => __('Neispravan format. Dozvoljeni formati: .jpg, .png, .webp, .gif')
            ]);

            if ($lesson->image) {
                unlink($lesson->image);
            }

            $image = $request->image;
            $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/covers'), $image_name);
            $cover_image = "images/covers/" . $image_name;
        } else {
            $cover_image = $lesson->image;
        }

        $lesson->update(['name' => $request->name, 'lang' => $request->lang, 'image' => $cover_image]);
        return redirect()->route('tasks.index', ['lesson_id' => $lesson->id])->with('message', __('Lekcija izmenjena'));
    }

    public function destroy(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        try {
            $lesson->delete();
            return redirect()->route('lessons.index', ['field_id' => $request->field_id])->with('message', __('Lekcija obrisana'));
        } catch (Exception $e) {
            return redirect()->route('lessons.index', ['field_id' => $request->field_id])->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }
}
