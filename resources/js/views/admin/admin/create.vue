<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input v-model="data.name" field="data.name" title="Name" :req="true" />
      <!------------ Single Input ------------>
      <Input
        v-if="!$route.params.id"
        v-model="data.email"
        field="data.email"
        title="Email"
        :req="true"
      />
      <!------------ Single Input ------------>
      <Input
        v-if="!$route.params.id"
        v-model="data.password"
        field="data.password"
        title="Password"
        type="password"
        :req="true"
      />
      <!------------ Single Input ------------>
      <v-select-container title="Role">
        <v-select
          v-model="data.role_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="extraData.roles"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        v-model="data.mobile"
        field="data.mobile"
        title="Mobile"
        :req="true"
      />
      <!------------ Single Input ------------>
      <Radio
        v-model="data.status"
        field="data.status"
        title="Status"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'deactive', title: 'Deactive' },
        ]"
        :req="true"
        col="2"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "admin";

export default {
  data() {
    return {
      model: model,
      data: {
        role_id: null,
        status: "active",
      },
      extraData: {
        roles: [],
      },
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
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
    }
    this.get_paginate("role", { allData: true }, "roles"); // get roles
  },

  // validation rule for form
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.email": function (value = null) {
      if (!this.$route.params.id) {
        return Validator.value(value).required("Email is required").email();
      }
    },
    "data.role_id": function (value = null) {
      return Validator.value(value).required("Role is required");
    },
    "data.password": function (value = null) {
      if (!this.$route.params.id) {
        return Validator.value(value)
          .required("Password is required")
          .minLength(6);
      }
    },
    "data.mobile": function (value = null) {
      return Validator.value(value)
        .digit()
        .regex("01+[0-9+-]*$", "Must start with 01.")
        .minLength(11)
        .maxLength(11);
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>