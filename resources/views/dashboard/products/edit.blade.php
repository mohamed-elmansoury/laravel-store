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
        <h2 class="mb-3 text-center">EDit Product . {{ $product->name }}</h2>

        <div class="card-body">
            <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- اسم المنتج --}}
                <div class="mb-3">
                    <label for="name" class="form-label">اسم المنتج</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الوصف --}}
                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="4" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- السعر --}}
                <div class="mb-3">
                    <label for="price" class="form-label">السعر</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price"
                        name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- السعر المقارن --}}
                <div class="mb-3">
                    <label for="compare_price" class="form-label">السعر قبل الخصم</label>
                    <input type="number" step="0.01" class="form-control @error('compare_price') is-invalid @enderror"
                        id="compare_price" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}">
                    @error('compare_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الفئة --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">الفئة</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- المتجر --}}
                <div class="mb-3">
                    <label for="store_id" class="form-label">المتجر</label>
                    <select class="form-control @error('store_id') is-invalid @enderror" id="store_id" name="store_id"
                        required>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ $product->store_id == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- التاجز --}}
                <div class="mb-3">
                    <label for="tags" class="form-label">التاجز</label>
                    <select class="form-control select2 @error('tags') is-invalid @enderror" name="tags[]" id="tags"
                        multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->name }}"
                                {{ in_array($tag->name, $selectedTags) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الصورة --}}
                <div class="mb-3">
                    <label for="image" class="form-label">الصورة</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                        name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                {{-- زر الحفظ --}}
                <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
   

    @push('css')
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
