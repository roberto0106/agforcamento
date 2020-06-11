<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_check = \Auth::user();
        if ($user_check->level == 0) {
            $users = User::all();
            return view('users.index', compact('users'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_check = \Auth::user();
        if ($user_check->level == 0) {
            return view('users.create');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_check = \Auth::user();
        if ($user_check->level == 0) {
            $newuser = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'level' => $request['level'],
                'password' => bcrypt($request['password']),
            ]);

            return redirect()->route('user.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user_check = \Auth::user();
        if ($user_check->level == 0) {
            return view('users.edit', compact('user'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user_check = \Auth::user();
        if ($user_check->level == 0) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->level = $request->level;
            $user->save();

            return redirect()->route('user.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        $user_check = \Auth::user();
        if ($user_check->level == 0) {

            if ($user_check->id == $user->id) {
                session()->flash('message', 'Voce não pode apagar seu próprio usuário!');
                return redirect()->route('user.index');
            } else {

                $user->delete();
                return redirect()->route('user.index');
            }
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }

    }
}
