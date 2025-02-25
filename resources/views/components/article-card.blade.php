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
            <p class="small text-muted my-0">
                @foreach ($article->tags as $tag)
                #{{ $tag->name }}
                @endforeach
            </p>
            <p class="card-subtitle text-muted fst-italic small mt-2">Reading time {{ $article->readDuration() }} min</p>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <p>Created at {{$article->created_at->format('d/m/Y')}} <br>
                By <a class="text-muted fst-italic" href="{{ route('articles.byUser', $article->user) }}">{{$article->user->name}}</a>
            </p>
        </div>
    </a>
</div>