<template>
    <div class="modal fade" id="add-purok">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Purok</h5>
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
                    <button type="button" class="btn btn-primary" @click="create">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                name: '',
                barangay: '',
            }),
            option_barangay: [],
        }
    },
    methods: {
        create() {
            this.form.post('api/purok/create').then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
                this.$emit('getData');// call method from parent
                $('#add-purok').modal('hide');
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        loadBarangay() {
            axios.get('/api/barangay/all')
                .then(response => {
                    this.option_barangay = response.data.data;
                });
        }
    },
    mounted() {
        this.loadBarangay();
    }
}
</script>
