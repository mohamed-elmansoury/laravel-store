@extends('layout.dashboard')
@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">category Page</li>
    <li class="breadcrumb-item active">category trash</li>
@endsection


@section('content')


    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="mb-3 text-center">Categories trash List</h2>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-md btn-primary mr-2  ">Category</a>
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-md btn-dark">Trash</a>

        <hr>

        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
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
        </form>


        <table class="table table-bordered  shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>status</th>
                    <th>deleted At</th>
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
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->deleted_at->format('Y-m-d') }}</td>
                        <td>

                            <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-trash"></i> Restore
                                </button>
                            </form>


                            <form action="{{ route('dashboard.categories.forceDelete', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> forceDelete
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

        {{ $categories->withQueryString()->links() }}

    </div>


@endsection
