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
      <File title="Image" field="data.image" mime="img" fileClassName="file2" />
      <!------------ Single Input ------------>
      <Radio
        v-model="data.status"
        field="data.status"
        title="Status"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'deactive', title: 'Deactive' },
        ]"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <div class="col-12">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>
    </div>
    <Button title="Submit" class="mt-3" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "content";

import Editor from "../../../../components/Form/CKEditor";

export default {
  components: { Editor },
  data() {
    return {
      model: model,
      data: { status: "active", image: "", description: "" },
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
  watch: {
    $route: {
      handler: "asyncData",
      immediate: true,
    },
  },
  methods: {
    asyncData() {
      if (this.$route.params.slug) {
        this.get_data(`${this.model}/${this.$route.params.slug}`);
        var breadcrumb = [
          {
            route: model + ".create",
            title: model + " Create",
            slug: this.$route.params.slug ? this.$route.params.slug : "",
          },
        ];
        this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
      }
    },

    submit: function () {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        // If there is an error
        if (error > 0) {
          this.notification(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        // If there is no error
        if (res) {
          this.$root.submit = true;
          var form = document.getElementById("form");
          var formData = new FormData(form);

          formData.append("description", this.data.description);
          formData.append("slug", this.$route.params.slug);
          axios
            .post("/content", formData)
            .then((res) => {
              if (res.data.message) {
                this.notification(res.data.message, "success");
                this.$router.push({
                  name: "content.show",
                  params: { slug: this.$route.params.slug },
                });
              } else if (res.data.error) {
                this.notification(res.data.error, "error");
                setTimeout(() => {
                  location.reload();
                }, 100);
              } else if (res.data.warning) {
                this.notification(res.data.warning, "warning");
                this.$router.push({
                  name: "content.show",
                  params: { slug: this.$route.params.slug },
                });
              }
            })
            .catch((error) => console.log(error))
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>