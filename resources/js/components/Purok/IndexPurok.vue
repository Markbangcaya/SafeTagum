<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purok</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Purok</a></li>
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
                                    <div class="input-group input-group-sm">
                                        <select v-model="length" @change="getData" class="form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                        </select>
                                        <button class="btn btn-success btn-sm ml-auto" @click="openAddModal"
                                            v-if="can('create user')"><i class="fas fa-user-plus"></i> Add</button>
                                    </div>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm ">
                                        <div class="input-group-append">
                                            <multiselect v-model="form.barangay" :options="option_barangay"
                                                :multiple="false" :close-on-select="true" :clear-on-select="false"
                                                :preserve-search="true" placeholder="Filter By Barangay" label="name"
                                                track-by="id" :preselect-first="true">
                                            </multiselect>
                                            <input v-model="search" type="text" @keyup="getData" name="table_search"
                                                class="form-control float-right" placeholder="search " />
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
                                            <th>Barangay</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, index) in option_puroks.data" :key="index">
                                            <td>{{ data.id }}</td>
                                            <td>{{ data.name }}</td>
                                            <td>{{ data.barangay.name }}</td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    @click="openEditModal(data)" v-if="can('edit user')"><i
                                                        class="fas fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    @click="remove(data.id)" v-if="can('delete user')"><i
                                                        class="fas fa-trash-alt"></i> Remove</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="pagination pagination-sm m-1 float-right">
                                    <li class="page-item" v-for="(link, index) in option_puroks.links" :key="index">
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import addModal from "./AddPurok.vue";
import EditModal from "./EditPurok.vue";
export default {
    components: {
        addModal,
        EditModal,
    },
    data() {
        return {
            option_puroks: [],
            option_barangay: [],
            length: 10,
            search: '',
            showSchedule: false,
            is_searching: true,
            selected_user: [],
            current_page: [],
            form: new Form({
                id: '',
                barangay: '',
            }),
            error: '',
        }
    },
    methods: {
        openAddModal() {
            $('#add-purok').modal('show');
        },
        openEditModal(data) {
            this.selected_user = data;
            $('#edit-purok').modal('show');
        },
        getData(page) {
            if (typeof page === 'undefined' || page.type == 'keyup' || page.type == 'change' || page.type == 'click') {
                page = '/api/purok/list/?page=1';
            }
            this.current_page = page;
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            if (this.form.barangay == null) {
                this.form.barangay = '';
            }
            this.timer = setTimeout(() => {
                axios.get(page, {
                    params: {
                        search: this.search,
                        length: this.length,
                        time_start: this.time_start,
                        time_end: this.time_end,
                        barangay: this.form.barangay.id,
                    },
                })
                    .then(response => {
                        if (response.data.data) {
                            this.option_puroks = response.data.data;
                        }
                    }).catch(error => {
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
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
                    axios.delete('/api/purok/delete/' + id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
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
        }, loadBarangay() {
            axios.get('/api/barangay/all')
                .then(response => {
                    this.option_barangay = response.data.data;
                });
        },
    },
    created() {
        this.getData();
    },
    mounted() {
        this.loadBarangay();
    }
}
</script>
