<template>
    <div class="modal fade" id="edit-purok">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Purok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name" />
                    </div>
                    <div class="form-group">
                        <label>Barangay</label>
                        <multiselect v-model="form.barangay" :options="option_barangay" :multiple="false"
                            :close-on-select="true" :clear-on-select="false" :preserve-search="true"
                            placeholder="Pick Barangay" label="name" track-by="name" :preselect-first="true">
                        </multiselect>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        row: { required: true },
        page: { required: true },
    },
    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                barangay: '',
            }),
            option_barangay: [],
        }
    },
    methods: {
        update() {
            this.form.put('api/purok/update/' + this.form.id).then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                //"page" maintain selected page in the parent page
                this.$emit('getData', this.page);// call method from parent (reload data table)
                $('#edit-purok').modal('hide');
            }).catch(error => {
                toast.fire({
                    icon: 'error',
                    text: error.message,
                })
            });
        }, loadBarangay() {
            axios.get('/api/barangay/all')
                .then(response => {
                    this.option_barangay = response.data.data;
                });
        }
    },
    watch: {
        row: function () {
            this.form.fill(this.row);
            this.form.barangay = this.option_barangay.find(barangay => barangay.name === this.row.barangay.name);
        }
    },
    mounted() {
        this.loadBarangay();
    }
}
</script>
