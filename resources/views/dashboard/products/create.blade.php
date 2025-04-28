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
        <h2 class="mb-3 text-center">Add New Product</h2>

        <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" step="0.01" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Compare Price -->
            <div class="mb-3">
                <label for="compare_price" class="form-label">Compare Price (Optional)</label>
                <input type="number" step="0.01" class="form-control @error('compare_price') is-invalid @enderror" id="compare_price"
                    name="compare_price" value="{{ old('compare_price') }}">
                @error('compare_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- add tags or select from selector --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Add tags or select from selector</label>
                <select class="form-control select2 @error('tags') is-invalid @enderror" name="tags[]" id="tags"
                    multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id"
                    required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Store -->
            <div class="mb-3">
                <label for="store_id" class="form-label">Store</label>
                <select class="form-control @error('store_id') is-invalid @enderror" name="store_id" id="store_id"
                    required>
                    <option value="">Select Store</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                @error('store_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Product Image (Optional)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>






            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>




    </div>

    @push('css')
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="{{ asset('dist/css/select2.min.css') }}">
    @endpush

    @push('script')
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script src="{{ asset('dist/js/jquery20.min.js') }}"></script>


        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> --}}
        <script src="{{ asset('dist/js/select2.min.js') }}"></script>


        <script>
            $(document).ready(function() {
                $('#tags').select2({
                    tags: true, // يسمح بإضافة تاجز جديدة
                    tokenSeparators: [','], // يفصل التاجز عند إدخالها بفاصلة
                    placeholder: "add tags or select from selector",
                    allowClear: true,
                    width: "100%"
                });
            });
        </script>
    @endpush


@endsection
