<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 25%;">Title</th>
            <th scope="col" style="width: 35%;">Subtitle</th>
            <th scope="col" style="width: 20%;">Author</th>
            <th scope="col" style="width: 15%; padding-left: 40px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
            <tr>
                <th scope="row">{{$article->id}}</th>
                <td>{{$article->title}}</td>
                <td>{{$article->subtitle}}</td>
                <td>{{$article->user->name}}</td>
                <td>
                    @if (is_null($article->is_accepted))
                        <a href="{{route('articles.show', $article)}}" class="btn btn-dark ms-3 px-4">Read</a>
                    @else
                        <form action="{{route('revisor.undoArticle', $article)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark">Back to review</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>