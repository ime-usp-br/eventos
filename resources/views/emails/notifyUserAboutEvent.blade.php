<html>
    <body>
        <p>Olá {{ explode(" ", $evento->criador->name)[0] }},</p>
        <p></p>
        <p>
            Informamos que o evento <b>{{$evento->titulo}}</b> foi aprovado para divulgação no Sistema de Eventos.
        </p>
        <p></p>
        <p>
            Essa mensagem foi gerada automaticamente pelo <a href="{{ url('') }}">Sistema de Eventos</a>
        </p>
    </body>
</html>