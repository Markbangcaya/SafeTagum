
require('./bootstrap');
window.Vue = require('vue').default;
import router from './routes';
import Vue from 'vue';
import Form from 'vform';
import { HasError, AlertError } from 'vform/src/components/bootstrap5';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
});
window.toast = toast;

import VueRouter from 'vue-router';
Vue.use(VueRouter);
Vue.use(LaravelPermissionToVueJS)

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)
//----------------------------------------
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    PointElement,
    LineElement,
    CategoryScale,
    LinearScale,
    ArcElement
} from 'chart.js'
import { Bar, Line, Doughnut } from 'vue-chartjs'
ChartJS.register(Title, Tooltip, Legend, ArcElement, PointElement, BarElement, LineElement, CategoryScale, LinearScale)
Vue.component('bar', Bar);
Vue.component('Doughnut', Doughnut);
Vue.component('line-chart', Line);
// ---------------------------------------
// import Vue from 'vue';
import { LMap, LTileLayer, LMarker, LGeoJson, LPopup, LCircleMarker } from "vue2-leaflet";
import 'leaflet/dist/leaflet.css';

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-geo-json', LGeoJson);
Vue.component('l-popup', LPopup);
Vue.component('l-circle-marker', LCircleMarker);

import { Icon, latLng } from 'leaflet';
Vue.use(latLng)

delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});
//-----------------bootstrap-vue--------------------------
// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
//-----------------Calendar-vue--------------------------
//datepicker
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

Vue.component('date-range-picker', DateRangePicker);
//----------------------------------------
Vue.prototype.can = function (value) {
    return window.Laravel.jsPermissions.permissions.includes(value);
}
Vue.prototype.is = function (value) {
    return window.Laravel.jsPermissions.roles.includes(value);
}
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
Vue.component(
    'forbidden',
    require('./components/Forbidden.vue').default
);
const app = new Vue({
    el: '#app',
    router
});
