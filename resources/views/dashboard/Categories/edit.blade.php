@extends('layout.dashboard')
@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Page</li>
@endsection


@section('content')

    <div class="container mt-4">
        <h2 class="mb-3">Edit Category OF {{ $category->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $category->name }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select id="parent_id" name="parent_id" class="form-select">
                    <option value="">pryamry category</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" value="{{ $category->description }}" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Category Image</label>
                <input type="file" id="image" name="image"
                    class="form-control @error('image') is-invalid  @enderror">
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="" height="60">
                @endif
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input type="radio" id="active" name="status" value="active" class="form-check-input"
                        {{ old('status', $category->status) == 'active' ? 'checked' : '' }} required>
                    <label for="active" class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="archived" name="status" value="archived" class="form-check-input"
                        {{ old('status', $category->status) == 'archived' ? 'checked' : '' }}>
                    <label for="archived" class="form-check-label">Archived</label>
                </div>
            </div>




            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

@endsection
