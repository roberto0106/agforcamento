<!-- Navigation-->


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav" style="background-color: #505050 !important;">
    <a class="navbar-brand"><img src="{{asset('img/nova_logo_curta.png')}}" style="width: 160px;"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion" style="background-color: #505050 !important;">

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a>
                    <span class="nav-link-text" style="color: #505050">Espaço para alinhamento</span>
                </a>
            </li>

           <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuários">
               <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                  href="#collapseComponentsUsers" data-parent="#exampleAccordion" >
                   <i class="fa fa-fw fa-users" style="color: white"></i>
                   <span class="nav-link-text" style="color: white">Usuários</span>
               </a>
               <ul class="sidenav-second-level collapse" id="collapseComponentsUsers">
                   <li>
                       <a href="{{route('user.index')}}">Administrar</a>
                   </li>
               </ul>
            </li>

            {{--Clientes--}}
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseComponentsClientes" data-parent="#exampleAccordion" >
                    <i class="fa fa-fw fa-address-book" style="color: white"></i>
                    <span class="nav-link-text" style="color: white">Clientes</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponentsClientes">
                    <li>
                        <a href="{{route('client.index')}}">Gerenciar</a>
                    </li>
                </ul>
            </li>

            {{--Orçamento--}}
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseComponentsOrcamentos" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-area-chart" style="color: white"></i>
                    <span class="nav-link-text" style="color: white">Orçamentos</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponentsOrcamentos">
                    <li>
                        <a href="{{route('budget.index')}}">Gerenciar</a>
                    </li>
                </ul>
            </li>

            {{--Produtos--}}
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseComponentsProdutos" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-product-hunt" style="color: white"></i>
                    <span class="nav-link-text" style="color: white">Produtos da Categoria</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponentsProdutos">
                    <li>
                        <a href="{{route('productandservice.index')}}">Gerenciar</a>
                    </li>
                </ul>
            </li>

            {{--Categorias--}}
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseComponentsCategorias" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-star" style="color: white"></i>
                    <span class="nav-link-text" style="color: white">Categorias</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponentsCategorias">
                    <li>
                        <a href="{{route('category.index')}}">Gerenciar</a>
                    </li>
                    <li>
                        <a href="{{route('reports.categories.list')}}">Ordem Das categorias</a>
                    </li>
                </ul>
            </li>

            {{--Eventos--}}
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseComponentsEvents" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-flag" style="color: white"></i>
                    <span class="nav-link-text" style="color: white">Eventos</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponentsEvents">

                    <li>
                        <a href="{{route('event_type.index')}}">Gerenciar</a>
                    </li>
                </ul>
            </li>

        </ul>



        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();" style="color: white">
                    <i class="fa fa-fw fa-sign-out" style="color: white"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>