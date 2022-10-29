<template>
  <div v-if="!$root.spinner" class="content-part">
    <div class="global-form">
      <div class="global-form-header">
        <div class="row">
          <!-- search form -->
          <div class="col-lg-10">
            <slot name="header"></slot>
          </div>
          <!-- search form -->

          <!-- add or back button -->
          <slot name="button">
            <AddOrBackButton
              v-if="button"
              :route="$parent.model + '.index'"
              :portion="$parent.model"
              :icon="'fas fa-backward'"
            />
          </slot>
          <!-- add or back button -->
        </div>
      </div>

      <div class="form-input-details">
        <ViewBaseTable v-if="defaultTable" :data="$parent.data" />

        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    button: {
      type: Boolean,
      default: true,
    },
    defaultTable: {
      type: Boolean,
      default: true,
    },
    header: {
      type: String,
      default: "",
    },
  },
};
</script>