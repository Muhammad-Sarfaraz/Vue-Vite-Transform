import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable'

import validate_plugin from "simple-vue-validator";

import VueSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';


// ===============CKEditor===============
// import CKEditor from '@ckeditor/ckeditor5-vue';

export default (app) => {
    window.jsPDF = jsPDF;
    window.autoTable = autoTable;
    app.use(jsPDF)

    const Validator = validate_plugin.Validator;
    window.Validator = Validator;
    app.use(validate_plugin)

    // app.use(CKEditor)

    app.component('v-select', VueSelect)
}