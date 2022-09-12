@extends('laravel-usp-theme::master')

@section('title') 
  @parent 
@endsection

@section('styles')
  @parent
    <link rel="stylesheet" href="{{ asset('css/app.css').'?version=1' }}" />
    <link rel="stylesheet" href="{{ asset('css/listmenu_v.css').'?version=1' }}" />
@endsection

@section('javascripts_bottom')
  @parent
    <script type="text/javascript">
      let baseURL = "{{ env('APP_URL') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/fluxyozlgidop2o9xx3484rluezjjiwtcodjylbuwavcfnjg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $( "#menulateral" ).menu();
    </script>
@endsection


@section('content')
@if(Auth::check())
  <div id="layout_menu">
      <ul id="menulateral" class="menulist">
          <li class="menuHeader">Acesso Restrito</li>
          <li>
              <a href="{{ route('home') }}">Página Inicial</a>
          </li>
          @can("editar usuario")
              <li>
                  <a href="{{ route('users.index') }}">Usuários</a>
                  <ul>
                      <li>
                          <a href="{{ route('users.loginas') }}">Logar Como</a>
                      </li>
                  </ul>
              </li>
          @endcan
        <li>
            <a href="{{ route('events.index') }}">Eventos</a>
        </li>
          <li>
              <form style="padding:0px;" action="{{ route('logout') }}" method="POST" id="logout_form2">
                  @csrf
                  <a onclick="document.getElementById('logout_form2').submit(); return false;">Sair</a>
              </form>
          </li>
      </ul>
  </div>
@endif
<div id="layout_conteudo">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                <?php Session::forget('alert-' . $msg) ?>
            @endif
        @endforeach
    </div>
</div>
@endsection