@extends('global')

@section('title')
    Entities
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

@section('navbar-left')
    <li><a href="#!">Add entity</a></li>
@endsection

@section('main')
<div id="entities">

    <h4>Entities</h4>

    {{-- actual table --}}
    <table class="highlight">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Grouped to</th>
                <th>Cap</th>
            </tr>
        </thead>
        <tbody v-for="entity in paginatorData.data" >
            {{-- rows --}}
            <tr>
                <td>@{{entity.id}}</td>
                <td>@{{entity.name}}</td>
                <td>
                    {{-- subcat action div --}}
                    <ul :id='`dropdown_cat_${entity.id}`' class='dropdown-content'>

                        {{-- opens the modal to create a new category for assignment --}}
                        <li><a href="#!" @@click="showModal('AddCategory', entity)">New</a></li>

                        {{-- opens the modal to assign this entity to an existing category --}}
                        <li><a href="#!" @@click="showModal('AssignExistingToCategory', entity)">Existing</a></li>
                    </ul>

                    {{-- categories assigned --}}
                    <div class="row">
                        <div class="col s8" v-if="entity.get_categories">
                            <ul class="browser-default">
                                <li v-for="category in entity.get_categories">
                                    <a :href=" '{{ route('categories.id', '###') }}'.replace('###', category.id) ">@{{ category.name }}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col ">
                            <div class="btn waves-effect tooltipped dropdown-trigger "
                                data-tooltip="Add subcat"
                                data-position="right"
                                :data-target="`dropdown_cat_${entity.id}`"><i class="material-icons">add</i></div>

                        </div>
                    </div>
                </td>
                <td>infinity </td>
            </tr>
        </tbody>
    </table>

    {{-- prev/next buttons --}}
    <br>
    <div class="btn purple darken-2 waves-effect"
        title="prev page"
        :disabled="currentPage < 2"
        @@click="getEntitiesFromPage(-1)"
    ><<</div>
    <div class="btn purple darken-2 waves-effect"
        title="next page"
        :disabled="paginatorData.last_page === currentPage"
        @@click="getEntitiesFromPage(+1)"
    >>></div>

</div>
@endsection


@section('BEOB')

    {{-- inject other modals --}}
    @include('entities.assign_existing_to_category')
    @include('categories.add_category')


//<script>

    const Entities = new Vue({
        el: '#entities',

        data(){
            return {
                currentPage: 1,
                paginatorData: {
                    data: []
                },
            }
        },

        methods:{
            /*
            *   retrieves entities in chunks
            */
            async getEntities()
            {
                return new Promise((resolve, reject)=>{
                    axios.get('{{ route("entities.api-paginateAll") }}?page='+this.currentPage)
                    .then(res=>{
                        this.paginatorData = res.data
                        resolve(res) //
                    }) .catch(e=>{
                        reject(e) //
                    })
                })
            },

            /*
            *   reinits dropdowns
            */
            reinitDropdowns(){
                this.$nextTick(()=>{
                    M.Dropdown.init( document.querySelectorAll('.dropdown-trigger') )
                })
            },

            /*
            *   get entities and increment page
            */
            async getEntitiesFromPage(incrementor=1)
            {
                this.currentPage += incrementor

                await this.getEntities()

                this.reinitDropdowns()
            },

            /*
            *   shows the modal of a modal vue instance
                must pass an entity instance as optional param
            */
            showModal(vueInstance, entity){
                window[vueInstance].showModal(entity)
            }
        },

        async mounted(){
            // get entities and increment
            this.getEntitiesFromPage(0)
        }
    })

//</script>
@endsection
