<table>
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Notícia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($noticias as $noticia )
            <tr>
                <th>{{ $noticia->titulo }}</th>
                <th>{{ $noticia->noticia }}</th>
            </tr>
        @endforeach
    </tbody>
</table>
