<div id="add_existing_to_subcat" class="modal">
    <div class="modal-content">
      <h4>Assign category</h4>
      <div class="divider"></div>

      <div class="row">
        <div class="col">

        {{-- all fields here --}}
            <select v-model="cat_id" class="browser-default" >
                <option value="0" disabled>Select cat</option>
                <option v-for="cat in categories"
                    :value="cat.id"
                    v-if="cat.id !== parent_id">@{{ cat.name }}</option>
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
    const AddExistingToSubcat = new Vue({
        el: '#add_existing_to_subcat',
        data(){
            return{
                cat_id: 0,
                parent_id: 0,
                Modal: null,
                categories: [],
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
                axios.patch('{{ route("categories.api-pushSubcat.parent_id", "###") }}'.replace("###", this.parent_id), {
                    parent_id: this.parent_id,
                    categories: [this.cat_id],
                }).then(res=>{
                    toast('Done!')
                    setTimeout(()=>{
                        window.location.reload()
                    }, 1000)
                })
            }
        },

        mounted(){
            // init modal with necessary parameters
            this.Modal = M.Modal.init(_('add_existing_to_subcat'), {
                // this one gets all categories when modal opens
                onOpenStart: ()=>{
                    this.getAllCats()
                },

                // this one attempts to flush component's state on exit
                onCloseEnd: ()=>{
                    this.cat_id = 0
                    this.parent_id = 0
                }
            })
        }
    })

</script>
