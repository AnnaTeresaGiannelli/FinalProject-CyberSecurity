<x-layout>
    <div class="container-fluid p-4 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-2">{{ ucfirst($article->title) }}</h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 mb-4 mb-md-0">
                <img src="{{ Storage::url($article->image) }}" class="img-fluid rounded-3 shadow-lg" alt="Immagine dell'articolo: {{ $article->title }}">
            </div>

            <div class="col-12 col-lg-8 d-flex flex-column">
                <div class="text-center my-4">
                    <h2 class="fw-light text-muted">{{ ucfirst($article->subtitle) }}</h2>

                    @if ($article->category)
                    <p class="fs-5">
                        <strong>Category:</strong>
                        <a href="{{ route('articles.byCategory', $article->category) }}" class="text-capitalize fw-bold text-dark">{{ $article->category->name }}</a>
                    </p>
                    @else
                    <p class="fs-5 text-muted">No category</p>
                    @endif

                    <div class="text-muted my-3">
                        <p class="small">
                            Created at {{$article->created_at->format('d/m/Y')}} by
                            <a class="text-muted" href="{{ route('articles.byUser', $article->user) }}">{{ $article->user->name }}</a>
                        </p>
                    </div>
                    <hr class="my-4 mx-4">
                    <p class="lead">{!! $article->body !!}</p>
                </div>

                <!-- revisor -->
                @if (Auth::user() && Auth::user()->is_revisor && !$article->is_accepted)
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-evenly">
                            <form action="{{ route('revisor.rejectArticle', $article) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm">Reject</button>
                            </form>
                            <form action="{{ route('revisor.acceptArticle', $article) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">Accept</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-center mt-5">
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">Go to article list</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>