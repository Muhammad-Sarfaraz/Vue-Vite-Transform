<template>
  <div :class="getClass()" class="mb-3">
    <label v-if="title" class="form-label">
      <slot name="title"> {{ title }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>

    <slot></slot>

    <div v-if="req" class="validation-icon position-absolute">
      <i :class="getIcon()" aria-hidden="true"></i>
    </div>
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
    col: {
      type: [String, Number],
    },
    req: {
      type: Boolean,
      default: false,
    },
  },

  inject: ["validate"],

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
  },
};
</script>

<style>
.vs__dropdown-menu li {
  color: #555;
}
.vs__search:focus {
  color: #555 !important;
}
.vs__dropdown-option--highlight {
  color: #fff !important;
}
</style>