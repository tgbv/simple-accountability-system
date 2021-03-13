<div id="assign_existing_to_category" class="modal">
    <div class="modal-content">
      <h4>Assign to category</h4>
      <div class="divider"></div>

      <div class="row">
        <div class="col">

        {{-- all fields here --}}
            <select v-model="cat_id" class="browser-default" >
                <option value="0" disabled>Select cat</option>
                <option v-for="cat in categories"
                    v-if="!categoryAssignedToEntity(cat.id)"
                    :value="cat.id" >@{{ cat.name }}</option>
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
    window.AssignExistingToCategory = new Vue({
        el: `#assign_existing_to_category`,
        data(){
            return{
                cat_id: 0,
                Modal: null,
                categories: [],
                modal_id: 'assign_existing_to_category',

                entity: {
                    get_categories: []
                },
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
            *   sends data to server
            */
            postData()
            {
                axios.patch('{{ route("entities.entity_id.api-pushCat", "###") }}'.replace("###", this.entity.id), {
                    categories: [this.cat_id],
                }).then(res=>{
                    toast('Done!')

                    // push new cat to entity stack
                    this.entity.get_categories.push(
                        this.categories.find(cat=>cat.id===this.cat_id)
                    )

                    // refractor category
                    this.cat_id = 0

                    // close modal
                   // this.Modal.close()
                })
            },

            showModal(entity){
                this.Modal.open()
                this.entity = entity
            },

            /*
            *   checks if a category is assigned to an entity
            */
            categoryAssignedToEntity(cat_id){
                return this.entity.get_categories.find(cat=>cat.id === cat_id) !== undefined
            },
        },

        mounted(){
            // init modal with necessary parameters
            this.Modal = M.Modal.init(_(this.modal_id), {
                // this one gets all categories when modal opens
                onOpenStart: ()=>{
                    this.getAllCats()
                },

                // this one attempts to flush component's state on exit
                onCloseEnd: ()=>{
                    this.cat_id = 0
                    this.entity = {get_categories:[]}
                }
            })
        }
    })

</script>
