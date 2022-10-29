<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Radio
        v-model="data.type"
        field="data.type"
        title="Type"
        :list="[
          { value: 'Photos', title: 'Photos' },
          { value: 'Videos', title: 'Videos' },
        ]"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <Input v-model="data.name" field="data.name" title="Name" :req="true" />
      <!------------ Single Input ------------>
      <File title="Image" field="data.image" mime="img" fileClassName="file2" />
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "album";

export default {
  data() {
    return {
      model: model,
      data: { type: "Photos", image: "", sorting: 0 },
      image: { image: "" },
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
      // this.get_sorting("Website-News");
    }
  },

  // validation rule for form
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.image": function (value = null) {
      if (!value.type) {
        return false;
      }
      return Validator.value(value)
        .required("Image is required")
        .custom(function () {
          if (!Validator.isEmpty(value)) {
            var type = value.type;
            if (
              type == "image/jpeg" ||
              type == "image/jpg" ||
              type == "image/png"
            ) {
            } else {
              return "Image must be of type .jpg .jpeg or .png";
            }
          }
        });
    },
  },
};
</script>