<template>
  <view-page></view-page>
</template>

<script>
// define model name
const model = "video";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  created() {
    this.setBreadcrumbs(this.model, "view");
    this.get_data(`${this.model}/${this.$route.params.id}`);
  },
};
</script>