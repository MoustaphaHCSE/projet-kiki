@php use App\Http\Controllers\CelebrityController;use App\Models\Celebrity; @endphp
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{$message}}
            </div>
        @endif
        <?php
        $celebrities = [];
        ?>
        <div class="card">
            <div class="card-header">Liste des célébrités</div>
            <div class="card-body">
                <a href="{{ route('celebrities.create') }}" class="btn btn-success btn-sm my-2"><i
                            class="bi bi-plus-circle"></i> Ajouter nouvelle célébrité</a>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Description</th>
                        <th scope="col">Photo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($celebrities as $celebrity)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$celebrity.last_name}}</td>
                            <td>{{$celebrity.first_name}}</td>
                            <td>{{$celebrity.description}}</td>
                            <td>{{$celebrity.image}}</td>
                            <td>
                                <form action="{{ route('celebrities.destroy', $celebrity->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i> Show</a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i> Edit</a>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Do you want to delete this product?');"><i
                                                class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="6">
                            <span class="text-danger">
                                <strong>No Product Found!</strong>
                            </span>
                        </td>
                    @endforelse
                    </tbody>
                </table>
                {{--                {{ $celebrities->links() }}--}}
            </div>
        </div>
    </div>
</div>