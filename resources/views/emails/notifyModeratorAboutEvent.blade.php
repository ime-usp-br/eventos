<html>
    <body>
        <p>Olá {{ explode(" ", $moderador->name)[0] }},</p>
        <p></p>
        <p>
            Informamos que o evento <b>{{$evento->titulo}}</b> foi cadastrado pelo usuário <b>{{$evento->criador->name}}</b> no Sistema de Eventos e 
            aguarda aprovação para ser divulgado. Você pode validar o evento pelo seguinte <a href="{{ $link }}">link</a>.
        </p>
        <p></p>
        <p>
            Essa mensagem foi gerada automaticamente pelo <a href="{{ url('') }}">Sistema de Eventos</a>
        </p>
    </body>
</html>