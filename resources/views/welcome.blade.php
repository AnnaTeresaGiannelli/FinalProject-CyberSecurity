<x-layout>
    <div class="container-fluid p-5 bg-secondary-subtle text-center">
        <div class="row justify-content-center" style="height: 50vh">

            <h1 class="display-1 col-12 d-flex flex-column justify-content-around">The Aulab Post</h1>
            @auth
                @if(Auth::user()->is_writer)
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                    <a href="{{ route('articles.create') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 align-self-center">Write an amazing Article</a>
                    <p class="mt-2 fst-italic">or</p>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 align-self-center">Go to Article List</a>
                </div>
                @endif

                @if(Auth::user()->is_revisor || Auth::user()->is_admin)
                    @if(!Auth::user()->is_writer)
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 align-self-center">Go to Article List</a>
                    </div>
                    @endif
                @endif
            @endauth
            @guest
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 align-self-center" style="width: 50%">Go to Article List</a>
            @endguest


        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-evenly">
            @foreach ($articles as $article)
            <div class="col-12 col-md-6 col-lg-3 mt-3 mt-lg-0">
                <x-article-card :article="$article" />
            </div>
            @endforeach
        </div>
    </div>
</x-layout>