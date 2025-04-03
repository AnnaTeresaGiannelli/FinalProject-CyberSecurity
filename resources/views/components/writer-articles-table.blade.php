<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 20%;">Title</th>
            <th scope="col" style="width: 25%;">Subtitle</th>
            <th scope="col" style="width: 15%;">Category</th>
            <th scope="col" style="width: 10%;">Tags</th>
            <th scope="col" style="width: 10%;">Created at</th>
            <th scope="col" style="width: 15%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
            <tr>
                <th scope="row">{{$article->id}}</th>
                <td>{{$article->title}}</td>
                <td>{{$article->subtitle}}</td>
                <td>{{$article->category->name ?? 'Nessuna categoria'}}</td>
                <td>
                    @foreach ($article->tags as $tag)
                        #{{ $tag->name }}
                    @endforeach
                </td>
                <td>{{$article->created_at->format('d/m/Y')}}</td>
                <td>
                    <a href="{{route('articles.show', $article)}}" class="btn btn-dark">Read</a>

                    @if ($status !== 'rejected') 
                        <a href="{{route('articles.edit', $article)}}" class="btn btn-warning text-white mt-1 mt-lg-0">
                            <i class="bi bi-pen"></i>
                        </a>
                    @endif

                    <form action="{{route('articles.destroy', $article)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-1 mt-lg-0"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>