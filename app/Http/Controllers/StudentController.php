<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::with('school')->where('role_id', 2)->get();
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
            'password' => Password::defaults()
        ], [
            'name.required' =>  __('Unesite ime i prezime'),
            'name.max' => __('Ime i prezime ne sme biti duže od 255 karaktera'),
            'username.required' => __('Unesite korisničko ime'),
            'username.unique' => __('Korisničko ime zauzeto'),
            'username.min' => __('Korisničko ime ne sme biti kraće od 3 karaktera'),
            'username.max' => __('Korisničko ime ne sme biti duže od 100 karaktera')
        ]);

        try{
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => Role::STUDENT,
                'school' => 'Anton Skala',
                'lang' => 'sr_lat'
            ]);
            $request->session()->flash('message', __('Učenički nalog uspešno kreiran'));
        } catch(Exception $e){
            $request->session()->flash('message', __('Došlo je do greške. Pokušajte ponovo.'));
        }

        return redirect('students');
    }

    public function show($id)
    {
        $student = User::find($id);
        return view('pages.students.show', ['student' => $student]);
    }

    public function edit($id)
    {
        $student = User::find($id);
        return view('pages.students.edit', ['student' => $student]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
