<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class CommitteeMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|email',
        ]);
        $data = $request->all();
        $data['client_id'] = $client->id;
        //dd($data);
        \App\Models\CommitteeMember::create($data);
        $request->session()->flash('message', 'Membro cadastrado com sucesso!');
        return redirect()->route('client.show', $client->id);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommitteeMember  $committeeMember
     * @return \Illuminate\Http\Response
     */
    public function show(CommitteeMember $committeeMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommitteeMember  $committeeMember
     * @return \Illuminate\Http\Response
     */
    public function edit(CommitteeMember $committeeMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommitteeMember  $committeeMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, CommitteeMember $committeeMember)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|email',
        ]);
        $data = $request->all();
        $data['client_id'] = $client->id;
        //dd($data);

        $committeeMember->update($data);
        return redirect()->route('client.show', $client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommitteeMember  $committeeMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteeMember $committeeMember)
    {
        //
    }
}
