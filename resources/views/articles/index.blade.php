<x-layout>
    <div class="container-fluid p-4 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-2">Latest articles</h1>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-evenly">
            @foreach ($articles as $article)
                <div class="col-12 col-md-6 col-lg-3 pt-3">
                    <x-article-card :article="$article"/>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>