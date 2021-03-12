@extends('global')

{{-- head && title --}}
@section('title')
    Categories
@endsection
@section('head')
<style>
    table tr td {
        border: 1px solid #e0e0e0;
    }

    table tr th {
        border: 1px solid #e0e0e0;
    }

    table tbody {
        /* cursor: pointer; */
    }

    table tr td {
        vertical-align: top;
    }

    table ul {
        padding: 0;
        padding-left: 1rem;
        position: relative;
        margin: 0;

    }

    main a:hover {
        text-decoration: underline;
    }
</style>
@endsection
{{-- navbars --}}
@section('navbar-left')
    <li><a class="modal-trigger" data-target="add_category" href='#!'>Add category</a></li>
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
            <th>Subcats</th>
            <th>Current cap</th>
            <th>Actions</th>
        </tr>
    </thead>

    @foreach ($DATA as $key=> $Cat)

    {{-- subcat action div --}}
    <ul id='dropdown_cat_{{ $Cat->id }}' class='dropdown-content'>

        {{-- opens the modal to create a new category --}}
        <li><a href="#!" onclick=" Categories.openModalNewCat('{{$Cat->id}}') ">New</a></li>

        {{-- opens the modal to assign an existing category to this category --}}
        <li><a href="#!" onclick=" Categories.openModalAddExistingToSubcat('{{$Cat->id}}') ">Existing</a></li>
    </ul>

    {{-- actual table data  --}}
        <tbody>
            <tr>
                <td>{{ $key+1 }}</td>
                <td><a href="{{ route('categories.id', $Cat->id) }}"
                        title="Manage {{ $Cat->name }}">{{ $Cat->name }}</a></td>
                <td>{{ $Cat->get_entities_count }}</td>
                <td>
                    <div class="row">
                        <div class="col s8">
                            @if($Cat->getChilds)
                            <ul class="browser-default">
                                @foreach($Cat->getChilds as $Subcat)
                                    <li><a href="{{ route('categories.id', $Subcat->id) }}"
                                            title="Manage {{ $Subcat->name }}">{{ $Subcat->name }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>

                        <div class="col ">
                                <div class="btn waves-effect tooltipped dropdown-trigger"
                                    data-tooltip="Add subcat"
                                    data-position="right"
                                    data-target="dropdown_cat_{{ $Cat->id }}"><i class="material-icons">add</i></div>

                        </div>
                    </div>
                </td>
                <td>infinity</td>
                <td>

                </td>
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


@section('BEOB')
    {{-- includes modals --}}
    @include('categories.add_category')
    @include('categories.add_existing_to_subcat')

    {{-- script before end of body but not before included modals --}}
    <script>
        /*
        *   makes sure function names won't be duplicated
        */
        const Categories = {
            openModalNewCat(parent_id){
                AddCategory.is_subcat = true
                AddCategory.parent_id = parent_id
                M.Modal.getInstance(_('add_category')).open()

            },

            openModalAddExistingToSubcat(parent_id){
                AddExistingToSubcat.parent_id = parseInt(parent_id)
                M.Modal.getInstance(_('add_existing_to_subcat')).open()
            },
        }
    </script>
@endsection
