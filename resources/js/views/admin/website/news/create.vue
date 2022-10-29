<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <date-picker
        id="date"
        v-model="data.date"
        field="data.date"
        name="date"
        title="Date"
        placeholder="Date"
        col="2"
      >
      </date-picker>
      <!------------ Single Input ------------>
      <Input v-model="data.title" field="data.title" title="Title" req />
      <!------------ Single Input ------------>
      <File
        title="Image"
        field="data.image"
        mime="img"
        fileClassName="file2"
        req
      />
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        req
        col="2"
      />
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
import Editor from "../../../../components/Form/CKEditor";

// define model name
const model = "news";

export default {
  components: { Editor },

  data() {
    return {
      model: model,
      data: { image: "", sorting: 0 },
      image: {},
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
          formData.append("description", this.data.description);

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
      this.get_sorting("Website-News");
    }
  },

  // validation rule for form
  validators: {
    "data.date": function (value = null) {
      return Validator.value(value).required("Date is required");
    },
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.image": function (value = null) {
      return Validator.value(value)
        .required("Image is required")
        .custom(function () {
          if (!value.type) {
            return false;
          }
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
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>