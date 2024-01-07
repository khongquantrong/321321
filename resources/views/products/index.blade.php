@extends('layout')

@section('content')
    <h1>
        <a href="{{ route('products.create') }}"
           class="btn btn-primary">Thêm mới Product</a>
    </h1>

    <table class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Danh mục</th>
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
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <a class="btn btn-success" href="{{ route('products.edit', $item) }}">Sửa</a>

                    <button class="btn btn-danger"
                            onclick="
                        if (confirm('Are you sure?')) {
                            document.getElementById('item-{{ $item->id }}').submit();
                        }
                    ">Xóa
                    </button>

                    <form action="{{ route('products.destroy', $item) }}"
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

    {{ $data->links() }}
@endsection
