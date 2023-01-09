<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $lesson = Lesson::findOrFail($request->lesson_id);

        return view('pages.tasks.index', [
            'subject_name' => $lesson->field->subject->name,
            'subject_id' => $lesson->field->subject_id,
            'field_name' => $lesson->field->name,
            'field_id' => $lesson->field_id,
            'lesson_id' => $request->lesson_id,
            'lesson_name' => $lesson->name
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.tasks.create', ['lesson_id' => $request->lesson_id]);
    }

    public function createSpecificTask(Request $request)
    {
        if (!view()->exists('pages.tasks.types.' . $request->type)) {
            Log::channel('errors')->error('Pokušaj pristupa stranici za kreiranje zadatka koja ne postoji.');
            return redirect('tasks/create?lesson_id=' . $request->lesson_id)->with('error', __('Izabrani tip zadatka ne postoji.'));
        }

        return view('pages.tasks.types.' . $request->type, [
            'type' => $request->type,
            'lesson_id' => $request->lesson_id
        ]);
    }

    public function storeCorrectAnswerType(Request $request)
    {
        if ($request->question_image == null && $request->question_audio == null && $request->question_text == null) {
            return redirect()->back()->withInput()->with(['error' => __('Unesite pitanje')]);
        }

        try {
            $numberOfAnswers = count($request->answer_text);
            $answers = [];
            $numberOfCorrectAnswers = 0;

            for ($i = 0; $i < $numberOfAnswers; $i++) {
                $request->answer_correct[$i] == 1 ? $numberOfCorrectAnswers++ : $numberOfCorrectAnswers;
                $answers += [
                    $i => [
                        'text' => $request->answer_text[$i],
                        'image' => $request->answer_image[$i] ?? null,
                        'audio' => $request->answer_audio[$i] ?? null,
                        'is_correct' => $request->answer_correct[$i] == 0 ? false : true,
                        'id' => $i + 1
                    ]
                ];
            }

            if (!count(collect($answers)->where('is_correct', true))) {
                return redirect()->back()->withInput()->with(['error' => __('Izaberite bar jedan tačan odgovor')]);
            }

            if ($request->question_image) {
                $image = $request->question_image;
                $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $question_image_path = 'material/images/' . $image_name;
            } else {
                $question_image_path = null;
            }

            if ($request->question_audio) {
                $audio = $request->question_audio;
                $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                $audio->move(public_path('material/audio'), $audio_name);
                $question_audio_path = 'material/audio/' . $audio_name;
            } else {
                $question_audio_path = null;
            }

            $content = [
                'question' => [
                    'text' => $request->question_text,
                    'image' => $question_image_path,
                    'audio' => $question_audio_path,
                    'number_of_correct_answers' => $numberOfCorrectAnswers
                ],
                'answers' => $answers
            ];

            foreach ($content['answers'] as $key => $answer) {
                if ($answer['image']) {
                    $image = $answer['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['answers'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($answer['audio']) {
                    $audio = $answer['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['answers'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeDragAndDropType(Request $request)
    {
        if ($request->question_text[0] == "" && $request->question_image == null && $request->question_audio == null) {
            return back()->with('error', __('Morate popuniti bar jedno polje.'));
        }

        if ($request->answer_text[0] == "" && $request->answer_image == null && $request->answer_audio == null) {
            return back()->withInput()->with('error', __('Morate popuniti bar jedno polje.'));
        }

        try {
            $numberOfAnswers = count($request->answer_text);
            $answers = [];
            $numberOfQuestions = count($request->question_text);
            $questions = [];

            $colors = [
                0 => 'red',
                1 => 'green',
                2 => 'blue',
                3 => 'yellow',
                4 => 'brown',
                5 => 'purple'
            ];

            for ($i = 0; $i < $numberOfAnswers; $i++) {
                $answers += [
                    $i => [
                        'text' => $request->answer_text[$i],
                        'image' => $request->answer_image[$i] ?? null,
                        'audio' => $request->answer_audio[$i] ?? null,
                        'id' => $i + 1,
                        'color' => $request->color_border ? $colors[$i] : null
                    ]
                ];
            }

            for ($i = 0; $i < $numberOfQuestions; $i++) {
                $questions += [
                    $i => [
                        'text' => $request->question_text[$i],
                        'image' => $request->question_image[$i] ?? null,
                        'audio' => $request->question_audio[$i] ?? null,
                        'id' => $i + 1,
                        'color' => $request->color_border ? $colors[$i] : null
                    ]
                ];
            }

            $content = [
                'answers' => $answers,
                'questions' => $questions,
                'color_border' => $request->color_border ? true : false
            ];

            foreach ($content['answers'] as $key => $answer) {
                if ($answer['image']) {
                    $image = $answer['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['answers'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($content['answers'][$key]['audio']) {
                    $audio = $content['answers'][$key]['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['answers'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            foreach ($content['questions'] as $key => $question) {
                if ($question['image']) {
                    $image = $question['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['questions'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($content['questions'][$key]['audio']) {
                    $audio = $content['question'][$key]['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['questions'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeDescriptionType(Request $request)
    {
        $content = [];
        $content['image'] = null;
        $content['text'] = $request->text;

        if ($request->text == "" && $request->file('image') == null) {
            return back()->with('error', __('Morate popuniti bar jedno polje.'));
        }

        try {
            if ($request->file('image')) {
                $image_name = time() . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('material/images'), $image_name);
                $content['image'] = 'material/images/' . $image_name;
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeColumnSortingType(Request $request)
    {
        if (($request->column_text[0] == null && $request->column_image == null && $request->column_audio == null) || ($request->column_text[1] == null && $request->column_image == null && $request->column_audio == null)) {
            return redirect()->back()->withInput()->with(['error' => __('Morate uneti sadržaj za minimum dve kolone')]);
        }

        try {
            $numberOfColumns = count($request->column_text);
            $columns = [];
            $answers = [];
            $colors = [
                0 => 'red',
                1 => 'green',
                2 => 'blue',
                3 => 'yellow',
                4 => 'brown',
                5 => 'purple'
            ];

            for ($i = 0; $i < $numberOfColumns; $i++) {
                $columns += [
                    $i => [
                        'text' => $request->column_text[$i] ?? null,
                        'image' => $request->column_image[$i] ?? null,
                        'audio' => $request->column_audio[$i] ?? null,
                        'column' => $i + 1,
                        'color' => $request->color_border ? $colors[$i] : null
                    ]
                ];

                $answers += [
                    $i => [
                        'text' => $request->column_text[$i] ?? null,
                        'image' => $request->column_image[$i] ?? null,
                        'audio' => $request->column_audio[$i] ?? null,
                        'column' => $i + 1,
                        'color' => $request->color_border ? $colors[$i] : null
                    ]
                ];
            }

            $content = [
                'rows' => $request->rows,
                'columns' => $columns,
                'answers' => $answers
            ];

            foreach ($content['columns'] as $key => $column) {
                if ($column['image']) {
                    $image = $column['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['columns'][$key]['image'] = 'material/images/' . $image_name;
                    $content['answers'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($column['audio']) {
                    $audio = $column['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['columns'][$key]['audio'] = 'material/audio/' . $audio_name;
                    $content['answers'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            // dupliranje sadrzaja (kloniranje niza answers) onoliko puta koliko ima praznih redova
            $clonedArray = [];
            foreach ($content['answers'] as $key => $answer) {
                for ($i = 0; $i < $request->rows - 1; $i++) {
                    $clonedArray[] = $answer;
                }
            }

            $content['answers'] = array_merge($content['answers'], $clonedArray);

            // dodavanje ID-a svakom elementu niza
            foreach ($content['answers'] as $index => $answer) {
                $content['answers'][$index] += ['id' => $index + 1];
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeColumnSortingMultipleType(Request $request)
    {
        if (($request->column_text[0] == null && $request->column_image == null && $request->column_audio == null) || ($request->column_text[1] == null && $request->column_image == null && $request->column_audio == null)) {
            return redirect()->back()->withInput()->with(['error' => __('Morate uneti sadržaj za minimum dve kolone')]);
        }

        if (($request->answer_text[0] == null && $request->answer_image == null && $request->answer_audio == null) || ($request->answer_text[1] == null && $request->answer_image == null && $request->answer_audio == null)) {
            return redirect()->back()->withInput()->with(['error' => __('Morate uneti minimum dva ponuđena odgovora')]);
        }

        try {
            $numberOfColumns = count($request->column_text);
            $numberOfAnswers = count($request->answer_text);
            $answers = [];
            $columns = [];

            for ($i = 0; $i < $numberOfAnswers; $i++) {
                $answers += [
                    $i => [
                        'text' => $request->answer_text[$i] ?? null,
                        'image' => $request->answer_image[$i] ?? null,
                        'audio' => $request->answer_audio[$i] ?? null,
                        'column' => $request->answer_column[$i],
                        'id' => $i + 1
                    ]
                ];
            }

            for ($i = 0; $i < $numberOfColumns; $i++) {
                $columns += [
                    $i => [
                        'text' => $request->column_text[$i] ?? null,
                        'image' => $request->column_image[$i] ?? null,
                        'audio' => $request->column_audio[$i] ?? null,
                        'column' => $request->column_column[$i],
                        'id' => $i + 1
                    ]
                ];
            }

            $content = [
                'answers' => $answers,
                'columns' => $columns
            ];

            foreach ($content['answers'] as $key => $answer) {
                if ($answer['image']) {
                    $image = $answer['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['answers'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($answer['audio']) {
                    $audio = $answer['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['answers'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            foreach ($content['columns'] as $key => $column) {
                if ($column['image']) {
                    $image = $column['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['columns'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($column['audio']) {
                    $audio = $column['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['columns'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeAddLetterType(Request $request)
    {
        try {
            $str = $request->string;
            $clean_str = Str::replace("(", "",  $str);
            $clean_str = Str::replace(")", "",  $clean_str);
            $pattern = '/(?<=\()(\p{L}+)(?=\))/u';
            preg_match_all($pattern, $str, $matches, PREG_OFFSET_CAPTURE);

            if (!count($matches[0])) return back()->with('error', __('Unesite slova za dopunu'));
            $TwoLettersCount = 0;

            $indexOfTwoLetters = $this->substr_index_array($clean_str);


            foreach ($matches[0] as $match) {
                $br_count = substr_count(substr($str, 0, $match[1]), '(') + substr_count(substr($str, 0, $match[1]), ')');
                $TwoLettersCount = $this->substr_count_array(substr($str, 0, $match[1]));
                $m[] = ['value' => $match[0], 'index' => ($match[1] - $br_count - $TwoLettersCount)];
            }

            $splitedCleanStr = str_split($clean_str);
            foreach ($indexOfTwoLetters as $letterRemove) {
                $splitedCleanStr[$letterRemove - 1] = $splitedCleanStr[$letterRemove - 1] . $splitedCleanStr[$letterRemove];
                unset($splitedCleanStr[$letterRemove]);
            }

            foreach (array_values($splitedCleanStr) as $key => $letter) {
                $empty = collect(Arr::pluck($m, 'index'))->contains($key);
                $letters[] = ['index' => $key, 'value' => $letter, 'empty' => $empty];
            }

            $image = null;
            if ($request->image) {
                $image = $request->image;
                $image_name = time() . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('material/images'), $image_name);
                $image = 'material/images/' . $image_name;
            }

            $content = ['image' => $image, 'string' => $letters, 'answers' => $m];

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);
            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeSentenceType(Request $request)
    {
        try {
            $words = [];
            $image = $request->image;
            $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('material/images'), $image_name);

            foreach ($request->words as $key => $word) {
                $words += [
                    $key => [
                        'id' => $key + 1,
                        'word' => $word
                    ]
                ];
            }

            $content = [
                'image' => 'material/images/' . $image_name,
                'fields' => $words
            ];

            shuffle($words);

            $content['words'] = $words;

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeCompleteTheSentenceType(Request $request)
    {
        try {
            $sentences = [];
            $missingWords = [];

            foreach ($request->sentences as $key => $sentence) {

                $words = explode(" ", $sentence);

                foreach ($words as $k => $word) {
                    if (str_starts_with($word, "(")) {
                        $arrayKey = $k;
                    }
                }

                $missingWord = $words[$arrayKey];
                $words[$arrayKey] = "";


                $missingWords += [
                    $key => [
                        'sentence_id' => $key + 1,
                        'word' => trim($missingWord, "()."),
                        'missing_word_index' => $arrayKey
                    ]
                ];

                $sentences += [
                    $key => [
                        'id' => $key + 1,
                        'sentence' => str_replace(['(', ')'], '', $sentence),
                        'words' => $words,
                        'missing_word' => trim($missingWord, "().")
                    ]
                ];
            }

            $content = [
                'sentences' => $sentences,
                'missing_words' => $missingWords
            ];

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);
            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    /* new variant - not used */
    /*public function storeCompleteTheSentenceType(Request $request)
    {
        try {
            $sentences = [];
            $missingWords = [];

            foreach ($request->sentences as $key => $sentence) {

                $words = [];
                $allWords = collect(explode(" ", $sentence));

                foreach ($allWords as $k => $word) {
                    $words += [
                        $k => [
                            'word' => trim($word, "()."),
                            'missing' => str_starts_with($word, "(") ? true : false
                        ]
                    ];
                    if (str_starts_with($word, "(")) {
                        $arrayKey = $k;
                    }
                }

                $missingWord = $allWords[$arrayKey];
                //$allWords[$arrayKey] = "";

                $missingWords += [
                    $key => [
                        'sentence_id' => $key + 1,
                        'word' => trim($missingWord, "()."),
                        'missing_word_index' => $arrayKey
                    ]
                ];

                $sentences += [
                    $key => [
                        'id' => $key + 1,
                        'sentence' => str_replace(['(', ')'], '', $sentence),
                        'words' => $words,
                        'missing_word' => trim($missingWord, "().")
                    ]
                ];
            }

            $content = [
                'sentences' => $sentences,
                'missing_words' => $missingWords
            ];

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo' . $e->getMessage() . ' Linija ' . $e->getLine()));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }*/

    public function storeStoryType(Request $request)
    {
        $content = [];
        $content['text'] = $request->text;

        if ($request->file('image')) {
            $image_name = time() . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('material/images'), $image_name);
            $content['image'] = 'material/images/' . $image_name;
        }

        if ($request->file('audio')) {
            $audio_name = time() . uniqid() . '.' . $request->file('audio')->getClientOriginalExtension();
            $request->file('audio')->move(public_path('material/audio'), $audio_name);
            $content['audio'] = 'material/audio/' . $audio_name;
        }

        try {
            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeConnectLinesType(Request $request)
    {
        try {
            $numberOfAnswers = count($request->answer_text);
            $answers = [];
            $numberOfQuestions = count($request->question_text);
            $questions = [];

            for ($i = 0; $i < $numberOfAnswers; $i++) {
                $answers += [
                    $i => [
                        'text' => $request->answer_text[$i],
                        'image' => $request->answer_image[$i] ?? null,
                        'audio' => $request->answer_audio[$i] ?? null,
                        'id' => $i + 1
                    ]
                ];
            }

            for ($i = 0; $i < $numberOfQuestions; $i++) {
                $questions += [
                    $i => [
                        'text' => $request->question_text[$i],
                        'image' => $request->question_image[$i] ?? null,
                        'audio' => $request->question_audio[$i] ?? null,
                        'id' => $i + 1
                    ]
                ];
            }

            $content = [
                'answers' => $answers,
                'questions' => $questions,
            ];

            foreach ($content['answers'] as $key => $answer) {
                if ($answer['image']) {
                    $image = $answer['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['answers'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($content['answers'][$key]['audio']) {
                    $audio = $content['answers'][$key]['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['answers'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            foreach ($content['questions'] as $key => $question) {
                if ($question['image']) {
                    $image = $question['image'];
                    $image_name = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('material/images'), $image_name);
                    $content['questions'][$key]['image'] = 'material/images/' . $image_name;
                }

                if ($content['questions'][$key]['audio']) {
                    $audio = $content['question'][$key]['audio'];
                    $audio_name = time() . uniqid() . '.' . $audio->getClientOriginalExtension();
                    $audio->move(public_path('material/audio'), $audio_name);
                    $content['questions'][$key]['audio'] = 'material/audio/' . $audio_name;
                }
            }

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function storeEquationsType(Request $request)
    {
        if ($request->description == "" && $request->file('image') == null) {
            return back()->with('error', __('Morate popuniti tekstualni opis zadatka ili dodati sliku.'));
        }

        try {
            $elements = [];
            $result = (int)$request->result;

            if ($request->file('image')) {
                $image_name = time() . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('material/images'), $image_name);
                $content['image'] = 'material/images/' . $image_name;
            }

            foreach ($request->elements as $key => $element) {
                $elements += [
                    $key => [
                        'id' => $key + 1,
                        'element' => $element
                    ]
                ];
            }

            $elements += [
                3 => [
                    'id' => 4,
                    'element' => '='
                ]
            ];

            while (in_array(($random1 = mt_rand(0, 10)), array($result)));
            while (in_array(($random2 = mt_rand(0, 10)), array($result, $random1)));

            $answers = [
                0 => [
                    'answer' => $result,
                    'correct' => true
                ],
                1 => [
                    'answer' => $random1,
                    'correct' => false
                ],
                2 => [
                    'answer' => $random2,
                    'correct' => false
                ]
            ];

            shuffle($answers);

            $content += [
                'elements' => $elements,
                'answers' => $answers
            ];

            dd($content);

            Task::create([
                'lesson_id' => $request->lesson_id,
                'type' => $request->type,
                'description' => $request->description,
                'display_order' => Task::where('lesson_id', $request->lesson_id)->count() + 1,
                'content' => json_encode($content)
            ]);

            $request->session()->flash('message', __('Zadatak je uspešno kreiran'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom kreiranja zadatka: ' . $e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('tasks?lesson_id=' . $request->lesson_id);
    }

    public function show(Task $task)
    {
        abort(404);
    }

    /* public function editSpecificTask(Task $task)
    {
         $object = (array)json_decode($task->content);

         return view('pages.tasks.types.edit.edit_'.$task->type, [
             'type' => $task->type,
             'lesson_id' => $task->lesson_id,
             'task' => $task,
             'content' => Task::hydrate($object)
         ]);
    } */

    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Request $request, Task $task)
    {
        //
    }

    public function substr_count_array($haystack)
    {
        $needle = ['NJ', 'Nj', 'nj', 'LJ', 'lj', 'Lj', 'DŽ', 'Dž', 'dž'];
        $count = 0;
        foreach ($needle as $substring) {
            $count += substr_count($haystack, $substring);
        }
        return $count;
    }

    public function substr_index_array($haystack)
    {
        $positions = array();
        $needle = ['NJ', 'Nj', 'nj', 'Lj', 'LJ', 'lj', 'DŽ', 'Dž', 'dž',];
        foreach ($needle as $substring) {
            $lastPos = 0;
            while (($lastPos = strpos($haystack, $substring, $lastPos)) !== false) {
                $positions[] = $lastPos + 1;
                $lastPos = $lastPos + strlen($substring);
            }
        }
        return  $positions;
    }
}
