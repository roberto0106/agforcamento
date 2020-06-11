<?php

namespace App\Http\Controllers;

use App\Forms\Budget_to_Client;
use App\Forms\ClientForm;
use App\Models\Images;
use App\Models\Budget;
use App\Forms\BudgetForm;
use App\Forms\BudgetProductAndServiceForm;
use App\Models\BudgetCategories;
use App\Models\BudgetProductAndServices;
use App\Models\Category;
use App\Models\Client;
use App\Models\CommitteeMember;
use App\Models\EventType;
use App\Models\ProductAndService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Hash;


class BudgetController extends Controller
{
    private $budget;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->query('search');
        if ($search) {
            $budget = Budget::where('status', '=', 1)->where('name', 'LIKE', "%{$search}%")->paginate(15);
        } else {
            $budget = Budget::where('status', '=', 1)->paginate(15);
        }

        $eventTypes = \App\Models\EventType::getEventTypesArray();

        return view('budget.index', compact('budget', 'eventTypes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_for_client(FormBuilder $formBuilder, Client $client)
    {

        $testProduct = ProductAndService::all()->count();
        if ($testProduct > 0) {
            $testProduct = ProductAndService::all();
        } else {
            $testProduct = null;
        }

        $cliente_tratado = $client['name'] . " / " . $client['institution'] . " - " . $client['courses'] . " - " . $client['month_conclusion'] . " / " . $client['year_conclusion'];
        $id_cliente_tratado = $client['id'];

        /*   return view('budget.budget_for_client', compact('cliente_tratado'));*/

        $form = $formBuilder->create(Budget_to_Client::class, [
            'method' => 'POST',
            'url' => route('budget.store'),
            'data' => ['cliente_tratado' => $cliente_tratado, 'id_cliente_tratado' => $id_cliente_tratado],
        ]);

        return view('budget.budget_for_client', compact('form', 'cliente_tratado', 'testProduct'));

    }

    public function create(FormBuilder $formBuilder)
    {

        $testClient = Client::all()->count();
        if ($testClient > 0) {
            $testClient = Client::all()->count();
        } else {
            $testClient = null;
        }

        $form = $formBuilder->create(BudgetForm::class, [
            'method' => 'POST',
            'url' => route('budget.store'),
        ]);


        return view('budget.create', compact('form', 'testClient'));
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

        $form = \FormBuilder::create(BudgetForm::class);
        if (!$form->isValid()) {

            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data = $form->getFieldValues();

        $rs = \App\Models\Budget::create($data);

        $budgetId = $rs->id;

        $request->session()->put([
            'budgetId' => $budgetId
        ]);

        $request->session()->flash('message', 'Orçamento criado com sucesso');

        return redirect()->route('budget.in.categories');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget, Request $request)
    {
        $request->session()->put([
            'budgetId' => $budget->id
        ]);

        return redirect()->route('budget.in.home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        $form = \FormBuilder::create(BudgetForm::class, [
            'url' => route('budget.update', ['subject' => $budget->id]),
            'method' => 'PUT',
            'model' => $budget
        ]);


        $cliente = Client::find($budget->client_id);
        $client_for_select = $cliente->ClientToSelect();

        return view('budget.edit', compact('form', 'budget', 'client_for_select'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {

        $data = $request->all();
        $budget->update($data);
        session()->flash('message', 'Orçamento editado com sucesso');
        return redirect()->route('budget.index');
    }

    public function home()
    {
        $this->block();
        $budget = $this->budget;

        $token_access = $budget->token_access;

        if ($token_access == null) {
            $flag = 0;
        } else {
            $flag = 1;
        }

        $comissao = CommitteeMember::where('client_id', $this->budget->client->id)->get();
        $products = BudgetProductAndServices::where('budget_id', $this->budget->id)
        ->orderBy('created_at','DESC')
        ->orderBy('category_id','ASC')->get();
        $categories = \App\Models\Category::all();

        return view('budget.home', compact('budget', 'comissao', 'products', 'flag','categories'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {

        $imagem = Images::where('budget_id', $budget->id);
        $imagem->delete();

        $budgetInCategory = BudgetCategories::where('budget_id', $budget->id);
        $budgetInCategory->delete();

        $budgetProductServices = BudgetProductAndServices::where('budget_id', $budget->id);
        $budgetProductServices->delete();

        $budget->delete();
        return redirect()->route('budget.index');
    }

    public function duplicate(Budget $budget, Request $request)
    {
        $newBudget = new Budget;
        $newBudget->client_id = $budget->client_id;
        $newBudget->name = "(Copia) - " . $budget->name;
        $newBudget->number_of_installments = $budget->number_of_installments;
        $newBudget->fee = $budget->fee;
        $newBudget->photo_exclusivity = $budget->photo_exclusivity;
        $newBudget->shelf_life = $budget->shelf_life;
        $newBudget->paying_commission = $budget->paying_commission;
        $newBudget->internal_comment = $budget->internal_comment;
        $newBudget->external_comment = $budget->external_comment;
        $newBudget->status = $budget->status;
        $newBudget->save();


        $oldBudgetCategory = BudgetCategories::where('budget_id', $budget->id)->get();
        $oldBudgetProducts = BudgetProductAndServices::where('budget_id', $budget->id)->get();

        //dd($oldBudgetCategory);
        //dd($oldBudgetProducts);

        //copia das categorias
        foreach ($oldBudgetCategory as $aux) {
            $newBudgetCategory = new BudgetCategories();
            $newBudgetCategory->budget_id = $newBudget->id; //atenção a esse ponto ! esse id é o id da copia do orçamento
            $newBudgetCategory->category_id = $aux->category_id;
            $newBudgetCategory->number_forming = $aux->number_forming;
            $newBudgetCategory->invitations_by_forming = $aux->invitations_by_forming;
            $newBudgetCategory->extra_invitations = $aux->extra_invitations;
            $newBudgetCategory->extra_invitations_value = $aux->extra_invitations_value;
            $newBudgetCategory->extra_tables = $aux->extra_tables;
            $newBudgetCategory->extra_tables_value = $aux->extra_tables_value;
            $newBudgetCategory->save();
        }

        foreach ($oldBudgetProducts as $auxProd) {
            $newBudgetProduct = new BudgetProductAndServices();
            $newBudgetProduct->budget_id = $newBudget->id; //atenção a esse ponto ! esse id é o id da copia do orçamento
            $newBudgetProduct->original_id = $auxProd->original_id;
            $newBudgetProduct->name = $auxProd->name;
            $newBudgetProduct->category_id = $auxProd->category_id;
            $newBudgetProduct->price = $auxProd->price;
            $newBudgetProduct->cost_price = $auxProd->cost_price;
            $newBudgetProduct->minimum_price = $auxProd->minimum_price;
            $newBudgetProduct->description = $auxProd->description;
            $newBudgetProduct->amount = $auxProd->amount;
            $newBudgetProduct->position = $auxProd->position;
            $newBudgetProduct->proportion_per_person = $auxProd->proportion_per_person;
            $newBudgetProduct->multiplying_graduates = $auxProd->multiplying_graduates;
            $newBudgetProduct->multiplied_invitations = $auxProd->multiplied_invitations;
            $newBudgetProduct->extras_invitations = $auxProd->extras_invitations;
            $newBudgetProduct->extras_tables = $auxProd->extras_tables;
            $newBudgetProduct->alias = $auxProd->alias;
            $newBudgetProduct->comments = $auxProd->comments;
            $newBudgetProduct->save();
        }

        return redirect()->route('budget.index');
    }

    public function custom(Budget $budget)
    {
        return view('budget.custom', compact('budget'));
    }

    public function imageUploadPost(Request $request, Budget $budget)
    {


        $nameFile = null;

        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile('image', 'image_logo') && $request->file('image', 'image_logo')->isValid()) {

            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name_logo = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $extension = $request->image->extension();
            $extension_logo = $request->image_logo->extension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            $nameFile_logo = "{$name_logo}.{$extension_logo}";
            // Faz o upload:

            $upload = $request->image->storeAs('public/img', $nameFile);

            $upload_logo = $request->image_logo->storeAs('public/img', $nameFile_logo);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/img/nomedinamicoarquivo.extensao


            $image_adress_check = Images::where('budget_id', $budget->id)->get();
            // $color_check = Images::where('budget_id', $budget->id)->get();


            if ($image_adress_check->count() > 0) {
                $image_adress = Images::where('budget_id', $budget->id)->first();

                /* $image_logo = Images::where('budget_id', $budget->id)->first();
                 $color = Images::where('budget_id', $budget->id)->first();
                 $text_color = Images::where('budget_id', $budget->id)->first();
                */
                $image_adress->image_address = $nameFile;
                $image_adress->image_logo = $nameFile_logo;
                $image_adress->color = $request->cor;
                $image_adress->text_color = $request->text_color;

                $image_adress->save();
                /* $image_logo->save();
                 $color->save();
                 $text_color->save();*/
            } else {
                $image_adress = new Images();
                // $color = new Images();

                $image_adress->budget_id = $budget->id;
                // $color->budget_id = $budget->id;

                $image_adress->image_address = $nameFile;
                $image_adress->image_logo = $nameFile_logo;

                $image_adress->color = $request->cor;
                $image_adress->text_color = $request->text_color;
                $image_adress->save();

            }

        }


        // Verifica se NÃO deu certo o upload (Redireciona de volta)
        if (!$upload)
            return redirect()
                ->back()
                ->with('error', 'Falha ao fazer upload')
                ->withInput();

        return redirect()->back()->with('message', 'Upload realizado com sucesso!');
    }

    public function categories()
    {

        $this->block();
        $budget = $this->budget;

        $arrayEventTypesActives = [];
        $categoriesActives = $budget->eventTypes;

        foreach ($categoriesActives as $categoriesActive) {
            $arrayEventTypesActives[] = $categoriesActive->category_id;
        }

        /*$categories = \App\Models\EventType::wherenotIn('id', $arrayEventTypesActives)->get(['id', 'name']);*/

        //real categorias
        $real_categorias = \App\Models\Category::where('status', 1)->get(['event_type_id'])->toArray();
        //dd($real_categorias);

        //eventos
        $categories = \App\Models\EventType::where('status', 1)
            ->whereIn('id', $real_categorias)
            ->get(['id', 'name']);


        foreach ($categories as $category) {
            $categoriesArray[$category->id] = $category->name;
        }



        if (isset($categoriesActive)) {

            $categoriesActive['extra_invitations_value'] = number_format($categoriesActive['extra_invitations_value'], 2, ',', '.');
            $categoriesActive['extra_tables_value'] = number_format($categoriesActive['extra_tables_value'], 2, ',', '.');
        }

        //dd(strval($categoriesActive['extra_invitations_value']));

        return view('budget.categories', compact('budget', 'categoriesArray', 'categoriesActives'));

    }

    public function categoriesStore(Request $request)
    {


        $this->block();

        $request->validate([
            'category_id' => 'required|numeric|min:1',
            'number_forming' => 'required|numeric|min:1',
            //'invitations_by_forming' => 'required|numeric|min:1'
            'invitations_by_forming' => 'required|numeric|min:0'
        ]);

        $data = $request->all();
        unset($data['_token']);

        $data['extra_invitations_value'] = $this->treatsInputMaskCurrency($data['extra_invitations_value']);
        $data['extra_tables_value'] = $this->treatsInputMaskCurrency($data['extra_tables_value']);
        $data['budget_id'] = $this->budget->id;

        if ($data['extra_invitations_value'] == null) {
            $data['extra_invitations_value'] = 0;
        }
        if ($data['extra_tables_value'] == null) {
            $data['extra_tables_value'] = 0;
        }

        BudgetCategories::create($data);

        return redirect()->route('budget.in.categories');

    }

    public function categoriesUpdate(Request $request, BudgetCategories $eventtype)
    {



        $this->block();

        $request->validate([
            'number_forming' => 'required|numeric|min:1',
            'invitations_by_forming' => 'required|numeric|min:1'
        ]);

        $data = $request->all();

        $data['extra_invitations_value'] = $this->treatsInputMaskCurrency($data['extra_invitations_value']);
        $data['extra_tables_value'] = $this->treatsInputMaskCurrency($data['extra_tables_value']);

        //dd($data['extra_invitations_value']);

        $eventtype->update($data);
        return redirect()->route('budget.in.categories');
    }

    public function categoriesDelete(BudgetCategories $eventtype)
    {

        $eventtype->delete();

        return redirect()->route('budget.in.categories');
    }

    public function apiProducts()
    {
        $this->block();
        $arrayEventTypesActives = [];
        $categoriesActives = $this->budget->eventTypes;
        foreach ($categoriesActives as $categoriesActive) {
            $arrayEventTypesActives[] = $categoriesActive->category_id;
        }
        $search = Input::get('search');
        $catsActives = [];
        $cats = \App\Models\Category::whereIn('event_type_id', $arrayEventTypesActives)->get(['id']);
        foreach ($cats as $cat) {
            $catsActives[] = $cat->id;
        }
        $categoriesRet = [];
        $products = \App\Models\ProductAndService::where('name', 'like', "%{$search}%")->whereIn('category_id', $catsActives)->get();
        foreach ($products as $product) {
            $category = \App\Models\Category::find($product->category_id);
            $categoriesRet[] = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $category->name,
                'eventtype' => $category->eventType->name,
                'price' => number_format($product->price, 2, ',', '.'),
                'link' => route('api.budget.products.add', ['product' => $product->id])
            ];
        }
        return $categoriesRet;
    }

    public function apiAddProduct(ProductAndService $product)
    {

        $orcamento = $this->block();

        $data = $product->toArray();

        //Pega quantidade de comissão
        $committees = CommitteeMember::where('client_id', $orcamento->client_id)->get();

        $arrayEventTypesActives = [];
        $categoriesActives = $orcamento->eventTypes;

        foreach ($categoriesActives as $categoriesActive) {
            $arrayEventTypesActives[] = $categoriesActive->category_id;
        }

        $product_event_type_id = $product->category[0]['event_type_id'];

        //$categoryBudget = BudgetCategories::where('budget_id', $orcamento->id)->where('category_id', $product->category->event_type_id)->first();
        $categoryBudget = BudgetCategories::where('budget_id', $this->budget->id)->where('category_id', $product_event_type_id)->first();


        $amount = 1;

        @$total_formings = $committees->count() + $categoryBudget->number_forming;

        //Multiplica por formandos
        if ($product->multiplying_graduates == 1) {
            $amount = $amount * $total_formings;
        }
        //dd($amount);

        //Multiplica por convites
        if ($product->multiplied_invitations == 1) {
            $amount = $amount * $categoryBudget->invitations_by_forming;
        }

        //Multiplica por convites extras
        if ($product->extras_invitations == 1) {
            //$amount = $amount + $categoryBudget->extra_invitations;
            //$amount = $amount * $categoryBudget->extra_invitations;
            $amount = $amount + ($total_formings * $categoryBudget->extra_invitations);
        }

        //Multiplica por mesas extras
        if ($product->extras_tables == 1) {
            //$amount = $amount + $categoryBudget->extra_tables;
            $amount = $amount * $categoryBudget->extra_tables;
        }

        $data['amount'] = $amount;
        $data['budget_id'] = $this->budget->id;
        $data['original_id'] = $product->id;

        $addProd = BudgetProductAndServices::create($data);
        return $addProd;

    }

    public function refreshProds()
    {
        $this->block();

        $products = BudgetProductAndServices::where('budget_id', $this->budget->id)
        ->orderBy('created_at','DESC')
        ->orderBy('category_id','DESC')->get();

        $total = 0;
        $return = [];
        $subCategory = [];


        foreach ($products as $product) {

            $subtotal = $product->price * $product->amount;
            $total += $subtotal;
            $typeEvent = \App\Models\EventType::find($product->category->event_type_id)->name;

            $return['prods'][] = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->name,
                'typeevent' => $typeEvent,
                'price' => number_format($product->price, 2, ',', '.'),
                'amount' => $product->amount,
                'subtotal' => number_format($subtotal, 2, ',', '.')
            ];
            if (isset($subCategory[$typeEvent])) {
                $subCategory[$typeEvent] += $subtotal;
            } else {
                $subCategory[$typeEvent] = 0;
                $subCategory[$typeEvent] += $subtotal;
            }
            //dd($subCategory);

        }

        $typeEvents = $this->budget->eventTypes;
        $receita_convites_extras = 0;
        $receitas_mesas_extras = 0;

        foreach ($typeEvents as $typeEvent) {
            $conv_qt = $typeEvent->extra_invitations * $typeEvent->number_forming;
            $conv_vl = $typeEvent->extra_invitations_value;

            $receita_convites_extras += $conv_vl * $conv_qt;

            $mesa_qt = $typeEvent->extra_tables;
            $mesa_vl = $typeEvent->extra_tables_value;

            $receitas_mesas_extras += $mesa_vl * $mesa_qt;
        }


        $return['total'] = number_format($total, 2, ',', '.');

        foreach ($subCategory as $key => $value) {
            $subCategory[$key] = number_format($value, 2, ',', '.');
        }


        $fee = ($total * ($this->budget->fee) / 100);
        $imposto = ($fee * (19.53) / 100);
        $exclusividade = $this->budget->photo_exclusivity;

        $total_geral = $total + $fee + $imposto - $exclusividade - $receita_convites_extras - $receitas_mesas_extras;

        $return['rel'] = $subCategory;
        $return['rel']['FEE (+)'] = number_format($fee, 2, ",", ".");
        $return['rel']['Imposto 19,53% SOB FEE(+)'] = number_format($imposto, 2, ",", ".");
        $return['rel']['Exclusividade Fotografica (-)'] = number_format($exclusividade, 2, ",", ".");
        $return['rel']['Receita Convites Extras (-)'] = number_format($receita_convites_extras, 2, ",", ".");
        $return['rel']['Receita Mesas Extras (-)'] = number_format($receitas_mesas_extras, 2, ",", ".");
        $return['rel']['Total Geral (=)'] = number_format($total_geral, 2, ",", ".");

        return $return;
    }

    public function prodEdit(BudgetProductAndServices $prod)
    {
        $this->block();
        $form = \FormBuilder::create(BudgetProductAndServiceForm::class, [
            'url' => route('budget.in.prod.update', ['prod' => $prod->id]),
            'method' => 'PUT',
            'model' => $prod
        ]);

        return view('budget.prod_edit', compact('form'));
    }

    public function prodUpdate(BudgetProductAndServices $prod)
    {
     
        $this->block();
        /** @var Form $form */
        $form = \FormBuilder::create(BudgetProductAndServiceForm::class);
        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data = $form->getFieldValues();
        $prod->update($data);
        session()->flash('message', 'Produto editado com sucesso');

        $id_prod = $prod->id;

        return redirect()->route('budget.in.home', compact('id_prod'));
    }

    public function updateAmount(Request $request, BudgetProductAndServices $prod)
    {


        $this->block();
        $amount = $request->get('amount');
        $value = $request->get('value_price');
        $id = $request->get('id');

        $dataUpdate = [
            'amount' => $amount,
        ];

        $prod->update($dataUpdate);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function deleteProd(BudgetProductAndServices $prod)
    {

        $this->block();
        $prod->delete();
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function viewLink()
    {
        $this->block();
        $budget = $this->budget;
        $budget->token_access = $budget->id . rand(1, 100);
        $budget->save();
        $prods = BudgetProductAndServices::where('budget_id', $this->budget->id)->orderBy('position')->get();
        $image = Images::where('budget_id', $this->budget->id)->get();
        $cor = Images::where('budget_id', $this->budget->id)->get();


        if ($prods->count() > 0) {
            if ($image->count() > 0) {
                $image_address = $image[0]->image_address;
                $cor_cabecalho = $cor[0]->color;
                $image_logo = $cor[0]->image_logo;
                $text_color = $cor[0]->text_color;
                $comissao = CommitteeMember::where('client_id', $this->budget->client->id)->get();
                $typeEvents = EventType::all();
                foreach ($typeEvents as $typeEvent) {

                    $categories = Category::where('event_type_id', $typeEvent->id)->orderBy('position')->get();
                    foreach ($categories as $category) {

                        $prodsB = BudgetProductAndServices::where(['budget_id' => $budget->id, 'category_id' => $category->id])->orderBy('position')->get()->toArray();
                        foreach ($prodsB as $p) {
                            $array[$typeEvent->id][$category->id][$p['id']] = $p;
                        }

                    }

                }

                return view('budget.view_link', compact('budget', 'prods', 'array', 'comissao', 'image_address', 'cor_cabecalho', 'image_logo', 'text_color'));
            } else {
                return redirect()->route('budget.in.home')->with('message', 'Clique no botão customizar para inserir seu logo e definição de cores do orçamento!');
            }

        } else {
            return redirect()->route('budget.in.home')->with('message', 'É necessário primeiro acrescentar um produto ao seu orçamento!');
        }

    }

    public function viewLinkExternal($token_access)
    {
        $budget = Budget::where('token_access', $token_access)->first();


        $budget_id = $budget->id;
        $budget_client_id = $budget->client_id;

        $prods = BudgetProductAndServices::where('budget_id', $budget_id)->orderBy('position')->get();
        $image = Images::where('budget_id', $budget_id)->get();

        $cor = Images::where('budget_id', $budget_id)->get();
        $image_address = $image[0]->image_address;
        $cor_cabecalho = $cor[0]->color;
        $image_logo = $cor[0]->image_logo;
        $text_color = $cor[0]->text_color;

        $comissao = CommitteeMember::where('client_id', $budget_client_id)->get();
        
        $typeEvents = EventType::all();

        foreach ($typeEvents as $typeEvent) {

            $categories = Category::where('event_type_id', $typeEvent->id)->orderBy('position')->get();
           
            foreach ($categories as $category) {

                $prodsB = BudgetProductAndServices::where(['budget_id' => $budget_id, 'category_id' => $category->id])->orderBy('position')->get()->toArray();
                foreach ($prodsB as $p) {
                    $array[$typeEvent->id][$category->id][$p['id']] = $p;
                }

            }

        }

        return view('budget.view_link', compact('budget', 'prods', 'array', 'comissao', 'image_address', 'cor_cabecalho', 'image_logo', 'text_color','typeEvents'));
    }

    /*
     * PRIVATE
     */

    private function refreshAmountsProds(BudgetCategories $eventtype)
    {
        $this->block();
        $prods = BudgetProductAndServices::where('budget_id', $this->budget->id)->get();

    }

    private function block()
    {
        $id = session()->has('budgetId');

        if (!isset($id) or empty($id)) {
            return redirect()->route('budget.create');
        }


        return $this->budget = \App\Models\Budget::find(session()->get('budgetId'));

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
