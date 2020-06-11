@extends('layouts.app')

@section('content')

<style>
    .jumbo{
        background-repeat: no-repeat;
        background-image: url(https://agf360.com.br/wp-content/uploads/2017/09/chamada1.jpg);
        background-size: cover;
        background-position: center center;
        width: 100%;
        height: 100%;
        opacity: 1;
        visibility: inherit;
        z-index: 20;
    }
    
    .card-link{
        background-image: url("{{ asset('storage/img/background.png') }}");
    
    }
    </style>


<div class="card">

    <div class="card-body card-link">
        <div class="container">

            {{-- jumbotrom --}}
            <div class="jumbotron jumbo">
                <img src="{{ asset("storage/img/logo.png") }}" style="width: 220px; padding: 15px;">
                <h1 class="display-4 text-white">Seja bem vindo a AGF360!</h1>
                <p class="lead text-white">Do tamanho do seu sonho</p>
                <hr class="my-4">
                <p class="text-white">A AGF360 foi a primeira empresa do mercado a elaborar e produzir eventos de 
                    formatura de maneira customizada. Com 20 Anos de experiência no mercado de entretenimento, além 
                    de dezenas de cases de sucesso, sua marca se tornou referência no segmento. Atuando como uma autêntica 
                    agência de comunicação, trabalhamos a partir de planejamentos precisos e estratégias criativas para 
                    proporcionar experiências únicas e personalizadas. Este espaço é um convite para que você conheça um 
                    pouco da nossa história e descubra porque não somos apenas mais uma, mas sim a agência de formaturas.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="#" role="button">Visite nosso site!</a>
                </p>
            </div>
            <hr>

            {{-- cabeçalho --}}
            <div class="card">
                <div class="card-body">

                    <div class="media">
                        <img class="align-self-center mr-3" src="{{ asset("storage/img/".$image_logo) }}" alt="logo"
                            style="width: 220px;">
                        <div class="media-body">
                            <h5 class="mt-0">Intituição: {{$budget->client->institution}}</h5>
                            <p><b>Curso:</b> {{$budget->client->institution}} / {{$budget->client->courses}}</p>
                            <p><b>Ano da Conclusão:</b> {{$budget->client->month_conclusion}} / <b>Mes da Conclusão:</b>
                                {{$budget->client->year_conclusion}}</p>
                        </div>
                    </div>

                </div>
            </div>
            <hr>

            {{-- categorias e produtos --}}
            <div class="card">

                <div class="card-body">
                    @php
                    $relResumo = [];
                    @endphp

                    {{-- eventos --}}
                    @foreach($array as $index => $values)
                    @php
                    $nomeTipoEvento = \App\Models\EventType::find($index)->name;
                    @endphp


                    <img src="{{ asset("storage/img/formatura_cabecalho.JPG") }}" style="width: 600px; padding: 15px;">
   
                    
                    {{-- categorias --}}
                    @foreach($values as $catId => $prods)

                    <div class="loop-categoria">
                        @php
                        $sub = 0;
                        @endphp
                        @foreach($prods as $subPrice)
                        @php
                        $sub += $subPrice['price'] * $subPrice['amount'];
                        @endphp
                        @endforeach
                        @php
                        $nomeCategoria = \App\Models\Category::find($catId)->name;
                        $imagemCategoria = \App\Models\Category::find($catId)->image;
                        $descCategoria = \App\Models\Category::find($catId)->image;
                        @endphp


                                    <h5 class="mb-1"><img src="{{ asset("img/icons/".$imagemCategoria) }}"
                                            class="rounded-circle"
                                            style="width: 75px; background-color:#505050; margin:20px;">{{ $nomeCategoria }}
                                    </h5>



                        {{-- produtos--}}
                        <div class="loop-produtos">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prods as $prod)

                                    @php
                                    $subTotalProd = $prod['price'] * $prod['amount'];
                                    if (!isset($relResumo[$nomeTipoEvento])) {
                                    $relResumo[$nomeTipoEvento] = $subTotalProd;
                                    } else {
                                    $relResumo[$nomeTipoEvento] += $subTotalProd;
                                    }
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $prod['name'] }}</th>
                                        <td>{{ number_format($prod['price'], 2, ",", ".") }}</td>
                                        <td>{{ number_format($prod['amount'], 0) }}</td>
                                        <td>{{ number_format($subTotalProd , 2, ",", ".") }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b>Valor Total da Categoria:</b></td>
                                        <td><b>R${{ number_format($sub, 2, ",", ".") }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                            @php
                            unset($sub);
                            @endphp
                        </div>

                    </div>

                    @endforeach


                    @endforeach
                </div>
            </div>
            <hr>

            {{-- resumo --}}
            <div class="card">
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{-- <img src="{{ asset("img/icons/".$imagemCategoria) }}" class="rounded-circle"
                                    style="width: 75px; background-color:#505050; margin:20px;"> --}}
                                    Resumo
                                </h5>
                            </div>
                        </a>
                        @foreach($budget->eventTypes as $eventType)
                        @php
                        if($eventType->category_id == 1){
                        $number_forming = $eventType->number_forming;
                        }
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ App\Models\EventType::find($eventType->category_id)->name }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total de Formandos
                            <span class="badge badge-primary badge-pill">{{ $eventType->number_forming }}</span>
                        </li>
                        @if($eventType->extra_invitations>0)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Convites Extras
                            <span class="badge badge-primary badge-pill">{{$eventType->extra_invitations}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valor do Convites Extras
                            <span class="badge badge-primary badge-pill">{{$eventType->extra_invitations_value}}</span>
                        </li>
                        @endif
                        @if($eventType->extra_tables>0)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Mesas Extras
                            <span class="badge badge-primary badge-pill">{{$eventType->extra_tables}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valor da Mesa Extra
                            <span class="badge badge-primary badge-pill">{{$eventType->extra_tables_value}}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Publico Total
                            <span
                                class="badge badge-primary badge-pill">{{ (($eventType->number_forming * $eventType->invitations_by_forming) + ($eventType->number_forming * $eventType->extra_invitations)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Quantidade da comissão
                            <span class="badge badge-primary badge-pill"> {{ $comissao->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Número de parcelas
                            <span class="badge badge-primary badge-pill">{{ $budget->number_of_installments }}</span>
                        </li>
                    </div>
                </div>
            </div>
            <hr>

            {{-- financeiro --}}
            <div class="card">
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{-- <img src="{{ asset("img/icons/".$imagemCategoria) }}" class="rounded-circle"
                                    style="width: 75px; background-color:#505050; margin:20px;"> --}}
                                    Financeiro
                                </h5>
                            </div>
                        </a>

                        @php
                        $subTotalTypes = 0;
                        @endphp
                        @foreach($relResumo as $nome => $rel)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (+) {{$nome}}
                            <span class="badge badge-primary badge-pill">{{ number_format($rel, 2, ",", ".") }} </span>
                        </li>
                        @php
                        $subTotalTypes += $rel;
                        @endphp
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (=) Sub Total
                            <span
                                class="badge badge-primary badge-pill">{{ number_format($subTotalTypes, 2, ",", ".") }}
                            </span>
                        </li>
                        @php
                        $fee = ($subTotalTypes * ($budget->fee/ 100 )) ;
                        $subTotalGeral = $subTotalTypes + $fee;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (+) FEE({{$budget->fee}}%)
                            <span class="badge badge-primary badge-pill">{{ number_format($fee, 2, ",", ".") }} </span>
                        </li>

                        @php
                        $imposto = ($fee * (19.53 / 100));
                        $subTotalGeral += $imposto;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (+) IMPOSTOS (PIS, COFINS, ISS + CSLL, IRPJ, IRPJ AD.) = 19,53% SOB FEE
                            <span class="badge badge-primary badge-pill">
                                {{ number_format($imposto, 2, ",", ".") }}</span>
                        </li>

                        @foreach($budget->eventTypes as $eventType)
                        @php
                        $subReceitaConvites = $eventType->extra_invitations_value * $eventType->extra_invitations *
                        $eventType->number_forming;
                        $subReceitaMesas = $eventType->extra_tables_value * $eventType->extra_tables;
                        $subTotalGeral -= $subReceitaConvites;
                        $subTotalGeral -= $subReceitaMesas;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (-) {{ App\Models\EventType::find($eventType->category_id)->name }} - Receitas Convites
                            Extras
                            <span class="badge badge-primary badge-pill"> {{ ($subReceitaConvites) }} </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (-) Receitas Mesas Extras
                            <span class="badge badge-primary badge-pill">{{ ($subReceitaMesas) }}</span>
                        </li>

                        @php
                        $subTotalGeral -= $budget->photo_exclusivity;
                        @endphp

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (-) DESCONTOS EXCLUSIVIDADE FOTOGRÁFICA
                            <span
                                class="badge badge-primary badge-pill">{{ number_format($budget->photo_exclusivity, 2, ",", ".") }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (#) FORMANDOS
                            <span class="badge badge-primary badge-pill">{{$number_forming}} </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (=) TOTAL GERAL
                            <span
                                class="badge badge-primary badge-pill">{{ number_format($subTotalGeral, 2, ",", ".") }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (#) QUANTIDADE DE PARCELAS
                            <span class="badge badge-primary badge-pill">{{ $budget->number_of_installments }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (=) VALOR E QUANTIDADE DE PARCELAS (POR FORMANDO)
                            <span
                                class="badge badge-primary badge-pill">{{ number_format(($subTotalGeral/$number_forming)/$budget->number_of_installments, 2, ",", ".") }}
                            </span>
                        </li>
                        @endforeach
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>


@endsection