<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 30%;">Name</th>
            <th scope="col" style="width: 35%;">Email</th>
            <th scope="col" style="width: 30%; text-align: center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($roleRequests->isEmpty())
            <tr>
                <td colspan="4">No requests yet.</td>
            </tr>
        @else
        @foreach ($roleRequests as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                @switch($role)
                @case('admin')
                    <div class="d-flex justify-content-evenly">
                        <form action="{{ route('admin.rejectRequest', ['user' => $user, 'role' => 'admin']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                        <form action="{{route('admin.setAdmin', $user)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success" style="align-content: center;">Enable {{$role}}</button>
                        </form>
                    </div>
                @break
                @case('revisor')
                    <div class="d-flex justify-content-evenly">
                        <form action="{{ route('admin.rejectRequest', ['user' => $user, 'role' => 'revisor']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Reject Request</button>
                        </form>
                        <form action="{{route('admin.setRevisor', $user)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Enable {{$role}}</button>
                        </form>
                    </div>
                @break
                @case('writer')
                    <div class="d-flex justify-content-evenly">
                        <form action="{{ route('admin.rejectRequest', ['user' => $user, 'role' => 'writer']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Reject Request</button>
                        </form>
                        <form action="{{route('admin.setWriter', $user)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Enable {{$role}}</button>
                        </form>
                    </div>
                @break
                @endswitch
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>