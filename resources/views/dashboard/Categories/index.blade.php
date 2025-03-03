@extends('layout.dashboard')
@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">category Page</li>
@endsection


@section('content')


    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="mb-3 text-center">Categories List</h2>
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
        <hr>

        <table class="table table-bordered  shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="align-middle text-center">
                @forelse($categories as $category)
                    <tr>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="rounded"
                                    width="50" height="50">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_id ?? 'None' }}</td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


    </div>


@endsection
