<template>
  <div :class="getClass()" class="mb-3">
    <label class="form-label">
      <slot name="title"> {{ title }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>
    <div class="input-group position-relative">
      <div class="col-2">
        <img
          style="height: 35px"
          class="img-responsive rounded-circle choose-file-size"
          :src="showImage()"
          alt="picture"
        />
      </div>
      <div class="col-10">
        <input
          :name="fieldName"
          type="file"
          :accept="mime"
          class="form-control form-control-sm"
          v-on:change="onFileChange(fieldName, fileClassName)"
          :id="fileClassName"
        />
      </div>
    </div>
    <span
      v-if="validate.hasError(this.field) && this.field"
      class="input-message danger"
    >
      {{ validate.firstError(this.field) }}
    </span>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [String, Number],
    },
    title: {
      type: String,
    },
    field: {
      type: String,
    },
    type: {
      type: String,
      default: "text",
    },
    mime: {
      type: String,
      default: "image/*",
    },
    col: {
      type: String,
    },
    req: {
      type: Boolean,
      default: false,
    },
    fileClassName: {
      type: String,
    },
    crop: {
      type: Boolean,
      default: false,
    },
  },

  inject: ["validate", "data", "image"],

  computed: {
    fieldName() {
      return this.field.split(".").pop();
    },
  },

  methods: {
    getClass() {
      let col = this.col ? this.col : 3;
      let className = "col-lg-" + col + " ";
      return className;
    },
    getIcon() {
      let errorStatus = this.validate.hasError(this.field);
      if (errorStatus && this.req) {
        return "far fa-times-circle danger-icon";
      } else if (this.modelValue) {
        return "bi bi-check-lg success-icon";
      }
    },
    errorClass() {
      let className = "form-control shadow-none ";
      if (this.req) {
        if (this.validate.hasError(this.field)) {
          className += "danger";
        } else if (this.modelValue) {
          className += "success";
        }
      }
      return className;
    },

    onFileChange(field, fileClass) {
      let pdf = this.mime == ".pdf" ? "pdf" : null;
      let file = document.getElementById(fileClass).files[0];
      this.showImageGlobal(file, field, pdf);
    },

    showImage() {
      if (this.image[this.fieldName]) {
        return this.image[this.fieldName];
      } else if (this.data()[this.fieldName]) {
        return this.data()[this.fieldName];
      }
      return this.noimage;
    },
  },
};
</script>