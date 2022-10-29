<template>
  <div class="row col-5 pl-1">
    <div class="col-lg-5">
      <select
        v-model="search_data.field_name"
        class="form-select form-select-sm shadow-none"
      >
        <option
          v-for="(value, name, index) in fields_name"
          :key="index"
          v-bind:value="name"
        >
          {{ value }}
        </option>
      </select>
    </div>
    <div class="col-lg-6">
      <input
        type="text"
        v-model="search_data.value"
        class="form-control form-control-sm shadow-none"
        placeholder="Type your text"
      />
    </div>
    <div class="col-lg-1">
      <button class="global-form-btn">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  // props: {
  //   fields_name: [Array, Object],
  //   search_data: [Array, Object],
  // },

  inject: ["search_data", "fields_name"],
};
</script>
