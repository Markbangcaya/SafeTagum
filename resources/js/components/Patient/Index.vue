<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Patient</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Patient</a></li>
                            <!-- <li class="breadcrumb-item active">Starter Page</li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header p-3">
                                <h3 class="card-title"> </h3>
                                <div class="card-tools float-left">
                                    <div class="input-group">
                                        <select v-model="length" @change="getData" class="form-control">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                        </select>
                                        <button class="btn btn-success ml-auto" @click="openAddModal"
                                            v-if="can('show user')"><i class="fas fa-user-plus"></i>
                                            Add</button>
                                        <button type="button" class="btn btn-secondary" @click="exportToExcel">
                                            <i class="fas fa-file-export"></i> Export
                                        </button>
                                    </div>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm ">
                                        <div class="input-group-append">
                                            <multiselect v-model="form.type_of_disease" :options="option_diseases"
                                                :multiple="false" :close-on-select="true" :clear-on-select="false"
                                                :preserve-search="true" placeholder="Filter By Disease" label="name"
                                                track-by="id" :preselect-first="true">
                                            </multiselect>
                                            <multiselect v-model="form.barangay" :options="option_barangay"
                                                :multiple="false" :close-on-select="true" :clear-on-select="false"
                                                :preserve-search="true" placeholder="Filter By Barangay" label="name"
                                                track-by="id" :preselect-first="true">
                                            </multiselect>
                                            <input v-model="search" type="text" @keyup="getData" name="table_search"
                                                class="form-control float-right" placeholder="Search Lastname/Epi ID" />
                                            <button type="button" class="btn btn-primary" @click="getData">
                                                <i class="fas fa-search input-group-append"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Epi ID</th>
                                            <th>Birthdate</th>
                                            <th>Gender</th>
                                            <th>Contact Number</th>
                                            <th>Type of Disease</th>
                                            <th>Barangay</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="loading">
                                            <td colspan="9" class="text-center">
                                                <i class="fas fa-spinner fa-spin"></i> Loading...
                                            </td>
                                        </tr>
                                        <tr v-else v-for="(data, index) in option_users.data" :key="index">
                                            <td>{{ data.id }}</td>
                                            <td><button class="btn btn-warning"
                                                    @click="tokenized(data.id)">Tokenized</button></td>
                                            <td v-if="data.patient__assessment[0] != null">{{
                                                data.patient__assessment[0].epi_id }}</td>
                                            <td v-else class="text-danger">No Epi ID</td>
                                            <td>{{ data.birthdate }}</td>
                                            <td>{{ data.gender }}</td>
                                            <td v-if="data.contact_number != null && data.contact_number != 0">{{
                                                data.contact_number }}</td>
                                            <td v-else class="text-danger">No Contact Number</td>
                                            <td>{{ data.disease.name }}</td>
                                            <td>{{ data.barangay.name }}</td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    @click="openAssessModal(data)" v-if="can('show user')"><i
                                                        class="fas fa-search-plus"></i> Assessment</button>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    @click="openEditModal(data)" v-if="can('show user')"><i
                                                        class="fas fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    @click="remove(data.id)" v-if="can('show user')"><i
                                                        class="fas fa-trash-alt"></i>
                                                    Remove</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="pagination pagination-sm m-1 float-right">
                                    <li class="page-item" v-for="(link, index) in option_users.links" :key="index">
                                        <button v-html="link.label" @click="getData(link.url)" class="page-link"
                                            :disabled="link.url == null || link.active"
                                            :class="{ 'text-muted': link.url == null || link.active }">
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- declare the add modal -->
                    <add-modal @getData="getData"></add-modal>
                    <!-- declare the edit modal -->
                    <edit-modal @getData="getData" :row="selected_user" :page="current_page"></edit-modal>
                    <!-- declare the assess modal -->
                    <assess-modal @getData="getData" :row="selected_user" :page="current_page"></assess-modal>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import $ from 'jquery';
// import 'datatables.net';
// // import 'datatables.net-dt/css/jquery.dataTables.min.css';
// import 'datatables.net-buttons';
// import 'datatables.net-buttons/js/dataTables.buttons.min.js';
// import 'datatables.net-buttons/js/buttons.print.min.js';

import * as XLSX from 'xlsx';
import addModal from "./Add.vue";
import EditModal from "./Edit.vue";
import AssessModal from "./Assessment.vue";
export default {
    components: {
        addModal,
        EditModal,
        AssessModal,
    },
    data() {
        return {
            option_diseases: [],
            option_barangay: [],
            option_users: [],
            length: 10,
            search: '',
            showSchedule: false,
            is_searching: true,
            selected_user: [],
            current_page: [],
            loading: false, // Add loading state

            form: new Form({
                id: '',
                barangay: '',
                type_of_disease: '',
            }),
            error: '',
        }
    },
    methods: {
        openAddModal() {
            $('#add-patient').modal('show');
        },
        openEditModal(data) {
            this.selected_user = data;
            $('#edit-patient').modal('show');
        },
        openAssessModal(data) {
            this.selected_user = data;
            $('#assessment-patient').modal('show');
        },
        getData(page) {
            if (typeof page === 'undefined' || page.type == 'keyup' || page.type == 'change' || page.type == 'click') {
                page = '/api/patient/list/?page=1';
            }
            this.current_page = page;
            this.loading = true;
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            if (this.form.barangay == null) {
                this.form.barangay = '';
            }
            if (this.form.type_of_disease == null) {
                this.form.type_of_disease = '';
            }
            this.timer = setTimeout(() => {
                axios.get(page, {
                    params: {
                        search: this.search,
                        length: this.length,
                        time_start: this.time_start,
                        time_end: this.time_end,
                        barangay: this.form.barangay.id,
                        disease: this.form.type_of_disease.id,
                    },
                })
                    .then(response => {
                        if (response.data.data) {
                            this.option_users = response.data.data;
                            this.loading = false;
                        }
                    }).catch(error => {
                        this.error = error;
                        this.loading = false;
                        toast.fire({
                            icon: 'error',
                            text: error,
                        })
                    });
            }, 500);
        },
        remove(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/patient/delete/' + id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'The data has been deleted.',
                                'success'
                            )
                            this.getData();
                        })
                }
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        tokenized(id) {
            Swal.fire({
                titleText: 'Tokenizing the data...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                axios.get('/api/patient/detokenized/' + id)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tokenized Successful',
                            html: "<b>Firstname: </b>" + response.data.firstname.originaldata + "<br>" +
                                "<b>Middlename: </b>" + response.data.middlename.originaldata + "<br>" +
                                "<b>Lastname: </b>" + response.data.lastname.originaldata,
                        });
                        // Swal.close();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while fetching data.'
                        });
                    });
            }, 2000); // Adjust the delay in milliseconds as needed

            // this.form.put('api/user/update/' + id).then(() => {
            //     toast.fire({
            //         icon: 'success',
            //         text: 'Data Saved.',
            //     })
            //     //"page" maintain selected page in the parent page
            //     // this.$emit('getData', this.page);// call method from parent (reload data table)
            //     // $('#edit-user').modal('hide');
            // }).catch(error => {
            //     toast.fire({
            //         icon: 'error',
            //         text: error.message,
            //     })
            // });
            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Ok',
            // }).then((result) => {
            // }).catch(() => {
            //     toast.fire({
            //         icon: 'error',
            //         text: 'Something went wrong!',
            //     })
            // });
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
        exportToExcel() {
            try {
                if (!this.option_users.data || this.option_users.data.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Data',
                        text: 'There is no data to export.',
                    });
                    return;
                }

                const dataToExport = this.option_users.data.map(user => ({
                    Id: user.id,
                    // Firstname: user.firstname,
                    // Middlename: user.middlename,
                    // Lastname: user.lastname,
                    'Epi ID': user.patient__assessment[0] ? user.patient__assessment[0].epi_id : 'No Epi ID',
                    Gender: user.gender,
                    Birthdate: user.birthdate,
                    'Contact Number': user.contact_number,
                    Email: user.email,
                    'Civil Status': user.civil_status,
                    Nationality: user.nationality,
                    Occupation: user.occupation,
                    'Street/Purok': user['street/purok'],
                    Barangay: user.barangay.name,
                    City: user.city,
                    Province: user.province,
                    'Type of Disease': user.disease.name,
                    // 'Date of Onset': user.date_of_onset,
                    // Latitude: user.latitude,
                    // Longitude: user.longitude,
                    // 'Last Modified By': user.last_modified_by,
                }));
                // console.log(dataToExport); // Add this line to check the data being exported

                const ws = XLSX.utils.json_to_sheet(dataToExport);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Patients');
                XLSX.writeFile(wb, 'Patients.xlsx');

                Swal.fire({
                    icon: 'success',
                    title: 'Export Successful',
                    text: 'The data has been successfully exported to Patients.xlsx.',
                });
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Export Failed',
                    text: 'An error occurred while exporting the data.',
                });
            }
        }
    },
    created() {
        this.getData();
    },
    mounted() {
        this.loadDisease();
        this.loadBarangay();
    }
}

</script>
