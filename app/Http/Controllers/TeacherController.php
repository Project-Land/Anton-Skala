<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id == Role::TEACHER) return redirect('404');

        $teachers = User::with('school')->where('role_id', 3)->latest()->get();
        return view('pages.teachers.index', ['teachers' => $teachers]);
    }

    public function create()
    {
        if(Auth::user()->role_id == Role::TEACHER) return redirect('404');
        $schools = School::all();
        return view('pages.teachers.create', ['schools' => $schools]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|min:3|max:100',
            'password' => Password::defaults(),
            'lang' => 'required',
            'email' => 'required|email',
            'school' => 'required'
        ], [
            'name.required' =>  __('Unesite ime i prezime'),
            'name.max' => __('Ime i prezime ne sme biti duže od 255 karaktera'),
            'username.required' => __('Unesite korisničko ime'),
            'username.unique' => __('Korisničko ime zauzeto'),
            'username.min' => __('Korisničko ime ne sme biti kraće od 3 karaktera'),
            'username.max' => __('Korisničko ime ne sme biti duže od 100 karaktera'),
            'lang.required' => __('Izaberite jezik'),
            'school.required' => __('Izaberite školu'),
            'email.required' => __('Unesite email adresu'),
            'email.email' => __('Neispravan format email adrese')
        ]);

        try{
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email ?? null,
                'role_id' => Role::TEACHER,
                'school_id' => $request->school,
                'school_name' => School::find($request->school)->name,
                'lang' => $request->lang
            ]);
            $request->session()->flash('message', __('Učenički nalog uspešno kreiran'));
        } catch(Exception $e){
            Log::error('Greška prilikom kreiranja nastavničkog naloga: '.$e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('teachers');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if(Auth::user()->role_id == Role::TEACHER) return redirect('404');

        $teacher = User::findOrFail($id);
        $schools = School::all();

        return view('pages.teachers.edit', [
            'teacher' => $teacher,
            'schools' => $schools
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', Rule::unique('users')->ignore($id), 'min:3', 'max:100'],
            'email' => 'required|email',
            'school' => 'required',
            'old_password' => [
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
            'school.required' => __('Izaberite školu'),
            'email.required' => __('Unesite email adresu'),
            'email.email' => __('Neispravan format email adrese'),
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
                'email' => $request->email,
                'lang' => $request->lang,
                'school_id' => $request->school
            ]);
            $request->session()->flash('message', __('Nastavnički nalog uspešno izmenjen'));
        } catch(Exception $e){
            Log::error('Greška prilikom izmene nastavničkog naloga: '.$e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('teachers');
    }

    public function destroy(Request $request, $id)
    {
        if(Auth::user()->role_id == Role::TEACHER) return redirect('404');

        $teacher = User::findOrFail($id);

        try{
            $teacher->delete();
            $request->session()->flash('message', __('Nastavnički nalog uspešno obrisan'));
        } catch(Exception $e){
            Log::error('Greška prilikom uklanjanja nastavničkog naloga: '.$e->getMessage());
            $request->session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
        return redirect('teachers');
    }
}
