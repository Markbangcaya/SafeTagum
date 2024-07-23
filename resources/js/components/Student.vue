<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="cesiumContainer"></div>
                <!-- <div class="card">
                    <div class="card-header">Student Information</div>

                    <div class="card-body">
                        <alert-error :form="form"></alert-error>
                        <form method="POST">
                            <div class="form-group">
                                <label>Student Name</label>
                                <input v-model="form.name" type="text" class="form-control">
                                <has-error :form="form" field="name" />
                            </div>
                            <div class="form-group">
                                <label>Scholarship</label>
                                <input v-model="form.scholarship" type="text" class="form-control">
                                <has-error :form="form" field="scholarship" />
                            </div>
                            <div class="form-group">
                                <label>Grade Point Average (GPA)</label>
                                <input v-model="form.GPA" type="number" class="form-control">
                                <has-error :form="form" field="GPA" />
                            </div>
                            <div class="form-group required">
                                <label>Course</label>
                                <multiselect v-model="form.course_id" placeholder="Search Course" label="course"
                                    track-by="id" :options="option_course" :multiple="false" :close-on-select="true"
                                    :clear-on-select="false"></multiselect>
                                <has-error :form="form" field="course_id.id" />
                            </div>
                            <button type="button" class="btn btn-primary" @click="create">Save</button>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>
<!-- <script>
// Your access token can be found at: https://ion.cesium.com/tokens.
// This is the default access token from your ion account

Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJjZTBiOWQ1NC1mNmIyLTRlZjMtYjgwYS0yNmU3N2U1ZDRkOWQiLCJpZCI6MTM4NjYzLCJpYXQiOjE2ODQxMzEwMDJ9.JYNWKAXnvJ_RMOVZHyGEpHgkiGOq9TVZp8Vuya9-YyE';

// Initialize the Cesium Viewer in the HTML element with the `cesiumContainer` ID.
const viewer = new Cesium.Viewer('cesiumContainer', {
    terrainProvider: Cesium.createWorldTerrain()
});
// Add Cesium OSM Buildings, a global 3D buildings layer.
const buildingTileset = viewer.scene.primitives.add(Cesium.createOsmBuildings());
// Fly the camera to San Francisco at the given longitude, latitude, and height.
viewer.camera.flyTo({
    destination: Cesium.Cartesian3.fromDegrees(-122.4175, 37.655, 400),
    orientation: {
        heading: Cesium.Math.toRadians(0.0),
        pitch: Cesium.Math.toRadians(-15.0),
    }
});
</script> -->
<style>
#cesiumContainer {
    height: 400px;
}
</style>
<script>
export default {
    data() {
        return {
            form: new Form({
                name: '',
                scholarship: '',
                GPA: '',
                course_id: '',
            }),
            option_course: [],
        }
    },
    methods: {
        create() {
            this.form.post('/api/create/student').then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        loadCourse() {
            axios.get('/api/course/all')
                .then(response => {
                    this.option_course = response.data.data;
                });
        },
    },
    mounted() {
        this.loadCourse();
        // Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIwNjJhYTMzNS1lNzZkLTRmNWQtYmY5Zi0wYjdkYjQ2MTE4ZTYiLCJpZCI6NDc1NjUsImlhdCI6MTYxNzEzNTEzOH0.lf_WWRtP9LlyYbVSr0KdhFI4FzReQsqKQwK-vYK5BPI';
        const accessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJjZjc4ODRmNi1jZmQ1LTQ1N2UtYTMxNC03MDIwMmI3OGQ4YjYiLCJpZCI6MTM4NjYzLCJpYXQiOjE2ODQxNDQ3NDh9.paSXw1ZeZSNRLTVAxED9KdmC0An41eXPdi37gTqC_hY';
        const script = document.createElement('script');
        script.src = 'https://cesium.com/downloads/cesiumjs/releases/1.50/Build/Cesium/Cesium.js?access_token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJjZjc4ODRmNi1jZmQ1LTQ1N2UtYTMxNC03MDIwMmI3OGQ4YjYiLCJpZCI6MTM4NjYzLCJpYXQiOjE2ODQxNDQ3NDh9.paSXw1ZeZSNRLTVAxED9KdmC0An41eXPdi37gTqC_hY';
        script.async = true;
        script.onload = () => {
            const viewer = new Cesium.Viewer('cesiumContainer', {
                terrainProvider: Cesium.createWorldTerrain(),
                geocoder: false,
                imageryProvider: false,
                baseLayerPicker: false
            });
            // Cesium code goes here
        };
        document.head.appendChild(script);
    }
}
</script>
