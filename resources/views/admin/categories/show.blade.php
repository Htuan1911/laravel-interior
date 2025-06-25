@extends('layouts.admin')

@section('title', 'Chi tiết danh mục')

@section('content')
    <h1>Chi tiết danh mục</h1>

    <div>
        <strong>Trạng thái:</strong> {{ $category->status }}
    </div>

    <div>
        <strong>Danh mục cha:</strong>
        {{ $category->parent ? $category->parent->translations->first()->name : 'Không có' }}
    </div>

    <h3>Bản dịch:</h3>
    <ul>
        @foreach ($category->translations as $translation)
            <li>
                <strong>{{ $translation->language_code }}:</strong> {{ $translation->name }} <br>
                <em>{{ $translation->description }}</em>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
