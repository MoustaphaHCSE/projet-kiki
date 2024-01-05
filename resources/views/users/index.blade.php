@extends('layouts.default')

@section('content')

    <div class="card">
        <div class="card-header">Panneau Admin - utilisateurs</div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{$message}}
            </div>
        @endif
        <div class="card-body">

            <div class="btn-group mb-3 gap-3" role="group">
                @can('create-user')
                    <a href="{{ route('users.create') }}" class="btn btn-success"><i
                            class="bi bi-plus-circle"></i> Ajouter un utilisateur</a>
                @endcan
                <form action="{{route('view-pdf')}} " method="post" target="_blank">
                    @csrf
                    <button class="btn btn-dark ">Voir PDF</button>
                </form>
                <form action="{{route('download-pdf')}} " method="post" target="_blank">
                    @csrf
                    <button type="submit" class="btn btn-dark ">Télécharger PDF</button>
                </form>
                <form action="{{route('export-csv')}} " method="post" target="_blank">
                    @csrf
                    <button type="submit" class="btn btn-info ">Export CSV</button>
                </form>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse ($user->getRoleNames() as $role)
                                <span class="badge bg-primary">{{ $role }}</span>
                            @empty
                            @endforelse
                        </td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-eye"></i> Show</a>

                                @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                    @if (Auth::user()->hasRole('Super Admin'))
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i> Edit</a>
                                    @endif
                                @else
                                    @can('edit-user')
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i> Edit</a>
                                    @endcan

                                    @can('delete-user')
                                        @if (Auth::user()->id!=$user->id)
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this user?');"><i
                                                    class="bi bi-trash"></i> Delete
                                            </button>
                                        @endif
                                    @endcan
                                @endif

                            </form>
                        </td>
                    </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No User Found!</strong>
                        </span>
                    </td>
                @endforelse
                </tbody>
            </table>

            {{ $users->links() }}

        </div>
    </div>

@endsection
