<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "slider";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title" },
  {
    field: "slider",
    title: "Slider",
    image: true,
    imgWidth: "200px",
    height: "60px",
    align: "center",
  },
  {
    field: "sorting",
    title: "Sorting",
    sorting: true,
    namespace: "Website-Gallery-Slider",
    auto: true,
    align: "center",
  },
];
//json fields for export excel
const json_fields = {
  Title: "title",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", name: "Name" },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: [],
      },
    };
  },

  // provide inject for child component
  provide() {
    return {
      model: this.model,
      fields_name: this.fields_name,
      search_data: this.search_data,
      table: this.table,
    };
  },

  methods: {
    search() {
      this.get_paginate(this.model, this.search_data);
    },
  },

  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
  },
};
</script>