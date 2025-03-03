@extends('layout.dashboard')
@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">category Page</li>
@endsection


@section('content')

    <div class="container mt-4">
        <h2 class="mb-3">Create Category</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select id="parent_id" name="parent_id" class="form-select">
                    <option value="">pryamry category</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"  class="form-control">{{ old('description') }}</textarea>
            </div>


            <div class="mb-3">
                <label for="image" class="form-label">Category Image</label>
                <input type="file" accept="image/*" name="image"
                    class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input type="radio" id="active" name="status" value="Active" class="form-check-input"
                        {{ old('status', 'Active') == 'Active' ? 'checked' : '' }} required>
                    <label for="active" class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="archived" name="status" value="Archived" class="form-check-input"
                        {{ old('status') == 'Archived' ? 'checked' : '' }}>
                    <label for="archived" class="form-check-label">Archived</label>
                </div>
            </div>




            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </div>

@endsection
