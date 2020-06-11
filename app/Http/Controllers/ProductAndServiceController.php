<?php

namespace App\Http\Controllers;

use App\Forms\ProductAndServiceForm;
use App\Models\BudgetProductAndServices;
use App\Models\ProductAndService;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ProductAndServiceController extends Controller
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
                $pas = ProductAndService::where('alias', '0')->where('name', 'LIKE', "%{$search}%")->paginate(15);
            } else {
                $pas = ProductAndService::where('alias', '0')->paginate(15);
            }
            return view('product_and_service.index', compact('pas'));
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
            $teste = \App\Models\Category::getCategoryEventTypeArray();

            $form = $formBuilder->create(ProductAndServiceForm::class, [
                'method' => 'POST',
                'url' => route('productandservice.store')
            ]);
            return view('product_and_service.create', compact('form', 'teste'));
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
            $form = \FormBuilder::create(ProductAndServiceForm::class);
            if (!$form->isValid()) {
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $data['price'] = $this->treatsInputMaskCurrency($data['price']);
            $data['cost_price'] = $this->treatsInputMaskCurrency($data['cost_price']);
            $data['minimum_price'] = $this->treatsInputMaskCurrency($data['minimum_price']);
            \App\Models\ProductAndService::create($data);
            $request->session()->flash('message', 'Produto criado com sucesso');
            return redirect()->route('productandservice.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ProductAndService $productAndService
     * @return \Illuminate\Http\Response
     */
    public function show(ProductAndService $productandservice)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $categoryEventTypes = \App\Models\Category::getCategoryEventTypeArray();
            return view('product_and_service.show', compact('productandservice', 'categoryEventTypes'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ProductAndService $productAndService
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductAndService $productandservice)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $form = \FormBuilder::create(ProductAndServiceForm::class, [
                'url' => route('productandservice.update', ['subject' => $productandservice->id]),
                'method' => 'PUT',
                'model' => $productandservice
            ]);
            return view('product_and_service.edit', compact('form'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductAndService $productAndService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductAndService $productandservice)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            /** @var Form $form */
            $form = \FormBuilder::create(ProductAndServiceForm::class);
            if (!$form->isValid()) {
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $data['price'] = $this->treatsInputMaskCurrency($data['price']);
            $data['cost_price'] = $this->treatsInputMaskCurrency($data['cost_price']);
            $data['minimum_price'] = $this->treatsInputMaskCurrency($data['minimum_price']);
            $productandservice->update($data);
            session()->flash('message', 'Produto editado com sucesso!');
            return redirect()->route('productandservice.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ProductAndService $productAndService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductAndService $productandservice)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $verification = BudgetProductAndServices::where('id', $productandservice->id)->get();
            if ($verification->count() > 0) {
                session()->flash('message', 'Não é possível excluir esse produto pois existe um orçamento vinculado a ele!');
                return redirect()->route('productandservice.index');
            } else {
                $productandservice->delete();
                session()->flash('message', 'Produto excluído com sucesso');
                return redirect()->route('productandservice.index');
            }
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }

    }

    public function treatsInputMaskCurrency($data)
    {
        $data = str_replace('R$', '', $data);
        $data = str_replace('_', '', $data);
        $data = str_replace(' ', '', $data);
        $data = str_replace('.', '', $data);
        $data = str_replace(',', '.', $data);
        return $data;
    }
}
