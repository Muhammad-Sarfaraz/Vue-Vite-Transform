<template>
  <div>
    <!-- ================Excel , PDF, Print Button================ -->
    <div class="global-form-filter">
      <div class="row">
        <div class="col-lg-8">
          <div class="filter-option">
            <div class="row">
              <div class="col-lg-2">
                <div class="mb-3">
                  <select
                    v-model="search_data.pagination"
                    class="form-select form-select-sm shadow-none"
                  >
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                    <option>200</option>
                    <option>500</option>
                    <option value="999999999999999999999">All</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 align-self-center">
          <div class="print-option text-end">
            <ul>
              <li>
                <a
                  title="Print"
                  href="javascript:void(0)"
                  class="printer"
                  @click="print('printArea', model)"
                >
                  <i class="bi bi-printer-fill"></i>
                </a>
              </li>
              <li>
                <a
                  title="Download PDF"
                  href="javascript:void(0)"
                  class="pdf"
                  @click="generatePdf"
                >
                  <i class="bi bi-filetype-pdf"></i>
                </a>
              </li>
              <li>
                <a class="excel" href=""><i class="fas fa-file-excel"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- ================Excel , PDF, Print Button================ -->

    <div class="global-form-body">
      <div class="common-table-main">
        <div class="common-table-body table-responsive" id="printArea">
          <table id="pdf-table" class="table">
            <thead>
              <tr>
                <th class="sl text-center">#</th>
                <slot name="columns">
                  <th
                    v-for="(column, index) in table.columns"
                    :key="'a' + index"
                    @click="sort(column.field)"
                    class="sort-th"
                    :style="
                      'text-align:' + column.align + '; width:' + column.width
                    "
                  >
                    {{ column.title }}
                    <slot v-if="!column.subfield">
                      <span v-if="coloumSort == column.field">
                        <i
                          style="color: #673ab7"
                          v-if="order == 'desc'"
                          class="fa fa-sort-up pull-right sort"
                        ></i>
                        <i
                          style="color: #673ab7"
                          v-if="order == 'asc'"
                          class="fa fa-sort-down pull-right sort"
                        ></i>
                      </span>
                      <i v-else class="fa fa-sort pull-right sort"></i>
                    </slot>
                  </th>

                  <th
                    width="10%"
                    v-if="
                      Object.keys(table.routes).length > 0 &&
                      ($root.checkPermission(table.routes.view) ||
                        $root.checkPermission(table.routes.edit) ||
                        $root.checkPermission(table.routes.destroy))
                    "
                    :class="table.routes.array ? 'action-extra' : 'action'"
                    class="text-center"
                  >
                    Action
                  </th>
                </slot>
              </tr>
            </thead>
            <slot v-if="!$root.tableSpinner">
              <tbody v-if="Object.keys(table.datas).length > 0">
                <tr
                  v-for="(item, index) in table.datas"
                  :key="index"
                  class="change_sorting"
                  :class="
                    'change_sorting' + item.sorting + ' update_item' + item.id
                  "
                >
                  <td class="text-center" v-if="table.meta">
                    {{ table.meta.from + index }}
                  </td>
                  <td v-else class="text-center">{{ index + 1 }}</td>
                  <slot
                    v-for="(column, index) in table.columns"
                    :name="column.field"
                    :item="item"
                  >
                    <td
                      class="position-relative"
                      :key="'b' + index"
                      :style="'text-align:' + column.align"
                      :v-if="hasValue(item, column.field)"
                    >
                      <span v-if="column.date">
                        {{ $filter.enFormat(itemValue(item, column.field)) }}
                      </span>
                      <span v-else-if="column.array">
                        {{
                          column.array_value[0][
                            itemValue(item, column.field, column.subfield)
                          ]
                        }}
                      </span>
                      <slot v-else-if="column.sorting">
                        <input
                          v-if="!sorting_spin"
                          v-on:keyup.enter="
                            tableSorting(
                              $event.target.value,
                              item.id,
                              column.namespace,
                              column.auto
                            )
                          "
                          :value="item[column.field]"
                          type="number"
                          class="base-table-form-control text-center"
                          style="width: 50px; font-size: 12px"
                          :id="item.id"
                        />

                        <i
                          v-if="item.id == sorting_spin"
                          class="fa fa-spinner fa-spin mt-2 ml-2 text-primary"
                        ></i>
                        <label
                          v-else
                          :for="item.id"
                          class="change-sorting"
                          title="Click to change sorting"
                        >
                          <i class="fa fa-pencil"></i>
                        </label>
                      </slot>
                      <img
                        v-else-if="
                          column.image && itemValue(item, column.field)
                        "
                        :src="itemValue(item, column.field)"
                        :style="
                          'width:' +
                          column.imgWidth +
                          ';height:' +
                          column.height
                        "
                      />
                      <span v-else-if="column.field == 'status'">
                        <span
                          class="released pending"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                              'active' ||
                            itemValue(item, column.field, column.subfield) == 1
                          "
                          >ACTIVE</span
                        >
                        <span
                          class="released"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                              'deactive' ||
                            itemValue(item, column.field, column.subfield) == 0
                          "
                          >DEACTIVE</span
                        >
                        <span
                          class="released"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'ur'
                          "
                          >UNREAD</span
                        >
                        <span
                          class="released pending"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'r'
                          "
                          >READ</span
                        >
                        <span
                          class="released"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'pending'
                          "
                          >PENDING</span
                        >
                        <span
                          class="released pending"
                          v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'success'
                          "
                          >SUCCESS</span
                        >
                      </span>
                      <span v-else>
                        {{ itemValue(item, column.field, column.subfield) }}
                      </span>
                    </td>
                  </slot>
                  <td
                    v-if="
                      Object.keys(table.routes).length > 0 &&
                      ($root.checkPermission(table.routes.view) ||
                        $root.checkPermission(table.routes.edit) ||
                        $root.checkPermission(table.routes.destroy))
                    "
                    :class="table.routes.array ? 'action-extra' : 'action'"
                    class="text-center"
                  >
                    <router-link
                      v-if="
                        table.routes.view &&
                        $root.checkPermission(table.routes.view)
                      "
                      :to="{
                        name: table.routes.view,
                        params: { id: item.slug ? item.slug : item.id },
                        query: { page: $route.query.page },
                      }"
                      class="delete view"
                      title="View"
                    >
                      <i class="fas fa-binoculars"></i>
                    </router-link>

                    <router-link
                      v-if="
                        table.routes.edit &&
                        $root.checkPermission(table.routes.edit)
                      "
                      :to="{
                        name: table.routes.edit,
                        params: { id: item.slug ? item.slug : item.id },
                        query: { page: $route.query.page },
                      }"
                      class="delete edit"
                      title="Edit"
                    >
                      <i class="fas fa-pencil-alt"> </i>
                    </router-link>

                    <button
                      v-if="
                        table.routes.destroy &&
                        $root.checkPermission(table.routes.destroy)
                      "
                      v-on:click="destroy(item.slug ? item.slug : item.id)"
                      class="delete delete-btn"
                      title="Delete"
                    >
                      <i class="far fa-trash-alt"></i>
                    </button>

                    <!-- custom route -->
                    <slot v-if="table.routes.array">
                      <slot v-for="(rt, index) in table.routes.array">
                        <router-link
                          :key="index"
                          v-if="rt.route && $root.checkPermission(rt.route)"
                          :to="{
                            name: rt.route,
                            params: { id: item.slug ? item.slug : item.id },
                          }"
                          :class="'btn btn-xs btn-' + rt.btnColor"
                          class="delete edit"
                        >
                          <i :class="'fa fa-' + rt.icon"></i>
                        </router-link>
                      </slot>
                    </slot>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td
                    :colspan="Object.keys(table.columns).length + 2"
                    style="text-align: center; background: #fff"
                  >
                    <p class="p-2 text-center text-red no-data">
                      No data found.
                    </p>
                  </td>
                </tr>
              </tbody>
            </slot>
          </table>
          <div
            v-if="$root.tableSpinner"
            class="text-center"
            style="font-size: 17px; color: #adadad"
          >
            <span class="fa fa-circle-o-notch fa-spin"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="deleteModal"
      tabindex="-1"
      aria-labelledby="deleteModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-black" id="deleteModalLabel">
              Are you sure want to delete this?
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <h6 class="mb-3 text-black">Please confirm your login password</h6>
            <div class="d-flex justify-content-center">
              <input
                v-model="delete_password"
                type="password"
                placeholder="********"
                class="form-control form-control-sm text-center border"
                style="width: 350px"
              />
            </div>
            <div class="d-flex justify-content-center">
              <button
                @click="deleteConfirm()"
                type="button"
                class="btn btn-success btn-sm text-white my-3"
              >
                <span v-if="$root.submit">
                  <i class="fa fa-spinner fa-spin"></i>
                  processing...
                </span>
                <span v-else> Confirm </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseTable",

  data() {
    return {
      order: "desc",
      coloumSort: "",
      sorting_spin: false,
      deleted_id: null,
      delete_password: null,
    };
  },

  inject: ["table", "search_data", "model"],

  methods: {
    hasValue(item, column) {
      return item[column.toLowerCase()] !== "undefined";
    },
    itemValue(item, column, child = "") {
      var value = item[column.toLowerCase()];

      if (child) {
        let obj = item;
        value = String(child)
          .split(".")
          .reduce((p, c) => p[c], obj);
      }
      return value;
    },
    destroy(id) {
      this.deleted_id = id;
      $("#deleteModal").modal("show");
    },
    deleteConfirm() {
      if (!this.delete_password) {
        this.$toast("Password field is required", "error");
        return false;
      }
      let data = {
        for_delete: true,
        id: this.user.id,
        old_password: this.delete_password,
      };
      this.$root.submit = true;
      axios
        .post("/check-old-password", data)
        .then((res) => {
          if (res.data) {
            this.destroy_data(this.model, this.deleted_id, this.search_data);
            this.deleted_id = "";
            this.delete_password = "";

            $("#deleteModal").modal("hide");
          } else {
            this.$toast("Password does not match", "error");
            return false;
          }
        })
        .finally((res) => (this.$root.submit = false));
    },
    tableSorting(number, id, model, auto) {
      $(".change_sorting").removeClass("sorting-success");
      this.sorting_spin = id;
      let data = { number: number, id: id, model: model, auto: auto };
      axios
        .get("table-sorting", { params: data })
        .then((res) => {
          this.get_paginate(this.model, this.search_data);
        })
        .catch((error) => console.log(error))
        .then((alw) => {
          this.sorting_spin = "";
          $(".change_sorting" + number).addClass("sorting-success");
        });

      setTimeout(
        () => $(".change_sorting").removeClass("sorting-success"),
        5000
      );
    },
    sort(field) {
      this.coloumSort = field;
      this.table.datas.sort(this.sortBy(field));
    },
    sortBy(property) {
      if (this.order === "desc") {
        this.order = "asc";
      } else {
        this.order = "desc";
      }
      const order = this.order;
      return function (a, b) {
        const varA =
          typeof a[property] === "string"
            ? a[property].toUpperCase()
            : a[property];
        const varB =
          typeof b[property] === "string"
            ? b[property].toUpperCase()
            : b[property];

        let comparison = 0;
        if (varA > varB) comparison = 1;
        else if (varA < varB) comparison = -1;
        return order === "desc" ? comparison * -1 : comparison;
      };
    },
    generatePdf() {
      const doc = new jsPDF();
      $(".action").css("display", "none");
      autoTable(doc, { html: "#pdf-table" });
      doc.save(this.model + ".pdf");
      setTimeout(() => $(".action").show(), 300);
    },
  },
};
</script>
