<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input
        v-model="data.model_name"
        field="data.model_name"
        title="Model Name"
        :req="true"
      />
      <div class="col-lg-4 mb-3">
        <label class="form-label">Only Model : </label> &nbsp;
        <input type="checkbox" value="1" v-model="data.only_model" />
      </div>

      <!-- DB Design -->
      <div class="col-lg-12 mt-4">
        <h4 class="text-black">DB Design</h4>
        <div class="row">
          <table class="table">
            <thead>
              <tr>
                <td style="width: 14%">Field Name</td>
                <td style="width: 15%">Type</td>
                <td style="width: 12%">Length</td>
                <td style="width: 12%; display: none">Unsigned</td>
                <td style="width: 12%; display: none">Default</td>
                <td style="width: 12%">Index</td>
                <td style="width: 12%">Required</td>
                <td style="width: 12%">Input Type</td>
                <td style="width: 150px"></td>
              </tr>
            </thead>
            <tbody v-if="data.databases">
              <tr v-for="(db, key) in data.databases" :key="key">
                <td>
                  <input
                    v-model="db.field_name"
                    type="text"
                    class="form-control form-control-sm"
                  />
                  <small class="text-danger capitalize">
                    {{ errors[`${key}.field_name`] }}
                  </small>
                </td>
                <td>
                  <v-select-container
                    :col="12"
                    style="margin-bottom: 0px !important"
                  >
                    <v-select
                      v-model="db.type"
                      label="value"
                      :reduce="(obj) => obj.id"
                      :options="types"
                      placeholder="--Select Any--"
                      :closeOnSelect="true"
                    >
                    </v-select>
                  </v-select-container>
                  <small class="text-danger capitalize">
                    {{ errors[`${key}.type`] }}
                  </small>
                </td>
                <td>
                  <input
                    v-model="db.length"
                    type="text"
                    class="form-control form-control-sm"
                  />
                  <small class="text-danger capitalize">
                    {{ errors[`${key}.length`] }}
                  </small>
                </td>
                <td style="display: none">
                  <select
                    v-model="db.unsigned"
                    class="form-select form-select-sm"
                  >
                    <option :value="1">Yes</option>
                    <option :value="0">No</option>
                  </select>
                </td>
                <td style="display: none">
                  <select
                    v-model="db.default"
                    class="form-select form-select-sm"
                  >
                    <option :value="1">As Defined</option>
                    <option :value="0">None</option>
                  </select>

                  <input
                    v-if="db.default == 1"
                    v-model="db.default_value"
                    type="text"
                    class="form-control form-control-sm mt-2"
                    placeholder="Default Value"
                  />
                </td>
                <td>
                  <select v-model="db.index" class="form-select form-select-sm">
                    <option :value="0">No</option>
                    <option value="unique">Unique</option>
                    <option value="index">Index</option>
                    <option value="primary">Primary</option>
                  </select>
                </td>
                <td>
                  <select
                    v-model="db.required"
                    class="form-select form-select-sm"
                  >
                    <option :value="1">Yes</option>
                    <option :value="0">No</option>
                  </select>
                </td>
                <td>
                  <select
                    v-model="db.input_type"
                    class="form-select form-select-sm"
                  >
                    <option value="">--Select One--</option>
                    <option value="text">Text</option>
                    <option value="select">Select</option>
                    <option value="textarea">Textarea</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Datepicker</option>
                    <option value="file">File</option>
                  </select>
                </td>
                <td>
                  <button
                    v-if="Object.keys(data.databases).length > 1"
                    @click="data.databases.splice(key, 1)"
                    type="button"
                    class="btn btn-sm btn-danger"
                    style="padding: 1px 6px !important; min-width: 10px"
                  >
                    <i class="fa fa-minus"></i>
                  </button>
                  <button
                    v-if="Object.keys(data.databases).length == key + 1"
                    @click="
                      data.databases.push({
                        field_name: null,
                        type: null,
                        length: null,
                        input_type: '',
                        default: 0,
                        unsigned: 0,
                        required: 0,
                        index: 0,
                      })
                    "
                    type="button"
                    class="btn btn-sm btn-primary"
                    style="padding: 1px 6px !important; min-width: 10px"
                  >
                    <i class="fa fa-plus"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-------------- button -------------->
      <div class="col-12 mb-3 mt-2">
        <Button title="Submit" process="" />
      </div>
    </div>
  </create-form>
</template>

<script>
import Promise from "bluebird";

// define model name
const model = "module";

// set breadcrumb
const breadcrumb = [{ route: "module.create", title: "Module Create" }];

export default {
  data() {
    return {
      model: model,
      disabled: false,
      model_exist: false,
      types: [
        { id: "foreignId", value: "Foreign ID" },
        { id: "id", value: "ID" },
        { id: "bigIncrements", value: "Big Increments" },
        { id: "integer", value: "Integer" },
        { id: "bigInteger", value: "Big Integer" },
        { id: "tinyInteger", value: "Tiny Integer" },
        { id: "string", value: "String" },
        { id: "binary", value: "Binary" },
        { id: "boolean", value: "Boolean" },
        { id: "char", value: "Char" },
        { id: "dateTime", value: "Date Time" },
        { id: "date", value: "Date" },
        { id: "decimal", value: "Decimal" },
        { id: "double", value: "Double" },
        { id: "enum", value: "Enum" },
        { id: "float", value: "Float" },
        { id: "json", value: "Json" },
        { id: "text", value: "Text" },
        { id: "longText", value: "Long Text" },
      ],
      data: {
        databases: [
          {
            field_name: null,
            type: null,
            length: null,
            input_type: "",
            default: 0,
            unsigned: 0,
            required: 0,
            index: 0,
          },
        ],
      },
      validateFields: {
        field_name: null,
        type: null,
        length: null,
      },
      errors: {},
    };
  },
  watch: {
    "data.databases": {
      deep: true,
      handler() {
        this.databasesValidate();
      },
    },
  },
  provide() {
    return {
      validate: this.validation,
    };
  },
  methods: {
    submit: function () {
      this.$validate().then((res) => {
        this.databasesValidate();
        let errors = Object.keys(this.errors).length;
        const error = this.validation.countErrors();
        let countError = errors + error;
        if (countError > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + countError + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        if (res) {
          this.$root.submit = true;
          axios
            .post("/module/create", this.data)
            .then((res) => {
              this.$toast("Module Create Successfully", "success");
              this.$router.push({
                name: this.model + ".index",
                params: { model: this.data.model_name },
              });
            })
            .catch((error) =>
              this.$toast(
                "Something went wrong, but Some file are crated, please check",
                "error"
              )
            )
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },

    databasesValidate() {
      this.errors = {};
      this.data.databases.forEach((obj, ind) => {
        for (const [field_name, value] of Object.entries(this.validateFields)) {
          if (obj.hasOwnProperty(field_name) && !obj[field_name]) {
            let text = field_name.split("_").join(" ");
            this.setErrors(text + " is required", ind, field_name);
          }
        }
      });
    },
    setErrors(message, ...prop) {
      let p = prop.join(".");
      let newError = { [p]: message };
      this.errors = Object.assign(this.errors, newError);
    },
  },
  created() {
    this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
  },

  // validation rule for form
  validators: {
    "data.model_name": function (value = null) {
      var app = this;
      return Validator.value(value)
        .required("Model Name is required")
        .minLength(3)
        .regex("^[a-zA-Z_]*$", "Must only contain alphabetic characters.")
        .regex("(?=.*?[A-Z])", "at least one uppercase letter required")
        .regex("(?=.*?[a-z])", "at least one lowercase letter required")
        .custom(function () {
          if (!Validator.isEmpty(value)) {
            app.disabled = true;
            axios
              .get("/module/check-model", {
                params: { model_name: app.data.model_name },
              })
              .then((res) => {
                if (res.data) {
                  app.model_exist = true;
                } else {
                  app.model_exist = false;
                }
              });
            return Promise.delay(1500).then(function () {
              if (app.model_exist) {
                return "Model name already exists";
              }
              app.disabled = false;
            });
          }
        });
    },
  },
};
</script>

<style >
.capitalize {
  text-transform: capitalize;
}
</style>