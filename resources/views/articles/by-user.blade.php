<x-layout>
    <div class="container-fluid p-4 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-2 text-capitalize">{{ $user->name }}</h1>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-evenly">
            @foreach ($articles as $article)
            <div class="col-12 col-md-6 col-lg-3 pt-3">
                <div class="card shadow-lg border-0 h-100">
                    <a href="{{ route('articles.show', $article) }}">
                        <img src="{{ Storage::url($article->image) }}" class="card-img-top rounded-top imgCardArticle img-fluid" alt="Immagine dell'articolo: {{ $article->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-secondary">{{ ucfirst($article->title) }}</h5>
                            <p class="card-subtitle text-secondary">{{ ucfirst($article->subtitle) }}</p>
                            @if ($article->category)
                            <a href="{{route('articles.byCategory', $article->category)}}" class="text-capitalize text-muted mt-3">
                                {{ $article->category->name }}
                            </a>
                            @else
                            <p class="small text-muted">No category</p>
                            @endif
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p>Created at {{$article->created_at->format('d/m/Y')}} <br>
                                By <a class="text-muted fst-italic" href="{{ route('articles.byUser', $article->user) }}">{{$article->user->name}}</a>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout>