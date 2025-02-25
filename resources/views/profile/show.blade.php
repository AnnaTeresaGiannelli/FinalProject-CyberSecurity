<x-layout>
    <div class="container-fluid p-4 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-2">Hi, {{Auth::user()->name}}</h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-6">
                <h2 class="text-xl font-semibold mb-4">Update your data</h2>
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="pb-3">
                        <label for="name" class="form-label"> <strong>Username</strong>:</label>
                        <input type="text" value="{{ ucfirst(Auth::user()->name) }}" id="name" class="form-control" name="name">
                        @error('name')
                        <span class="small fst-italic text-danger">
                            <i class="bi bi-exclamation-circle text-danger"></i> {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="pb-4">
                        <label for="email" class="form-label"> <strong>Email</strong>:</label>
                        <input type="email" value="{{ Auth::user()->email }}" id="email" class="form-control" name="email">
                        @error('email')
                        <span class="small fst-italic text-danger">
                            <i class="bi bi-exclamation-circle text-danger"></i> {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="pb-4">
                        <label for="password" class="form-label">Insert <strong>New Password</strong>:</label>
                        <input type="password" id="password" class="form-control" name="password">
                        @error('password')
                        <span class="small fst-italic text-danger">
                            <i class="bi bi-exclamation-circle text-danger"></i> {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="pb-4">
                        <label for="password_confirmation" class="form-label">Confirm <strong>New Password</strong>:</label>
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center text-center my-4 w-100">
                    <button type="submit" class="btn btn-dark">Modifica</button>
                </div>
            </div>
        </form>

    </div>
</x-layout>