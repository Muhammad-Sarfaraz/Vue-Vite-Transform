<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <v-select-container title="Album">
        <v-select
          v-model="data.album_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="albums"
          placeholder="--Select Any--"
          :closeOnSelect="true"
        ></v-select>
        <span
          v-if="validation.hasError('data.album_id')"
          class="input-message danger"
        >
          {{ validation.firstError("data.album_id") }}
        </span>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input v-model="data.title" field="data.title" title="Title" req />
      <Input v-model="data.url" field="data.url" title="URL" req />
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        req
        col="2"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "video";

export default {
  data() {
    return {
      model: model,
      data: { album_id: "" },
      albums: [],
    };
  },
  provide() {
    return {
      validate: this.validation,
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
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
    getAlbum() {
      axios.get("/get-album/Videos").then((res) => (this.albums = res.data));
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(this.model, this.$route.params.id, "data"); // get data for edit
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Website-Gallery-Video");
    }
    this.getAlbum();
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.album_id": function (value = null) {
      return Validator.value(value).required("Album is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.url": function (value = null) {
      return Validator.value(value).required("URL is required");
    },
  },
};
</script>