@extends('layout.dashboard')
@section('title', 'products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">product Page</li>
@endsection


@section('content')


    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="mb-3 text-center">products List</h2>
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-md btn-primary mr-2  ">create</a>
            
        <hr>

        {{-- <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
            <!-- Name Input -->
            <input type="text" name="name" class="form-control mx-2" placeholder="Name" value="{{ request('name') }}">
        
            <!-- Status Dropdown -->
            <select name="status" class="form-control mx-2">
                <option value="">All</option>
                <option value="active" @selected(request('status') == 'active')>Active</option>
                <option value="archived" @selected(request('status') == 'archived')>Archived</option>
            </select>
        
            <!-- Submit Button -->
            <button class="btn btn-dark mx-2">Filter</button>
        </form> --}}
        

        <table class="table table-bordered  shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    {{-- <th>image</th> --}}
                    <th>ID</th>
                    <th>name</th>
                    <th>category</th>
                    <th>store</th>
                    <th>status</th>
                    <th>create_at</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody class="align-middle text-center">
                @forelse($products as $product)
                    <tr>
                        {{-- <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="product Image" class="rounded"
                                    width="50" height="50">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td> --}}
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'None' }}</td>
                        <td>{{ $product->store->name ?? 'None' }}</td>
                        <td>{{ $product->status  }}</td>
                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

         {{ $products->withQueryString()->links() }}
 
    </div>


@endsection
