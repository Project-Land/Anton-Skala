<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Field;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $lang = in_array(Auth::user()->lang, ['sr', 'sr_lat', 'sr_cir']) ? ['sr', 'sr_lat', 'sr_cir'] : [Auth::user()->lang];

        if (!in_array(Subject::findOrFail($request->subject_id)->lang, $lang)) {
            return abort('404');
        }

        return view('pages.fields.index', [
            'fields' => Field::whereIn('lang', $lang)->where('subject_id', $request->subject_id)->get(),
            'subject_name' => Subject::findOrFail($request->subject_id)->name
        ]);
    }

    public function create()
    {
        return view('pages.fields.create');
    }

    public function store(Request $request)
    {
        try {
            $cover_image = null;

            if ($request->image) {
                $request->validate([
                    'image' => 'max:500|mimes:jpg,png,webp,gif'
                ], [
                    'image.max' => __('Slika ne sme biti veća od 500KB'),
                    'image.mimes' => __('Neispravan format. Dozvoljeni formati: .jpg, .png, .webp, .gif')
                ]);

                $image = $request->image;
                $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/covers'), $image_name);
                $cover_image = "images/covers/" . $image_name;
            }

            Field::create($request->except('image') + ['image' => $cover_image]);

            return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('message', __('Oblast kreirana'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja oblasti: ' . $e->getMessage());
            return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function show(Field $field)
    {
        abort(404);
    }

    public function edit(Field $field)
    {
        return view('pages.fields.edit', ['field' => $field]);
    }

    public function update(Request $request, Field $field)
    {
        try {
            $cover_image = $field->image;

            if ($request->image) {
                $request->validate([
                    'image' => 'max:500|mimes:jpg,png,webp,gif'
                ], [
                    'image.max' => __('Slika ne sme biti veća od 500kb'),
                    'image.mimes' => __('Neispravan format. Dozvoljeni formati: .jpg, .png, .webp, .gif')
                ]);

                if ($field->image) {
                    unlink($field->image);
                }

                $image = $request->image;
                $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/covers'), $image_name);
                $cover_image = "images/covers/" . $image_name;
            }

            $field->update(['name' => $request->name, 'image' => $cover_image]);
            return redirect()->route('lessons.index', ['field_id' => $field->id])->with('message', __('Oblast izmenjena'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom izmene oblasti: ' . $e->getMessage());
            return redirect()->route('lessons.index', ['field_id' => $field->id])->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }

    public function destroy(Request $request, Field $field)
    {
        try {
            $field->delete();
            return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('message', __('Oblast obrisana'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom brisanja oblasti: ' . $e->getMessage());
            return redirect()->route('fields.index', ['subject_id' => $request->subject_id])->with('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }
}
