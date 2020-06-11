<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategories;
use App\Models\BudgetProductAndServices;
use App\Models\Category;
use App\Forms\CategoryForm;
use App\Models\EventType;
use App\Models\ProductAndService;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class CategoryController extends Controller
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
                $categories = Category::where('status', '=', 1)->where('name', 'LIKE', "%{$search}%")->paginate(15);
            } else {
                $categories = Category::where('status', '=', 1)->paginate(15);
            }
            $eventTypes = \App\Models\EventType::getEventTypesArray();

            return view('category.index', compact('categories', 'eventTypes'));
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
            $evento = EventType::all()->count();

            if ($evento > 0) {
                $form = $formBuilder->create(CategoryForm::class, [
                    'method' => 'POST',
                    'url' => route('category.store')
                ]);

                return view('category.create', compact('form'));
            } else {
                return view('category.create');
            }
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
            $form = \FormBuilder::create(CategoryForm::class);
            if (!$form->isValid()) {
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();


            $upload = $data['image']->storeAs('public/img', $data['image']->hashName());
// Se tiver funcionado o arquivo foi armazenado em storage/app/public/img/nomedinamicoarquivo.extensao

            $newcategory = new Category();
            $newcategory->event_type_id = $request['event_type_id'];
            $newcategory->name = $request['name'];
            $newcategory->position = $request['position'];
            $newcategory->image = $data['image']->getClientOriginalName();
            $newcategory->save();

            // \App\Models\Category::create($data);
            $request->session()->flash('message', 'Categoria criado com sucesso');
            return redirect()->route('category.index');

        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $eventTypes = \App\Models\EventType::getEventTypesArray();
            $imagemCategoria = \App\Models\Category::find($category->id)->image;
            return view('category.show', compact('category', 'eventTypes','imagemCategoria'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $form = \FormBuilder::create(CategoryForm::class, [
                'url' => route('category.update', ['subject' => $category->id]),
                'method' => 'PUT',
                'model' => $category
            ]);
            return view('category.edit', compact('form'));
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, Request $request)
    {
       

        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            /** @var Form $form */
            $form = \FormBuilder::create(CategoryForm::class);
            if (!$form->isValid()) {
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();

            $upload = $data['image']->storeAs('public/img', $data['image']);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/img/nomedinamicoarquivo.extensao
            
                        $category->event_type_id = $request['event_type_id'];
                        $category->name = $request['name'];
                        $category->position = $request['position'];
                        $category->image = $data['image']->getClientOriginalName();
                        $category->save();
        

            session()->flash('message', 'Categoria editada com sucesso');
            return redirect()->route('category.index');
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {

            $check_budget = BudgetCategories::where('category_id', $category->id)->count();
            $check_budget_product = BudgetProductAndServices::where('category_id', $category->id)->count();
            $check_product = ProductAndService::where('category_id', $category->id)->count();

            $check = $check_budget + $check_product + $check_product;

            if ($check > 0) {
                session()->flash('message', 'Essa categoria está associada a uma orçamento e/ou a um produto por isso não é possível excluir');
                return redirect()->route('category.index');
            } else {
                $category->delete();
                session()->flash('message', 'Categoria excluída com sucesso');
                return redirect()->route('category.index');
            }
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }

    }

    public function listCategories()
    {
        $user_check = \Auth::user();
        if (in_array($user_check->level, [0, 1])) {
            $eventTypes = \App\Models\EventType::where('status', 1)->orderBy('position')->get();


            foreach ($eventTypes as $eventType) {
                $Categories = \App\Models\Category::where('event_type_id', $eventType->id)->orderBy('position')->get();
                foreach ($Categories as $category) {
                    $ret[$eventType->id]['cats'][] = $category->name;
                    $ret[$eventType->id]['name'] = $eventType->name;
                }
            }

            if (isset($ret)) {
                return view('reports.category_list', compact('ret'));
            } else {
                $ret = [];
                return view('reports.category_list', compact('ret'));
            }
        } else {
            session()->flash('message', 'Desculpe! Essa área é restrita a administração.');
            return view('includes.message');
        }


    }

}
