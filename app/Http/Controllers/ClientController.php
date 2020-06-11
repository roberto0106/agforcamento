<?php

namespace App\Http\Controllers;

use App\Forms\ClientForm;
use App\Models\Budget;
use App\Models\Client;
use App\Models\CommitteeMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $clients = Client::where('institution', 'LIKE', "%{$search}%")->paginate(15);
        } else {
            $clients = Client::paginate(15);
        }
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ClientForm::class, [
            'method' => 'POST',
            'url' => route('client.store')
        ]);

        return view('client.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(ClientForm::class);
        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data = $form->getFieldValues();
        $data['user_id'] = auth()->user()->id;
        \App\Models\Client::create($data);
        $request->session()->flash('message', 'Cliente criado com sucesso');
        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $month = \App\Models\Config::getMonthOfConclusion();
        $committeeMembers = CommitteeMember::where('client_id', $client->id)->orderBy('name')->get();
        return view('client.show', compact('client', 'month', 'committeeMembers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $form = \FormBuilder::create(ClientForm::class, [
            'url' => route('client.update', ['subject' => $client->id]),
            'method' => 'PUT',
            'model' => $client
        ]);
        return view('client.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(ClientForm::class);
        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data = $form->getFieldValues();
        $client->update($data);
        session()->flash('message', 'Cliente editada com sucesso');
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        $verification = Budget::where('client_id',$client->id)->get();
        if($verification->count()>0){
            session()->flash('message','Não é possível excluir esse cliente pois existe um orçamento vinculado a ele!');
            return redirect()->route('client.index');
        }else{
            $client->delete();
            session()->flash('message','Cliente excluído com sucesso');
            return redirect()->route('client.index');
        }



        $client->delete();
        return redirect()->route('client.index');
    }

    public function apiGetClientMaxParcels(Client $client)
    {
        $dtNow = $carbon = new Carbon();
        $date = Carbon::createFromDate($client->year_conclusion, $client->month_conclusion, '30');
        $dif = $date->diffInDays($dtNow);
        $ret = (int)($dif / 30) + 2;
        return ['max' => $ret];
    }

}
