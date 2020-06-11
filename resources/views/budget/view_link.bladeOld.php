@extends('layouts.app')

@section('content')

    <style>
        .circle {
            background-color: #000;
            border-radius: 50%;
            width: 130px;
            height: 130px;
            overflow: hidden;
            position: relative;
        }

        .circle img {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

    </style>
    <div class="container">
        <div class="row" style="margin: 10px;">
            <button class="btn btn-primary" onClick = "window.print();"> Imprimir </button>
        </div>
    </div>
    
    <hr>

    <!--Cabeçalho-->
    <div class="container" style="width: 830px;">

        <div class="row">
            <div style="width: 800px; height: 200px; margin: 0 auto; background: #414143; color: {{ $text_color }};">
                <div class="float-left">
                    <img src="{{ asset("storage/img/".$image_logo) }}" style="width: 220px; padding: 15px;">

                </div>
                <div class="float-right" style="margin-top: 20px;text-align: right;">
                    <span style="padding: 10px; font-size: 30px">{{$budget->client->institution}} </span><br>
                    <span style="padding: 10px; font-size: 30px">{{$budget->client->courses}} </span><br>
                    <span style="padding: 10px; font-size: 30px">{{$budget->client->month_conclusion}}
                        / {{$budget->client->year_conclusion}}</span>

                </div>
            </div>
        </div>

        <!--Texto inicial-->
        <div class="row">
            <div style="width: 800px; height: 400px; margin: 0 auto; background-color:{{ $cor_cabecalho }};">
                <img src="{{ asset("storage/img/".$image_address) }}" style="width: 800px; height: 400px;">
            </div>
        </div>

        <hr>
        @php
            $relResumo = [];
        @endphp
        @foreach($array as $index => $values)

            <div class="row">
                <div style="width: 800px; height: 70px; margin: 10px auto 0 auto; background: #414143; color: {{ $text_color }};">
                    @php
                        $nomeTipoEvento = \App\Models\EventType::find($index)->name;
                    @endphp

                    <span style="padding: 10px; font-size: 30px; display: block; text-align: center">{!! $nomeTipoEvento !!}</span><br>

                </div>


                @foreach($values as $catId => $prods)

                    @php
                        $sub = 0;
                    @endphp

                    @foreach($prods as $subPrice)

                        @php
                            $sub += $subPrice['price'] * $subPrice['amount'];
                        @endphp

                    @endforeach

                    <div style="width: 800px; height: 10px; margin: 0 auto;">


                    </div>

                    <div style="width: 800px; height: 120px; margin: 0 auto; background-color:{{ $cor_cabecalho }}; color: {{ $text_color }};">
                        @php
                            $nomeCategoria = \App\Models\Category::find($catId)->name;
                            $imagemCategoria = \App\Models\Category::find($catId)->image;
                            $descCategoria = \App\Models\Category::find($catId)->image;
                        @endphp
                        <div class="float-left align-middle">
                            {{-- <img src="{{ asset("img/icons/".$imagemCategoria) }}" class="circle"
                                 style="width: 125px; height: 122px; margin: 0px;"> --}}
                                 <img src="{{ asset("img/icons/".$imagemCategoria) }}" class="rounded-circle" style="width: 75px; background-color:#505050; margin:20px;">

                        </div>
                        <div class="float-right" style="margin-top: 10px;text-align: right;">
                            <span style="padding: 10px; font-size: 30px">{{ $nomeCategoria }}</span><br>
                            <span style="padding: 10px; font-size: 14px">Valor Total da Categoria: R$ {{ number_format($sub, 2, ",", ".") }}</span><br>

                        </div>
                    </div>

                    @php
                        unset($sub);
                    @endphp

                    <div style="width: 800px; height: 5px; margin: 0 auto;"></div>


                    <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5A627A; border-bottom: 1px solid #B9BBBB">
                        <div class="float-left" style="padding: 5px;">
                            Nome do Produto
                        </div>
                        <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 12px;">Valor Unit.
                            </div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 12px; border-right: 1px solid #000">
                               Quantidade
                            </div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 12px; border-right: 1px solid #000">
                              Total
                            </div>
                        </div>

                    </div>

                    @foreach($prods as $prod)

                        <?php
                        $subTotalProd = $prod['price'] * $prod['amount'];
                        if (!isset($relResumo[$nomeTipoEvento])) {
                            $relResumo[$nomeTipoEvento] = $subTotalProd;
                        } else {
                            $relResumo[$nomeTipoEvento] += $subTotalProd;
                        }
                        ?>



                        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5A627A; border-bottom: 1px solid #B9BBBB">
                            <div class="float-left" style="padding: 5px;">
                                {{ $prod['name'] }} <small><i class="fa fa-info-circle" aria-hidden="true"
                                                              data-toggle="tooltip" data-placement="right"
                                                              title="{{ $prod['description']  }}"></i></small>

                            </div>
                            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">
                                {{--<div class="float-right"
                                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($prod['amount'] * $prod['price'], 2, ",", ".") }}
                                </div>--}}
                                <div class="float-right"
                                     style=" width: 100px; padding: 5px; font-size: 12px;"><i class="fa fa-money"
                                                                                              aria-hidden="true"></i> {{ number_format($prod['price'], 2, ",", ".") }}
                                </div>
                                <div class="float-right"
                                     style=" width: 100px; padding: 5px; font-size: 12px; border-right: 1px solid #000">
                                    QT {{ number_format($prod['amount'], 0) }}
                                </div>
                                <div class="float-right"
                                     style=" width: 100px; padding: 5px; font-size: 12px; border-right: 1px solid #000">
                                    TT {{ number_format($subTotalProd , 2, ",", ".") }}
                                </div>
                            </div>

                        </div>


                    @endforeach

                @endforeach

            </div>
        @endforeach

        <div class="row">
            <div style="width: 800px; height: 70px; margin: 10px auto 0 auto; background: #414143; color: {{ $text_color }};">

                <span style="padding: 10px; font-size: 30px; display: block; text-align: center">Resumo</span><br>

            </div>
        </div>

        @foreach($budget->eventTypes as $eventType)

            @php
                if($eventType->category_id == 1){
                    $number_forming = $eventType->number_forming;
                }
            @endphp

            <div style="border: 1px solid #495057">

                <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                    <div class="float-left" style="padding: 5px;">
                        Total de Formandos - {{ App\Models\EventType::find($eventType->category_id)->name }}

                    </div>
                    <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                        <div class="float-right"
                             style=" width: 100px; padding: 5px; font-size: 15px;">{{ $eventType->number_forming }}</div>


                    </div>
                </div>

                <div class="clearfix"></div>


                @if($eventType->extra_invitations>0)
                    <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                        <div class="float-left" style="padding: 5px;">
                            Convites Extras -

                        </div>
                        <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                            <div class="float-right"
                                 style=" width: 100px; padding: 5px;">{{$eventType->extra_invitations_value}}</div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px;">Valor:
                            </div>


                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px;border-right: 1px solid #000">{{$eventType->extra_invitations}} </div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px;">Quant.:
                            </div>
                        </div>
                    </div>
                @endif

                <div class="clearfix"></div>

                @if($eventType->extra_tables>0)
                    <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                        <div class="float-left" style="padding: 5px;">
                            Mesas Extras -

                        </div>
                        <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; ">{{$eventType->extra_tables_value}}</div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px;">Valor:
                            </div>


                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px;border-right: 1px solid #000">{{$eventType->extra_tables}}</div>
                            <div class="float-right"
                                 style=" width: 100px; padding: 5px; font-size: 15px; ">Quant.:
                            </div>


                        </div>
                    </div>
                @endif

                <div class="clearfix"></div>

                <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                    <div class="float-left" style="padding: 5px;">
                        Publico Total

                    </div>
                    <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                        <div class="float-right"
                             style=" width: 100px; padding: 5px; font-size: 15px; ">{{ (($eventType->number_forming * $eventType->invitations_by_forming) + ($eventType->number_forming * $eventType->extra_invitations)) }} </div>


                    </div>
                </div>

                <div class="clearfix"></div>

            </div>

        @endforeach

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                Quantidade da comissão

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ $comissao->count() }}</div>


            </div>
        </div>

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                Número de parcelas

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ $budget->number_of_installments }}</div>


            </div>
        </div>


        <div style="width: 800px; height: 70px; margin: 10px auto 0 auto; background: #414143; color: {{ $text_color }};">

            <span style="padding: 10px; font-size: 30px; display: block; text-align: center">Financeiro</span><br>

        </div>


        @php
            $subTotalTypes = 0;
        @endphp

        @foreach($relResumo as $nome => $rel)

            <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                <div class="float-left" style="padding: 5px;">
                    (+) {{$nome}}

                </div>
                <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                    <div class="float-right"
                         style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($rel, 2, ",", ".") }}</div>


                </div>
            </div>

            @php
                $subTotalTypes += $rel;
            @endphp

        @endforeach

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (=) Sub Total

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($subTotalTypes, 2, ",", ".") }}</div>


            </div>
        </div>

        @php

            $fee = ($subTotalTypes * ($budget->fee/ 100 )) ;
            $subTotalGeral = $subTotalTypes + $fee;
        @endphp
        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (+) FEE ({{$budget->fee}}%)

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($fee, 2, ",", ".") }}</div>


            </div>
        </div>

        @php
            $imposto = ($fee * (19.53 / 100));
            $subTotalGeral += $imposto;
        @endphp

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (+) IMPOSTOS (PIS, COFINS, ISS + CSLL, IRPJ, IRPJ AD.) = 19,53% SOB FEE

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($imposto, 2, ",", ".") }}</div>


            </div>
        </div>

        @foreach($budget->eventTypes as $eventType)

            @php
                $subReceitaConvites = $eventType->extra_invitations_value * $eventType->extra_invitations * $eventType->number_forming;
                $subReceitaMesas = $eventType->extra_tables_value * $eventType->extra_tables;

            $subTotalGeral -= $subReceitaConvites;
            $subTotalGeral -= $subReceitaMesas;


            @endphp

            <div style="border: 1px solid #495057">

                <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                    <div class="float-left" style="padding: 5px;">
                        (-) {{ App\Models\EventType::find($eventType->category_id)->name }} - Receitas Convites Extras

                    </div>
                    <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                        <div class="float-right"
                             style=" width: 100px; padding: 5px; font-size: 15px;">{{ ($subReceitaConvites) }}</div>


                    </div>
                </div>

                <div class="clearfix"></div>

                <div style="width: 798px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
                    <div class="float-left" style="padding: 5px;">
                        (-) Receitas Mesas Extras

                    </div>
                    <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                        <div class="float-right"
                             style=" width: 100px; padding: 5px; font-size: 15px;">{{ ($subReceitaMesas) }}</div>


                    </div>
                </div>

                <div class="clearfix"></div>

            </div>

        @endforeach

        @php
            $subTotalGeral -= $budget->photo_exclusivity;
        @endphp

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (-) DESCONTOS EXCLUSIVIDADE FOTOGRÁFICA

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($budget->photo_exclusivity, 2, ",", ".") }}</div>


            </div>
        </div>

        <div class="clearfix"></div>

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (=) TOTAL GERAL

            </div>
            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;">{{ number_format($subTotalGeral, 2, ",", ".") }}</div>


            </div>
        </div>

        <div class="clearfix"></div>

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (=) TOTAL GERAL POR FORMANDO

            </div>

            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;"><i class="fa fa-money"
                                                                              aria-hidden="true"></i> {{ number_format($subTotalGeral/$number_forming, 2, ",", ".") }}
                </div>
                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;border-right: 1px solid #000"><i
                            class="fa fa-users" aria-hidden="true"></i> {{$number_forming}}
                </div>


            </div>

        </div>

        <div class="clearfix"></div>

        <div style="width: 800px; height: 40px; margin: 0 auto 2px auto; background: #dddddd; color: #5a6268; border-bottom: 1px solid #B9BBBB">
            <div class="float-left" style="padding: 5px;">
                (=) VALOR E QUANTIDADE DE PARCELAS (POR FORMANDO)

            </div>

            <div class="float-right" style="margin-top: 0px;text-align: right; padding: 5px;">

                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;"><i class="fa fa-money"
                                                                              aria-hidden="true"></i> {{ number_format(($subTotalGeral/$number_forming)/$budget->number_of_installments, 2, ",", ".") }}
                </div>
                <div class="float-right"
                     style=" width: 100px; padding: 5px; font-size: 15px;border-right: 1px solid #000">
                    Parcelas: {{ $budget->number_of_installments }}
                </div>


            </div>

        </div>


    </div>
@endsection

@section('scripts')

    <script type="text/javascript">

    </script>

@endsection
