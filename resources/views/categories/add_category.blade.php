<div id="add_category" class="modal">
    <div class="modal-content">
      <h4>New category</h4>
      <div class="divider"></div>

      <div class="row">
        <div class="col">

        {{-- all fields here --}}
            <input type="text" placeholder="Name" v-model="name">

            <label>
                <input type="checkbox" v-model="is_subcat">
                <span>Is subcategory</span>
            </label>

            <select v-model="parent_id" class="browser-default" v-if="is_subcat">
                <option v-for="cat in categories" :value="cat.id">@{{ cat.name }}</option>
            </select>

            <div class="btn" @@click="postData">Send</div>
        {{--  --}}

        </div>
      </div>


    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Exit</a>
    </div>
</div>

<script>
    const AddCategory = new Vue({
        el: '#add_category',
        data(){
            return{
                is_subcat: false,
                name: '',
                parent_id: 1,
                Modal: null,
                categories: [],

                // used when I need to couple the newly created category with an entity
                // meaning when newly created category holds the entity
                // just check postData @ axios.then( ... )
                entity_to_couple_with: null,
            }
        },

        methods:{
            /*
            *   retrieves all categories from server
            */
            getAllCats(){
                axios.get('{{ route("categories.api-all") }}')
                .then(res=>{
                    this.categories = res.data
                })
            },

            /*
            *   creates a formdata and sends it to server
            */
            postData(){
                // make formdata
                let Data = new FormData
                    Data.append("name", this.name)
                    Data.append("is_subcat", this.is_subcat ? 1 : 0)
                    if(this.is_subcat) Data.append('parent_of', this.parent_id)

                // post data
                axios.post('{{ route("categories.api-post") }}', Data)
                .then(async res=>{
                    toast('Done!')

                    // if we need to couple this category with an entity..
                    if(this.entity_to_couple_with)
                    {
                        await this.coupleEntityToCategory(res.data.id)

                        // update entity categories list
                        this.entity_to_couple_with.get_categories.push(res.data)

                        this.Modal.close()
                    }
                    else
                    // otherwise it's a legacy case and carry on with older procedure
                        setTimeout(()=>{
                            window.location.reload()
                        }, 1000)

                })
            },

            /*
            *   shows modal with eventual paramters
                @param1: object
            */
            showModal(entity_to_couple_with=null){
                this.entity_to_couple_with = entity_to_couple_with
                this.Modal.open()
            },

            /*
            *   couple entity with newly created category
                category id passed as param
            */
            async coupleEntityToCategory(cat_id){
                return await axios.patch('{{ route("entities.entity_id.api-pushCat", "###") }}'.replace("###", this.entity_to_couple_with.id), {
                    categories: [cat_id],
                })
            }
        },

        mounted(){
            // init modal with necessary parameters
            this.Modal = M.Modal.init(_('add_category'), {
                // this one gets all categories when modal opens
                onOpenStart: ()=>{
                    this.getAllCats()
                },

                // this one attempts to flush component's state on exit
                onCloseEnd: ()=>{
                    this.name = ''
                    this.is_subcat=false
                    this.parent_id = 1
                    this.entity_to_couple_with = null
                }
            })
        }
    })

    // compatiblity with view.categories
    window.AddCategory = AddCategory

</script>
