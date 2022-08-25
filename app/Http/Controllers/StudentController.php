<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = User::with('school')
            ->where('role_id', 2)
            ->when(Auth::user()->role_id == Role::TEACHER, function ($query) {
                return $query->where([
                    'school_id' => Auth::user()->school_id
                ]);
            })
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', '%'.$request->search.'%');
            })
            ->latest()
            ->paginate(20);
        return view('pages.students.index', ['students' => $students]);
    }

    public function create()
    {
        return view('pages.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|min:3|max:100',
            'password' => Password::defaults(),
            'lang' => 'required'
        ], [
            'name.required' =>  __('Unesite ime i prezime'),
            'name.max' => __('Ime i prezime ne sme biti duže od 255 karaktera'),
            'username.required' => __('Unesite korisničko ime'),
            'username.unique' => __('Korisničko ime zauzeto'),
            'username.min' => __('Korisničko ime ne sme biti kraće od 3 karaktera'),
            'username.max' => __('Korisničko ime ne sme biti duže od 100 karaktera'),
            'lang.required' => __('Izaberite jezik')
        ]);

        try{
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => Role::STUDENT,
                'school_id' => Auth::user()->school_id,
                'school_name' => Auth::user()->school->name,
                'lang' => $request->lang
            ]);
            $request->session()->flash('message', __('Učenički nalog uspešno kreiran'));
        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('students');
    }

    public function show($id)
    {
        $student = User::with(['tasks', 'lessons'])->find($id);
        return view('pages.students.show', ['student' => $student]);
    }

    public function edit($id)
    {
        $student = User::find($id);
        return view('pages.students.edit', ['student' => $student]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', Rule::unique('users')->ignore($id), 'min:3', 'max:100'],
            'old_password' => [
                'nullable',
                'required_with:password',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail(__('Lozinke se ne podudaraju'));
                    }
                }
            ],
            'password' => [
                'nullable',
                'required_with:old_password',
                Password::defaults()
            ],
            'lang' => 'required'
        ], [
            'name.required' =>  __('Unesite ime i prezime'),
            'name.max' => __('Ime i prezime ne sme biti duže od 255 karaktera'),
            'username.required' => __('Unesite korisničko ime'),
            'username.unique' => __('Korisničko ime zauzeto'),
            'username.min' => __('Korisničko ime ne sme biti kraće od 3 karaktera'),
            'username.max' => __('Korisničko ime ne sme biti duže od 100 karaktera'),
            'lang.required' => __('Izaberite jezik'),
            'old_password.required_with' => __('Unesite trenutnu lozinku'),
            'password.required_with' => __('Unesite novu lozinku')
        ]);


        try{
            if($request->password && Hash::check($request->old_password, $user->password)){
                $user->update(['password' => Hash::make($request->password)]);
            }

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'lang' => $request->lang
            ]);
            $request->session()->flash('message', __('Učenički nalog uspešno izmenjen'));
        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('students');
    }

    public function destroy(Request $request, $id)
    {
        $student = User::findOrFail($id);

        try{
            $student->delete();
            $request->session()->flash('message', __('Učenički nalog uspešno obrisan'));
        } catch(Exception $e){
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
        return redirect('students');
    }
}
