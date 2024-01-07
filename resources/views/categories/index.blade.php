@extends('layout')

@section('content')
    <h1>
        <a href="{{ route('categories.create') }}"
           class="btn btn-primary">Thêm mới danh mục</a>
    </h1>

    <table id="list" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Describe</th>
            <th>Create date</th>
            <th>Update date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->describe }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <a class="btn btn-success" href="{{ route('categories.edit', $item) }}">Sửa</a>

                    <button class="btn btn-danger"
                    onclick="document.getElementById('item-{{ $item->id }}').submit();">Xóa</button>

                    <form action="{{ route('categories.destroy', $item) }}"
                          id="item-{{ $item->id }}"
                          method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
