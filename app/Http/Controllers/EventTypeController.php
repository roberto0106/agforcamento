<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Forms\BudgetForm;
use App\Forms\EventTypeForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $search = $request->query('search');
            if ($search) {
                $eventTypes = EventType::where('status', '=', 1)->where('name', 'LIKE', "%{$search}%")->paginate(15);
            } else {
                $eventTypes = EventType::where('status', '=', 1)->paginate(15);
            }


            return view('event_type.index', compact('eventTypes'));
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
    public function create(FormBuilder $formBuilder)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $form = $formBuilder->create(EventTypeForm::class, [
                'method' => 'POST',
                'url' => route('event_type.store')
            ]);

            return view('event_type.create', compact('form'));
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
        if (in_array($user_check->level, [0, 1])) {
            /** @var Form $form */
            $form = \FormBuilder::create(EventTypeForm::class);
            if (!$form->isValid()) {
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $rs = \App\Models\EventType::create($data);
            /*  $request->session()->put([
                  'budgetId' => $rs->id
              ]);*/
            $request->session()->flash('message', 'Tipo de Evento criado com sucesso');
            return redirect()->route('event_type.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\EventType $eventType
     * @return \Illuminate\Http\Response
     */
    public function show(EventType $eventType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EventType $eventType
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $eventType)
    {
        $form = \FormBuilder::create(EventTypeForm::class, [
            'url' => route('event_type.update', ['subject' => $eventType->id]),
            'method' => 'PUT',
            'model' => $eventType
        ]);

        return view('event_type.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EventType $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventType $eventType)
    {
        $eventType->name = $request->name;
        $eventType->position = $request->position;
        $eventType->save();
        return redirect()->route('event_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EventType $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $eventType->delete();
            return redirect()->route('event_type.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }
}
