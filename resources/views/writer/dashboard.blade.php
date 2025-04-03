<x-layout>
    <div class="container-fluid p-4 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-4">Welcome back, writer: <br> {{Auth::user()->name}}</h1>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>Pending articles</h2>
                <x-writer-articles-table :articles="$unrevisionedArticles" status="pending"/>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>Published articles</h2>
                <x-writer-articles-table :articles="$acceptedArticles" status="accepted"/>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>Rejected articles</h2>
                <x-writer-articles-table :articles="$rejectedArticles" status="rejected"/>
            </div>
        </div>
    </div>
</x-layout>