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
                .then(res=>{
                    toast('Done!')
                    setTimeout(()=>{
                        window.location.reload()
                    }, 1000)
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
                }
            })
        }
    })

</script>
