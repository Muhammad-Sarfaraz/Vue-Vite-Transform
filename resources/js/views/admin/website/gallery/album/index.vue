<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "album";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "name", title: "Name" },
  { field: "type", title: "Type", align: "center" },
  {
    field: "image",
    title: "Image",
    image: true,
    imgWidth: "50px",
    height: "50px",
    align: "center",
  },
  {
    field: "sorting",
    title: "Sorting",
    sorting: true,
    namespace: "Website-FrontMenu",
    auto: "",
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