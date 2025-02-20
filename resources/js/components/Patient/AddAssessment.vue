<template>
    <div class="modal fade" id="add-assessment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Patient Assessment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Case ID</label>
                            <input v-model="form.case_id" type="text" class="form-control">
                            <has-error :form="form" field="case_id" />
                        </div>
                        <div class="form-group col-4">
                            <label>Epi ID</label>
                            <input v-model="form.epi_id" type="text" class="form-control">
                            <has-error :form="form" field="epi_id" />
                        </div>
                        <div class="form-group col-4">
                            <label>Health Facility</label>
                            <input v-model="form.health_facility" type="text" class="form-control">
                            <has-error :form="form" field="health_facility" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Date Onset of illness</label>
                            <input v-model="form.date_onset_of_illness" type="date" class="form-control">
                            <has-error :form="form" field="date_onset_of_illness" />
                        </div>
                        <div class="form-group col-4">
                            <label>Patient Admitted</label>
                            <input v-model="form.patient_admitted" type="date" class="form-control">
                            <has-error :form="form" field="patient_admitted" />
                        </div>
                        <div class="form-group col-4">
                            <label>Case Classification</label>
                            <select class="form-select" v-model="form.case_classification">
                                <option value="Suspected">Suspected</option>
                                <option value="Probable">Probable</option>
                                <option value="Confirmed">Confirmed</option>
                            </select>
                            <has-error :form="form" field="case_classification" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Date of Death</label><br>
                            <input :disabled="!deathcheckbox" v-model="form.date_of_death" type="date"
                                class="form-control">
                            <input id="deathcheckbox" v-model="deathcheckbox" type="checkbox">
                            <label>Check to Enable</label>
                            <has-error :form="form" field="date_of_death" />
                        </div>
                        <div class="form-group col-4">
                            <label>Type of Disease</label>
                            <multiselect v-model="form.type_of_disease" :options="option_diseases" :multiple="false"
                                :close-on-select="true" :clear-on-select="false" :preserve-search="true"
                                placeholder="Pick Type of Disease" label="name" track-by="name" :preselect-first="true">
                            </multiselect>
                            <has-error :form="form" field="type_of_disease" />
                        </div>
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
    props: {
        row: { required: true },
        page: { required: true },
    },
    data() {
        return {
            form: new Form({
                id: '',
                case_id: '',
                epi_id: '',
                date_onset_of_illness: '',
                health_facility: '',
                patient_admitted: '',
                case_classification: '',
                date_of_death: '',
                type_of_disease: '',
            }),

            option_diseases: [],
            option_barangay: [],

            deathcheckbox: false,
        }
    },
    methods: {
        create() {
            if (this.deathcheckbox == false) {
                this.form.date_of_death = null; // Clear date if unchecked
            }
            this.form.post('/api/patient/assessment/' + this.form.id).then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
                //"page" maintain selected page in the parent page
                this.$emit('getData', this.page);// call method from parent (reload data table)
                $('#add-assessment').modal('hide');
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        loadDisease() {
            axios.get('/api/disease/all')
                .then(response => {
                    this.option_diseases = response.data.data;
                });
        },
        loadBarangay() {
            axios.get('/api/barangay/all')
                .then(response => {
                    this.option_barangay = response.data.data;
                });
        },
    },
    watch: {
        row: function () {
            this.form.id = this.row;
        },
    },
    mounted() {
        this.loadDisease();
        this.loadBarangay();
    }
};
</script>