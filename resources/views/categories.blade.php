@extends('global')

{{-- head && title --}}
@section('title')
    Categories
@endsection
@section('head')
<style scoped>
    table tr td {
        border: 1px solid #e0e0e0;
    }

    table tr th {
        border: 1px solid #e0e0e0;
    }

    table tbody {
        cursor: pointer;
    }
</style>
@endsection

{{-- navbars --}}
@section('navbar-left')
    <li><a>Add category</a></li>
@endsection

{{--  main --}}
@section('main')

<h4>Categories</h4>

<table class=" highlight">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Entities</th>
            <th>Current cap</th>
        </tr>
    </thead>

    @foreach ($DATA as $Cat)
        <tbody onclick="link('{{ route('categories.id', [$Cat->id]) }}')"
                title="Manage {{ $Cat->name }}">
            <tr>
                <td>{{ $Cat->id }}</td>
                <td>{{ $Cat->name }}</td>
                <td>{{ $Cat->get_entities_count }}</td>
                <td></td>
            </tr>
        </tbody>
    @endforeach

</table>

<br>
<div class="btn purple darken-2 waves-effect"
    title="prev page"
    @if($DATA->currentPage() === 1)
        disabled=""
    @endif
><<</div>
<div class="btn purple darken-2 waves-effect"
    title="next page"
    @if($DATA->currentPage() === $DATA->lastPage())
        disabled=""
    @endif
>>></div>
@endsection
