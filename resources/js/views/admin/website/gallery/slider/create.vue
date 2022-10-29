<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
      />
      <!------------ Single Input ------------>
      <File
        title="Slider"
        field="data.slider"
        mime="img"
        fileClassName="file2"
        req
      />
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <Input title="URL" field="data.url" v-model="data.url" col="2" />
      <!------------ Single Input ------------>
      <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "slider";

import Editor from "../../../../../components/Form/CKEditor";

export default {
  components: { Editor },

  data() {
    return {
      model: model,
      data: { slider: "", description: "" },
      image: { slider: "" },
    };
  },
  provide() {
    return {
      validate: this.validation,
      data: () => this.data,
      image: this.image,
    };
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
        }

        // If there is no error
        if (res) {
          var form = document.getElementById("form");
          var formData = new FormData(form);

          if (this.data.id) {
            this.update(this.model, formData, this.data.slug, "image");
          } else {
            this.store(this.model, formData);
          }
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Website-Gallery-Slider");
    }
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.slider": function (value = null) {
      return Validator.value(value).required("Slider is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>