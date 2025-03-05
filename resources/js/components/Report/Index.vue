<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Report</a></li>
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
                            <!-- <div class="card-header">Report Information</div> -->
                            <div class="card-body">
                                <div id="remove-print" class="row">
                                    <div class="form-group col-12 col-md-3">
                                        <label>Type of Disease</label>
                                        <multiselect v-model="form.type_of_disease" :options="option_diseases"
                                            :multiple="false" :close-on-select="true" :clear-on-select="false"
                                            :preserve-search="true" placeholder="Pick Type of Disease" label="name"
                                            track-by="name" :preselect-first="true">
                                        </multiselect>
                                        <has-error :form="form" field="type_of_disease" />
                                    </div>
                                    <div class="form-group col-12 col-md-3">
                                        <label>Date Range</label>
                                        <date-range-picker v-model="form.date" style="width: 100%;">
                                        </date-range-picker>
                                        <has-error :form="form" field="date" />
                                    </div>
                                    <div
                                        class="form-group col-8 col-md-4 d-flex align-items-center justify-content-end">
                                        <button v-if="this.form.enable == true" type="button" class="btn btn-success"
                                            @click="printChart"><i class="fas fa-print"></i> Print Report</button>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <label v-if="this.form.enable == true" class="text-center">Reported {{
                                            form.type_of_disease.name }} Cases by Barangay in Tagum City,
                                            ({{
                                                this.form.date.startDate.toLocaleDateString('en-US', {
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric'
                                                }) }} -
                                            {{ this.form.date.endDate.toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            }) }})
                                            <span class="badge badge-danger"> As of Morbidity Week {{
                                                this.form.start_morbidity_week }}
                                                - {{ this.form.end_morbidity_week }}</span>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="row">
                                            <label v-if="this.form.enable == true">Age Groups Affected by {{
                                                this.form.type_of_disease.name }}</label>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info elevation-1"><i
                                                            class="fas fa-baby"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">0-5
                                                            Years Old</span>
                                                        <span class="info-box-number">
                                                            {{ this.age_0_5 }}
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-primary elevation-1"><i
                                                            class="fas fa-child-dress"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">6-10 Years Old</span>
                                                        <span class="info-box-number">{{ this.age_6_10 }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="clearfix hidden-xs-up"></div> -->
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-warning elevation-1"><i
                                                            class="fas fa-child"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">11-15 Years Old</span>
                                                        <span class="info-box-number">{{ this.age_11_15 }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-secondary elevation-1"><i
                                                            class="fas fa-person"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">16 And Above Years Old</span>
                                                        <span class="info-box-number">{{ this.age_16_above }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-danger elevation-1"><i
                                                            class="fas fa-skull-crossbones"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Death</span>
                                                        <span class="info-box-number">{{ this.death }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-success elevation-1"><i
                                                            class="fas fa-circle-plus"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Grand Total of Cases</span>
                                                        <span class="info-box-number">{{ this.total_cases }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Case Classifications</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card bg-danger text-white">
                                                    <div class="card-body">
                                                        <span class="legend-color bg-danger">Confirmed</span>
                                                        <div class="case-count fs-2 float-right">{{ this.confirmed
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card bg-warning text-dark">
                                                    <div class="card-body">
                                                        <span class="legend-color bg-warning">Suspected</span>
                                                        <div class="case-count fs-2 float-right"> {{ this.suspected
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card bg-success text-white">
                                                    <div class="card-body">
                                                        <span class="legend-color bg-success">Probable</span>
                                                        <div class="case-count fs-2 float-right">{{ this.probable }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row">
                                    <label>Number of Cases Per Barangay</label>
                                    <div class="table-responsive">
                                        <table class="table table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center">Barangay</th>
                                                    <th colspan="4" class="text-center">Age Groups</th>
                                                    <th rowspan="2">Death</th>
                                                    <th rowspan="2">Grand Total of Cases</th>
                                                    <th colspan="3" class="text-center">Case Classification</th>
                                                </tr>
                                                <tr>
                                                    <!-- <th scope="col">Barangay</th> -->
                                                    <th scope="col">0-5 Years Old</th>
                                                    <th scope="col">6-10 Years Old</th>
                                                    <th scope="col">11-15 Years Old</th>
                                                    <th scope="col">16 and Above Years Old</th>
                                                    <th scope="col">Confirmed</th>
                                                    <th scope="col">Suspected</th>
                                                    <th scope="col">Probable</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="cases.length === 0">
                                                    <td colspan="10">No data available</td>
                                                </tr>
                                                <tr v-for="caseData in cases" :key="caseData.barangay.name">
                                                    <td scope="row">{{ caseData.barangay.name }}</td>
                                                    <td>{{ caseData.count_0_5 }}</td>
                                                    <td>{{ caseData.count_6_10 }}</td>
                                                    <td>{{ caseData.count_11_15 }}</td>
                                                    <td>{{ caseData.count_16_above }}</td>
                                                    <td>{{ caseData.total_deaths }}</td>
                                                    <td>{{ caseData.total_cases }}</td>
                                                    <td>{{ caseData.count_confirmed }}</td>
                                                    <td>{{ caseData.count_suspected }}</td>
                                                    <td>{{ caseData.count_probable }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Age Groups Affected by {{
                                            this.form.type_of_disease.name }} Per Barangay</label>
                                        <bar v-if="showChart" ref="bar" :data="barData" :options="options" />
                                    </div>
                                    <div class="col-6">
                                        <label v-if="this.form.enable == true">Affected by {{
                                            this.form.type_of_disease.name }}
                                            Cases Per Barangay</label>
                                        <div>
                                            <span v-if="loading">Loading...</span>
                                            <label for="checkbox">GeoJSON Visibility</label>
                                            <input id="checkbox" v-model="show" type="checkbox">
                                            <br>
                                            <l-map v-if="showChart" ref="map" :zoom="zoom" :center="center"
                                                style="height: 600px; width: 100%">
                                                <l-tile-layer :url="url" />
                                                <l-geo-json v-if="show" :geojson="geojson" @mouseover="handleMapClick"
                                                    :options-style="styleFunction">
                                                    <l-popup :content="popupContent" />
                                                </l-geo-json>
                                                <l-marker v-for="(marker, index) in markers.data" :key="index"
                                                    :lat-lng="[marker.latitude, marker.longitude]">
                                                </l-marker>
                                                <l-control :position="'bottomleft'" class="custom-control-watermark">
                                                    <img src="/images/legend.png" alt="Legend Image" width="500"
                                                        height="50">
                                                </l-control>
                                                <!-- <l-circle-marker v-for="(marker, index) in markers.data" :key="index"
                                                :lat-lng="[marker.latitude, marker.longitude]" :radius="marker.radius"
                                                :color="marker.color">
                                                <l-popup>
                                                    <p>Count :<b>{{ marker.count }}</b></p>
                                                </l-popup>
                                            </l-circle-marker> -->
                                            </l-map>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-info">
                                    <br>
                                    <br>
                                    <h6><strong>Date Printed:</strong> <span id="reportDate">{{ new
                                        Date().toLocaleDateString() }}</span></h6>
                                    <br>
                                    <h6><strong>Printed by:</strong> <span id="reportUser">{{
                                        this.login_user }}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<style scoped>
.report-info {
    display: none;
}

@media print {

    /* Example: Hide the button on print */
    button {
        display: none;
    }

    #remove-print {
        display: none;
    }

    .report-info {
        display: block;
    }

    /* Example: Print-specific font sizes */
    body {
        font-size: 14pt;
    }

    /* Example: Add margins for printing */
    @page {
        margin: 2cm 5cm;
        /* Adjust margins as needed */
    }
}
</style>
<script>
export default {
    components: {
    },
    data() {
        return {
            form: new Form({
                type_of_disease: '',
                //Patient Address
                barangay: '',
                date: {
                    startDate: new Date(2025, 0, 1),
                    endDate: new Date(2025, 11, 31)
                },
                start_morbidity_week: '0',
                end_morbidity_week: '0',
                enable: false
            }),
            //
            login_user: null,
            cases: null,
            showChart: true,
            chartKey: 0,

            //Choices
            option_diseases: [],
            option_barangay: [],

            //Case Classifications
            suspected: null,
            probable: null,
            confirmed: null,

            //
            age_0_5: null,
            age_6_10: null,
            age_11_15: null,
            age_16_above: null,
            death: null,
            total_cases: null,
            total_cases_barangay: 0,

            //Maps
            loading: false,
            show: true,
            enableTooltip: true,
            zoom: 12,
            center: [7.448040629446573, 125.80747097125365],
            geojson: null,
            markers: [],
            popupContent: '',
            fillColor: "#e4ce7f",
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            // attribution:
            //     '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            props: {
                monthlyVendorDetectionsBarChartData: {
                    type: Object,
                    required: true
                },
                lowSeverity: {
                    type: Number,
                    required: true
                },
                mediumSeverity: {
                    type: Number,
                    required: true
                },
                highSeverity: {
                    type: Number,
                    required: true
                },
                criticalSeverity: {
                    type: Number,
                    required: true
                }
            },
            data: {
                low: [30, 40, 50, 60, 30, 40, 50, 60, 30, 40, 50, 60],
                med: [20, 34, 54, 66, 30, 40, 50, 60, 30, 40, 50, 60],
                high: [69, 69, 69, 69, 96, 99, 96, 69, 69, 44, 20, 11],
                crit: [15, 25, 35, 45, 55, 65, 75, 85, 95, 69, 54, 20]
            },
            // calculate every month's total
            // sumData: data.low.map((num, idx) => {
            //     return num + data.med[idx] + data.high[idx] + data.crit[idx];
            // }),
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: false,
                        text: 'Reported HFMD Cases and Case Fatality Rate by BARANGAY in TAGUM  CITY, MW 1 – 32, (n = 32)',
                        font: {
                            size: 16
                        },
                        padding: {
                            top: 20,
                            bottom: 20
                        }
                    },
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        display: true,
                        title: {
                            display: true,
                            text: 'Barangay',
                            position: 'bottom'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        suggestedMax: 20
                    },
                },
                tension: 0.1
            },
            barData: {
                labels: [],
                datasets: [
                    {
                        label: '0-5 Years Old',
                        data: [],
                        backgroundColor: 'rgb(49,212,246)',
                        borderColor: 'rgb(12,204,244)',
                        borderWidth: 1

                    },
                    {
                        label: '6-10 Years Old',
                        data: [],
                        backgroundColor: 'rgb(24,124,256)',
                        borderColor: 'rgb(12,108,252)',
                        borderWidth: 1
                    },
                    {
                        label: '11-15 Years Old',
                        data: [],
                        backgroundColor: 'rgba(234, 179, 8, .3)',
                        borderColor: 'rgb(234, 179, 8)',
                        borderWidth: 1
                    },
                    {
                        label: '16 And Above Years Old',
                        data: [],
                        backgroundColor: 'rgb(112,116,124)',
                        borderColor: 'rgb(112,116,124)',
                        borderWidth: 1
                    },
                    {
                        label: 'Death',
                        data: [],
                        backgroundColor: 'rgba(239, 68, 68, .3)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    },
                    // {
                    //     label: 'Grand Total of Cases',
                    //     data: [],
                    //     backgroundColor: 'rgba(34, 197, 94, .3)',
                    //     borderColor: 'rgb(34, 197, 94)',
                    //     borderWidth: 1
                    // },
                ]
            }
        }
    },
    methods: {
        printChart() {
            window.print(); // Trigger the browser's print function
        },
        styleFunction(feature) {
            return {
                weight: 3,
                color: "#ffffff",
                opacity: 0.7,
                fillOpacity: 0.5,
                fillColor: feature.properties.fillColor || 'gray'
            };
        },
        report() {
            this.form.post('/api/patient/report').then(response => {
                this.form.start_morbidity_week = Math.ceil((this.form.date.startDate - new Date(this.form.date.startDate.getFullYear(), 0, 1)) / (1000 * 60 * 60 * 24) / 7);
                this.form.end_morbidity_week = Math.ceil((this.form.date.endDate - this.form.date.startDate) / (1000 * 60 * 60 * 24) / 7);
                this.form.enable = true;
                this.login_user = response.data.user.name;
                this.cases = response.data.cases;
                // this.markers = response.data;
                // Swal.fire({
                //     title: 'Report Successfully',
                //     html: "All data belongs to <b>" + this.form.type_of_disease.name + "</b> case being display",
                //     icon: 'success',
                // })
            }).catch(() => {
                Swal.fire({
                    title: 'Report Unsuccessfully',
                    html: "Provide needed information",
                    icon: 'warning',
                })
            });
        },
        handleMapClick(event) {
            // Get the clicked GeoJSON feature
            const clickedFeature = event.layer.feature;

            // Check if the feature has barangay information
            if (clickedFeature.properties && clickedFeature.properties.NAME_3) {
                // Find the case data for the clicked barangay
                const caseData = this.cases.find(c => c.barangay.name.trim().toLowerCase() === clickedFeature.properties.NAME_3.trim().toLowerCase());

                // Display the barangay name and total cases in a popup
                if (caseData) {
                    this.popupContent = `Barangay: ${clickedFeature.properties.NAME_3}<br>Total Cases: ${caseData.total_cases}<br>Total Death: ${caseData.total_deaths}`;
                } else {
                    this.popupContent = `Barangay: ${clickedFeature.properties.NAME_3}<br>Total Cases: 0<br>Total Death: 0`;
                }
            } else {
                this.popupContent = 'No barangay information available.';
            }
            event.layer.bindPopup(this.popupContent).openPopup();
        },
        updateChart(newCases) {
            // Reset the chart data
            this.barData.labels = [];
            this.barData.datasets.forEach(dataset => {
                dataset.data = [];
            });

            // Reset the age groups and case classifications
            this.age_0_5 = 0;
            this.age_6_10 = 0;
            this.age_11_15 = 0;
            this.age_16_above = 0;
            this.death = 0;
            this.total_cases = 0;
            this.confirmed = 0;
            this.suspected = 0;
            this.probable = 0;
            this.geojson = this.resetgeojson();

            // Update the chart data with the new cases
            newCases.forEach(caseData => {
                this.barData.labels.push(caseData.barangay.name);

                // Age Group
                this.barData.datasets[0].data.push(caseData.count_0_5);
                this.age_0_5 += Math.round(caseData.count_0_5);

                this.barData.datasets[1].data.push(caseData.count_6_10);
                this.age_6_10 += Math.round(caseData.count_6_10);

                this.barData.datasets[2].data.push(caseData.count_11_15);
                this.age_11_15 += Math.round(caseData.count_11_15);

                this.barData.datasets[3].data.push(caseData.count_16_above);
                this.age_16_above += Math.round(caseData.count_16_above);

                this.barData.datasets[4].data.push(caseData.total_deaths);
                this.death += Math.round(caseData.total_deaths);

                // Total Cases
                this.total_cases += Math.round(caseData.total_cases);
                this.total_cases_barangay += Math.round(caseData.total_cases);

                // Case Classifications
                this.confirmed += Math.round(caseData.count_confirmed);
                this.suspected += Math.round(caseData.count_suspected);
                this.probable += Math.round(caseData.count_probable);

                for (let j = 0; j < this.geojson.features.length; j++) {
                    const featureName = this.geojson.features[j].properties.NAME_3;

                    if (!featureName) {
                        console.log("Feature name (NAME_3) is missing for a feature.");
                        continue; // Skip to the next feature
                    }

                    if (featureName.trim().toLowerCase() === caseData.barangay.name.trim().toLowerCase()) {
                        if (this.total_cases_barangay > 100) {
                            this.geojson.features[j].properties.fillColor = "red";
                        } else if (this.total_cases_barangay >= 50 && this.total_cases_barangay <= 100) {
                            this.geojson.features[j].properties.fillColor = "yellow";
                        } else if (this.total_cases_barangay > 0 && this.total_cases_barangay < 50) {
                            this.geojson.features[j].properties.fillColor = "green";
                        } else {
                            this.geojson.features[j].properties.fillColor = "gray";
                        }
                        if (caseData.total_deaths > 0) {
                            this.geojson.features[j].properties.fillColor = "red";
                        }

                        this.total_cases_barangay = 0;
                    }
                }
            });
            // Force chart update
            this.showChart = false;
            this.$nextTick(() => {
                this.showChart = true;
            });
        },
        resetgeojson() {
            const data = {
                "type": "FeatureCollection",
                "features": [
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12404, "NAME_3": "Apokon", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.828987, 7.439100], [125.828598, 7.436860], [125.829063, 7.436220], [125.829674, 7.435460], [125.829529, 7.434310], [125.828529, 7.433040], [125.828117, 7.432740], [125.827003, 7.432450], [125.826637, 7.432270], [125.826912, 7.431440], [125.827682, 7.430130], [125.828339, 7.429490], [125.829536, 7.430050], [125.830353, 7.430930], [125.830620, 7.429940], [125.830521, 7.428790], [125.830612, 7.426350], [125.831253, 7.427000], [125.834671, 7.428010], [125.833961, 7.426030], [125.833801, 7.425100], [125.835083, 7.424080], [125.837479, 7.422670], [125.838509, 7.421340], [125.838989, 7.421320], [125.840027, 7.422140], [125.841148, 7.422470], [125.841438, 7.421410], [125.840759, 7.420250], [125.839256, 7.419020], [125.838371, 7.418580], [125.838333, 7.417980], [125.838478, 7.416490], [125.838814, 7.415360], [125.839203, 7.412980], [125.840118, 7.412480], [125.840973, 7.412870], [125.841881, 7.411960], [125.841652, 7.411110], [125.841019, 7.410020], [125.840446, 7.409650], [125.839478, 7.408730], [125.839684, 7.408020], [125.841530, 7.408050], [125.842461, 7.407800], [125.843002, 7.406540], [125.842796, 7.405510], [125.841743, 7.404310], [125.839890, 7.404000], [125.838814, 7.403720], [125.838440, 7.403300], [125.838120, 7.402170], [125.838150, 7.401740], [125.838203, 7.398250], [125.837540, 7.397420], [125.836037, 7.395720], [125.834747, 7.393970], [125.834846, 7.392500], [125.834610, 7.390650], [125.831413, 7.388760], [125.830910, 7.388410], [125.823021, 7.398950], [125.820709, 7.402870], [125.816971, 7.407660], [125.815887, 7.420320], [125.816368, 7.433450], [125.818069, 7.442250], [125.822021, 7.443530], [125.828743, 7.439230], [125.828987, 7.439100]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12405, "NAME_3": "Bincungan", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.760246, 7.399260], [125.772247, 7.389360], [125.786858, 7.384280], [125.780457, 7.378910], [125.755127, 7.359990], [125.750519, 7.366470], [125.744186, 7.363660], [125.744003, 7.366590], [125.744148, 7.368850], [125.746727, 7.370920], [125.748756, 7.372320], [125.749336, 7.375360], [125.752403, 7.377240], [125.752098, 7.381220], [125.745621, 7.377740], [125.745407, 7.380400], [125.749313, 7.382090], [125.751007, 7.384540], [125.748749, 7.386690], [125.748016, 7.390100], [125.751587, 7.390340], [125.753410, 7.393150], [125.753418, 7.396700], [125.756340, 7.397230], [125.760246, 7.399260]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12406, "NAME_3": "Busaon", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.794456, 7.365150], [125.796387, 7.364830], [125.794052, 7.361820], [125.796463, 7.361510], [125.798119, 7.362400], [125.799271, 7.362530], [125.802277, 7.362400], [125.803772, 7.362890], [125.806313, 7.365210], [125.808479, 7.366340], [125.810181, 7.365900], [125.811478, 7.365960], [125.813141, 7.365880], [125.812553, 7.365000], [125.812469, 7.364980], [125.811981, 7.365260], [125.811699, 7.365260], [125.811417, 7.365120], [125.811150, 7.364630], [125.810997, 7.364080], [125.810944, 7.363520], [125.810753, 7.363190], [125.810593, 7.362900], [125.810341, 7.362340], [125.809967, 7.362070], [125.809601, 7.361830], [125.809242, 7.361600], [125.808952, 7.361300], [125.808701, 7.360950], [125.808357, 7.360670], [125.808006, 7.360370], [125.807632, 7.360140], [125.807213, 7.359970], [125.807007, 7.359830], [125.806847, 7.359720], [125.806488, 7.359450], [125.806137, 7.359200], [125.805794, 7.358960], [125.805443, 7.358750], [125.805107, 7.358470], [125.804703, 7.358230], [125.804253, 7.357970], [125.803802, 7.357530], [125.803108, 7.356910], [125.802338, 7.356520], [125.797783, 7.357460], [125.787697, 7.359420], [125.780983, 7.360810], [125.769463, 7.360030], [125.755432, 7.355320], [125.755127, 7.359990], [125.780457, 7.378910], [125.782654, 7.374250], [125.782059, 7.373300], [125.782433, 7.372690], [125.784157, 7.373040], [125.784866, 7.372420], [125.785332, 7.370170], [125.786522, 7.368300], [125.786758, 7.367010], [125.786621, 7.365300], [125.786781, 7.363920], [125.788193, 7.362810], [125.792023, 7.364540], [125.794456, 7.365150]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12407, "NAME_3": "Canocotan", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.802322, 7.403690], [125.801323, 7.397690], [125.779404, 7.399430], [125.772247, 7.389360], [125.760246, 7.399260], [125.761230, 7.401370], [125.761627, 7.404360], [125.763733, 7.406800], [125.765404, 7.411430], [125.765373, 7.416120], [125.784233, 7.413400], [125.783310, 7.410430], [125.791496, 7.404630], [125.802322, 7.403690]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12408, "NAME_3": "Cuambogan", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.808456, 7.514220], [125.807327, 7.491930], [125.807541, 7.487990], [125.808296, 7.485930], [125.805908, 7.483070], [125.804932, 7.481270], [125.803009, 7.476310], [125.797836, 7.465880], [125.793266, 7.469680], [125.791733, 7.470750], [125.782532, 7.478490], [125.781067, 7.482370], [125.778107, 7.490280], [125.775787, 7.503790], [125.776581, 7.504220], [125.776550, 7.504040], [125.794548, 7.510150], [125.799652, 7.511720], [125.808456, 7.514220]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12409, "NAME_3": "La Filipina", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.826027, 7.484170], [125.827637, 7.481220], [125.829781, 7.473930], [125.819092, 7.464800], [125.813187, 7.464690], [125.797836, 7.465880], [125.803009, 7.476310], [125.804932, 7.481270], [125.805908, 7.483070], [125.808296, 7.485930], [125.818970, 7.484620], [125.825104, 7.483840], [125.826027, 7.484170]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12410, "NAME_3": "Liboganon", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.755127, 7.359990], [125.755432, 7.355320], [125.769463, 7.360030], [125.780983, 7.360810], [125.787697, 7.359420], [125.797783, 7.357460], [125.802338, 7.356520], [125.801720, 7.356210], [125.800926, 7.355230], [125.800117, 7.354840], [125.799843, 7.354420], [125.799583, 7.353980], [125.799019, 7.353700], [125.798187, 7.352830], [125.797760, 7.352510], [125.797348, 7.352250], [125.796967, 7.352060], [125.796677, 7.351850], [125.796448, 7.351640], [125.796227, 7.351380], [125.795967, 7.351080], [125.795700, 7.350700], [125.795357, 7.350330], [125.794884, 7.350060], [125.794312, 7.349950], [125.793777, 7.349710], [125.793289, 7.349380], [125.792847, 7.348940], [125.792480, 7.348390], [125.792061, 7.347930], [125.791580, 7.347670], [125.791153, 7.347440], [125.790779, 7.347200], [125.790451, 7.346890], [125.790283, 7.346390], [125.790001, 7.346390], [125.789436, 7.345830], [125.788887, 7.345830], [125.788612, 7.345560], [125.788330, 7.345560], [125.787781, 7.345000], [125.787498, 7.345000], [125.787216, 7.344720], [125.786942, 7.344720], [125.786667, 7.344440], [125.786392, 7.344440], [125.785843, 7.343890], [125.785004, 7.343890], [125.784721, 7.343610], [125.784447, 7.343610], [125.783890, 7.344170], [125.783058, 7.343330], [125.783058, 7.343060], [125.782501, 7.342500], [125.782501, 7.342220], [125.782219, 7.341940], [125.781937, 7.341940], [125.781670, 7.341670], [125.781387, 7.341670], [125.780830, 7.341110], [125.780563, 7.341110], [125.780281, 7.340830], [125.779716, 7.340830], [125.779442, 7.340560], [125.779167, 7.340560], [125.778893, 7.340280], [125.778610, 7.340280], [125.778343, 7.340000], [125.777779, 7.340000], [125.777496, 7.339720], [125.777222, 7.339720], [125.776947, 7.339440], [125.776390, 7.339440], [125.776108, 7.339170], [125.772499, 7.339170], [125.772217, 7.338890], [125.771942, 7.338890], [125.770844, 7.337780], [125.770554, 7.337780], [125.770279, 7.337500], [125.769997, 7.337500], [125.769722, 7.337220], [125.768890, 7.337220], [125.768608, 7.336940], [125.768059, 7.336940], [125.766403, 7.336460], [125.765152, 7.336040], [125.763550, 7.335550], [125.762581, 7.335140], [125.761818, 7.334790], [125.760567, 7.334170], [125.760078, 7.334030], [125.758759, 7.333400], [125.757233, 7.332780], [125.756943, 7.332780], [125.756157, 7.332450], [125.755119, 7.331960], [125.754288, 7.331410], [125.753593, 7.330920], [125.752693, 7.330440], [125.752220, 7.330000], [125.751953, 7.329720], [125.751953, 7.329440], [125.751389, 7.328890], [125.751106, 7.328890], [125.750832, 7.328610], [125.750000, 7.328610], [125.749733, 7.328330], [125.749443, 7.328330], [125.748337, 7.327220], [125.748047, 7.327220], [125.747498, 7.326670], [125.747498, 7.326390], [125.746948, 7.325830], [125.746948, 7.325560], [125.746391, 7.325560], [125.745552, 7.324720], [125.745003, 7.324720], [125.744720, 7.324440], [125.743889, 7.324440], [125.742233, 7.322780], [125.741943, 7.322780], [125.741386, 7.322220], [125.741112, 7.322220], [125.740547, 7.321670], [125.739563, 7.320900], [125.739166, 7.320560], [125.738609, 7.320000], [125.738548, 7.320000], [125.739723, 7.321700], [125.741837, 7.326420], [125.741547, 7.328950], [125.738869, 7.328950], [125.737137, 7.327860], [125.734497, 7.328690], [125.736580, 7.335950], [125.737061, 7.337050], [125.739052, 7.336270], [125.742981, 7.335730], [125.745651, 7.340360], [125.745743, 7.343040], [125.744476, 7.345970], [125.748306, 7.347870], [125.747177, 7.349770], [125.747223, 7.353190], [125.745354, 7.355020], [125.743752, 7.358320], [125.745651, 7.359540], [125.744186, 7.363660], [125.750519, 7.366470], [125.755127, 7.359990]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12411, "NAME_3": "Madaum", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "MultiPolygon", "coordinates": [[[[125.819725, 7.362222], [125.819725, 7.361945], [125.819168, 7.361389], [125.818886, 7.361389], [125.818886, 7.361667], [125.818611, 7.361945], [125.818336, 7.361945], [125.818054, 7.362222], [125.817780, 7.362222], [125.816948, 7.363056], [125.816948, 7.364167], [125.817223, 7.364444], [125.817986, 7.364121], [125.818329, 7.363913], [125.818954, 7.363566], [125.819443, 7.363219], [125.820000, 7.362500], [125.819725, 7.362222]]], [[[125.833488, 7.366650], [125.833321, 7.365960], [125.832359, 7.364780], [125.830528, 7.365380], [125.830727, 7.363470], [125.831947, 7.361940], [125.831390, 7.361940], [125.831108, 7.362220], [125.830276, 7.362220], [125.829437, 7.363060], [125.829170, 7.363060], [125.828613, 7.363610], [125.828331, 7.363610], [125.828056, 7.363890], [125.827766, 7.363890], [125.827499, 7.364170], [125.827217, 7.364170], [125.826942, 7.364440], [125.826668, 7.364440], [125.825844, 7.365280], [125.824722, 7.365280], [125.824448, 7.365560], [125.823891, 7.365560], [125.823608, 7.365830], [125.822220, 7.365830], [125.821953, 7.366110], [125.821388, 7.366110], [125.821114, 7.366390], [125.820557, 7.366370], [125.819794, 7.366440], [125.819450, 7.366340], [125.819313, 7.366300], [125.818893, 7.366230], [125.818527, 7.366160], [125.818192, 7.366090], [125.817841, 7.365950], [125.817291, 7.365950], [125.816803, 7.365760], [125.816399, 7.365650], [125.815964, 7.365770], [125.815498, 7.365830], [125.815079, 7.365830], [125.815033, 7.365830], [125.814590, 7.365790], [125.814194, 7.365610], [125.813782, 7.365500], [125.813454, 7.365290], [125.813141, 7.365110], [125.812553, 7.365000], [125.813141, 7.365880], [125.811478, 7.365960], [125.810181, 7.365900], [125.808479, 7.366340], [125.806313, 7.365210], [125.803772, 7.362890], [125.802277, 7.362400], [125.799271, 7.362530], [125.798119, 7.362400], [125.796463, 7.361510], [125.794052, 7.361820], [125.796387, 7.364830], [125.794456, 7.365150], [125.795311, 7.365680], [125.796043, 7.367180], [125.798813, 7.372180], [125.804688, 7.384380], [125.804672, 7.391450], [125.801323, 7.397690], [125.802322, 7.403690], [125.803833, 7.406520], [125.816971, 7.407660], [125.820709, 7.402870], [125.823021, 7.398950], [125.830910, 7.388410], [125.832024, 7.388370], [125.833092, 7.388220], [125.832077, 7.386520], [125.831161, 7.386020], [125.831093, 7.384850], [125.831047, 7.383920], [125.831017, 7.382730], [125.831108, 7.381980], [125.831573, 7.380460], [125.831779, 7.379150], [125.831993, 7.377980], [125.833000, 7.377400], [125.834343, 7.376800], [125.834663, 7.376200], [125.834541, 7.374860], [125.833809, 7.373390], [125.832611, 7.371990], [125.832108, 7.371200], [125.831711, 7.370020], [125.831970, 7.369460], [125.832481, 7.368350], [125.833618, 7.367190], [125.833488, 7.366650]]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12412, "NAME_3": "Magdum", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.849442, 7.476830], [125.851898, 7.472220], [125.851959, 7.471230], [125.850533, 7.469150], [125.849747, 7.467860], [125.849113, 7.468970], [125.848877, 7.470500], [125.847816, 7.471520], [125.847343, 7.473720], [125.846672, 7.474270], [125.846169, 7.473800], [125.846291, 7.472320], [125.846237, 7.471110], [125.845428, 7.471350], [125.844261, 7.471480], [125.843437, 7.471010], [125.843040, 7.470680], [125.841454, 7.468800], [125.840637, 7.467670], [125.837517, 7.460970], [125.832779, 7.466840], [125.830963, 7.468660], [125.829941, 7.472220], [125.829781, 7.473930], [125.827637, 7.481220], [125.834648, 7.483410], [125.849442, 7.476830]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12413, "NAME_3": "Magugpo East", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.837517, 7.460970], [125.836243, 7.461650], [125.834877, 7.462030], [125.834381, 7.461520], [125.834221, 7.461380], [125.834396, 7.460300], [125.834824, 7.458780], [125.835449, 7.458140], [125.836060, 7.456920], [125.835487, 7.454860], [125.834587, 7.454030], [125.833397, 7.453880], [125.833076, 7.453030], [125.832428, 7.452260], [125.831253, 7.451130], [125.831543, 7.450090], [125.830917, 7.448310], [125.830200, 7.446830], [125.829857, 7.445610], [125.829498, 7.444270], [125.829788, 7.441850], [125.829727, 7.440760], [125.829422, 7.440100], [125.828987, 7.439100], [125.828743, 7.439230], [125.822021, 7.443530], [125.818069, 7.442250], [125.816452, 7.444060], [125.814819, 7.444780], [125.815643, 7.445940], [125.818787, 7.453020], [125.832779, 7.466840], [125.837517, 7.460970]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12414, "NAME_3": "Magugpo North", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.829781, 7.473930], [125.829941, 7.472220], [125.830963, 7.468660], [125.832779, 7.466840], [125.818787, 7.453020], [125.819092, 7.464800], [125.829781, 7.473930]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12415, "NAME_3": "Magugpo Poblacion", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.818787, 7.453020], [125.815643, 7.445940], [125.814819, 7.444780], [125.804932, 7.437110], [125.809196, 7.451360], [125.810989, 7.450430], [125.818787, 7.453020]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12416, "NAME_3": "Magugpo South", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.798973, 7.456700], [125.804497, 7.454040], [125.809196, 7.451360], [125.804932, 7.437110], [125.800392, 7.436240], [125.797737, 7.448110], [125.796707, 7.452460], [125.798973, 7.456700]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12417, "NAME_3": "Magugpo West", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.819092, 7.464800], [125.818787, 7.453020], [125.810989, 7.450430], [125.809196, 7.451360], [125.804497, 7.454040], [125.798973, 7.456700], [125.797836, 7.465880], [125.813187, 7.464690], [125.819092, 7.464800]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12418, "NAME_3": "Mankilam", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.782532, 7.478490], [125.791733, 7.470750], [125.793266, 7.469680], [125.797836, 7.465880], [125.798973, 7.456700], [125.796707, 7.452460], [125.797737, 7.448110], [125.796700, 7.448860], [125.795410, 7.449260], [125.793922, 7.448960], [125.791451, 7.448970], [125.787453, 7.449650], [125.784554, 7.449430], [125.782440, 7.448810], [125.780518, 7.448090], [125.778908, 7.447970], [125.777611, 7.447110], [125.775597, 7.447500], [125.772888, 7.446880], [125.765747, 7.445560], [125.776176, 7.466120], [125.779449, 7.472820], [125.782051, 7.477000], [125.782532, 7.478490]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12419, "NAME_3": "New Balamban", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.852509, 7.528100], [125.855949, 7.520820], [125.858299, 7.516160], [125.859596, 7.513570], [125.861557, 7.509760], [125.863167, 7.507240], [125.865257, 7.502870], [125.866043, 7.501670], [125.867447, 7.498870], [125.867928, 7.497740], [125.869324, 7.495820], [125.868111, 7.494470], [125.867172, 7.493340], [125.863426, 7.490040], [125.860046, 7.487130], [125.852661, 7.481180], [125.851860, 7.481700], [125.850563, 7.484350], [125.847961, 7.489600], [125.846191, 7.493890], [125.843689, 7.499500], [125.839844, 7.507230], [125.833366, 7.521450], [125.838654, 7.523160], [125.846062, 7.525520], [125.852509, 7.528100]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12420, "NAME_3": "Nueva Fuerza", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.833366, 7.521450], [125.832764, 7.494840], [125.826027, 7.484170], [125.825104, 7.483840], [125.818970, 7.484620], [125.808296, 7.485930], [125.807541, 7.487990], [125.807327, 7.491930], [125.808456, 7.514220], [125.812187, 7.515170], [125.814682, 7.515600], [125.819977, 7.517530], [125.820328, 7.517680], [125.826462, 7.519620], [125.832169, 7.520900], [125.833366, 7.521450]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12421, "NAME_3": "Pagsabangan", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.755707, 7.495220], [125.755753, 7.495230], [125.765068, 7.499120], [125.770699, 7.501340], [125.775787, 7.503790], [125.778107, 7.490280], [125.781067, 7.482370], [125.782532, 7.478490], [125.782051, 7.477000], [125.779449, 7.472820], [125.776176, 7.466120], [125.765747, 7.445560], [125.764816, 7.444580], [125.764008, 7.443570], [125.763390, 7.443160], [125.761963, 7.441700], [125.759804, 7.441330], [125.758904, 7.440670], [125.758331, 7.441430], [125.759430, 7.445510], [125.756531, 7.449950], [125.756660, 7.453070], [125.759819, 7.454480], [125.760384, 7.457480], [125.762444, 7.462200], [125.763649, 7.464710], [125.760986, 7.466050], [125.757431, 7.469070], [125.756828, 7.473100], [125.753067, 7.473850], [125.750877, 7.471220], [125.747276, 7.469900], [125.745369, 7.472870], [125.746223, 7.476330], [125.743530, 7.479980], [125.741386, 7.478740], [125.737717, 7.476210], [125.736679, 7.478940], [125.743477, 7.482950], [125.745781, 7.491330], [125.750900, 7.493460], [125.753258, 7.494360], [125.755707, 7.495220]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12422, "NAME_3": "Pandapan", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.869324, 7.495820], [125.870552, 7.494780], [125.872147, 7.493770], [125.874031, 7.493510], [125.875801, 7.493170], [125.876793, 7.491740], [125.878548, 7.490840], [125.881348, 7.491350], [125.883102, 7.492140], [125.884811, 7.491210], [125.885979, 7.488420], [125.885902, 7.486820], [125.883812, 7.485300], [125.882889, 7.483980], [125.881538, 7.482610], [125.879807, 7.482610], [125.877632, 7.482380], [125.876442, 7.480940], [125.873863, 7.477840], [125.871964, 7.477660], [125.869652, 7.478510], [125.866508, 7.480490], [125.865349, 7.480280], [125.864594, 7.482020], [125.862587, 7.482180], [125.859497, 7.481110], [125.856354, 7.479690], [125.854881, 7.478690], [125.853561, 7.477530], [125.852928, 7.476830], [125.852539, 7.475990], [125.853981, 7.474320], [125.853073, 7.472960], [125.852600, 7.472470], [125.851959, 7.471230], [125.851898, 7.472220], [125.849442, 7.476830], [125.852661, 7.481180], [125.860046, 7.487130], [125.863426, 7.490040], [125.867172, 7.493340], [125.868111, 7.494470], [125.869324, 7.495820]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12423, "NAME_3": "San Agustin", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.833366, 7.521450], [125.839844, 7.507230], [125.843689, 7.499500], [125.846191, 7.493890], [125.847961, 7.489600], [125.850563, 7.484350], [125.851860, 7.481700], [125.852661, 7.481180], [125.849442, 7.476830], [125.834648, 7.483410], [125.827637, 7.481220], [125.826027, 7.484170], [125.832764, 7.494840], [125.833366, 7.521450]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12424, "NAME_3": "San Isidro", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.801323, 7.397690], [125.804672, 7.391450], [125.804688, 7.384380], [125.798813, 7.372180], [125.796043, 7.367180], [125.795311, 7.365680], [125.794456, 7.365150], [125.792023, 7.364540], [125.788193, 7.362810], [125.786781, 7.363920], [125.786621, 7.365300], [125.786758, 7.367010], [125.786522, 7.368300], [125.785332, 7.370170], [125.784866, 7.372420], [125.784157, 7.373040], [125.782433, 7.372690], [125.782059, 7.373300], [125.782654, 7.374250], [125.780457, 7.378910], [125.786858, 7.384280], [125.772247, 7.389360], [125.779404, 7.399430], [125.801323, 7.397690]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12425, "NAME_3": "San Miguel", "NL_NAME_3": "", "VARNAME_3": "Camp 4", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.797737, 7.448110], [125.800392, 7.436240], [125.799026, 7.436280], [125.798714, 7.436150], [125.792084, 7.433210], [125.787857, 7.431260], [125.783218, 7.429060], [125.781097, 7.428600], [125.773903, 7.427240], [125.755363, 7.422590], [125.757187, 7.427550], [125.763290, 7.429130], [125.765007, 7.431260], [125.761528, 7.433400], [125.757141, 7.433220], [125.755508, 7.434090], [125.755402, 7.434481], [125.754478, 7.437850], [125.754700, 7.440250], [125.758331, 7.441430], [125.758904, 7.440670], [125.759804, 7.441330], [125.761963, 7.441700], [125.763390, 7.443160], [125.764008, 7.443570], [125.764816, 7.444580], [125.765747, 7.445560], [125.772888, 7.446880], [125.775597, 7.447500], [125.777611, 7.447110], [125.778908, 7.447970], [125.780518, 7.448090], [125.782440, 7.448810], [125.784554, 7.449430], [125.787453, 7.449650], [125.791451, 7.448970], [125.793922, 7.448960], [125.795410, 7.449260], [125.796700, 7.448860], [125.797737, 7.448110]]] } }
                    ,
                    { "type": "Feature", "properties": { "ID_0": 177, "ISO": "PHL", "NAME_0": "Philippines", "ID_1": 27, "NAME_1": "Davao del Norte", "ID_2": 514, "NAME_2": "Tagum City", "ID_3": 12426, "NAME_3": "Visayan Village", "NL_NAME_3": "", "VARNAME_3": "", "TYPE_3": "Barangay", "ENGTYPE_3": "Village", "PROVINCE": "Davao del Norte", "REGION": "Davao Region (Region XI)" }, "geometry": { "type": "Polygon", "coordinates": [[[125.818069, 7.442250], [125.816368, 7.433450], [125.815887, 7.420320], [125.816971, 7.407660], [125.803833, 7.406520], [125.802322, 7.403690], [125.791496, 7.404630], [125.783310, 7.410430], [125.784233, 7.413400], [125.765373, 7.416120], [125.761833, 7.412320], [125.758110, 7.415570], [125.757133, 7.420610], [125.755363, 7.422590], [125.773903, 7.427240], [125.781097, 7.428600], [125.783218, 7.429060], [125.787857, 7.431260], [125.792084, 7.433210], [125.798714, 7.436150], [125.799026, 7.436280], [125.800392, 7.436240], [125.804932, 7.437110], [125.814819, 7.444780], [125.816452, 7.444060], [125.818069, 7.442250]]] } }
                ]
            };
            return data;
        },
        loadDisease() {
            axios.get('/api/disease/all')
                .then(response => {
                    this.option_diseases = response.data.data;
                    if (this.option_diseases.length > 0) {
                        this.form.type_of_disease = this.option_diseases[0]; // Set the default value to the first option
                    }
                });
        },
        loadBarangay() {
            axios.get('/api/barangay/all')
                .then(response => {
                    this.option_barangay = response.data.data;
                });
        }
    },
    watch: {
        'form.type_of_disease': {
            handler() {
                this.report();
            },
            deep: true
        },
        'form.date': {
            handler() {
                this.report();
            },
            deep: true
        },
        cases: {
            handler(newCases) {
                this.updateChart(newCases);
            },
            deep: true
        }
    },
    async created() {
        this.loading = true;
        try {
            // const response = await fetch("./Barangays.json");
            // if (!response.ok) {
            //     throw new Error(`Network response was not ok: ${ response.statusText } `);
            // }
            // const data = await response.json();

            this.geojson = this.resetgeojson();
            // Use the geojsonData to populate your LGeoJson component
        } catch (error) {
            console.error('Error fetching GeoJSON data:', error);
        }
        this.loading = false;
    },
    mounted() {
        this.loadDisease();
        this.loadBarangay();
    }
};
</script>
