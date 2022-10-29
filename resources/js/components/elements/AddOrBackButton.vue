<template>
  <div class="col-lg-2 align-self-top">
    <div class="global-add-item-btn text-end">
      <ul>
        <li>
          <router-link
            v-if="$root.checkPermission(route)"
            :to="{
              name: route,
              query: { page: icon != 'plus' ? $route.query.page : '' },
            }"
            :title="icon == 'plus' ? 'Add New' : 'Back to list'"
          >
            <i :class="'fa fa-' + icon"></i>

            <span v-if="icon == 'plus'" class="text-capitalize">
              <b>Add {{ $filter.capitalize(title ? title : portion) }}</b>
            </span>
            <span v-else><b>Back</b></span>
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: ["route", "icon", "portion", "title", "extraButtons"],
};
</script>
