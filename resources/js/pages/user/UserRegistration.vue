<template>
  <div>
    <v-fab-transition>
      <v-btn
        v-if="$store.state.user.user.is_admin && $route.name != 'user.new'"
        color="blue"
        fab
        dark
        fixed
        bottom
        right
        @click="reset"
        :to="{ name: 'user.new' }"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-fab-transition>
    <v-row align="center" justify="center">
      <v-col>
        <v-form ref="form" lazy-validation>
          <v-text-field
            v-model="user.name"
            label="User name"
            required
            type="text"
          ></v-text-field>

          <v-text-field
            v-model="user.email"
            :rules="emailRules"
            label="E-mail"
            required
            type="email"
          ></v-text-field>

          <v-text-field
            v-model="user.password"
            label="Password"
            required
            type="password"
            v-if="!$route.params.slug"
          ></v-text-field>

          <v-text-field
            v-model="user.password_confirmation"
            label="Password confirm"
            required
            type="password"
            v-if="!$route.params.slug"
          ></v-text-field>

          <div
            v-if="$route.params.slug != '' && applications.length"
            class="list-applications"
          >
            <h3>Applications</h3>
            <v-row align="center">
              <v-col sm="2" v-for="app in applications" v-bind:key="app.id">
                <v-checkbox
                  v-model="user.selecteds"
                  :label="app.name"
                  :value="app.id"
                ></v-checkbox>
              </v-col>
            </v-row>
          </div>
        </v-form>
        <v-btn color="success" class="mr-4 mb-4" v-on:click="createUser()">{{
          $route.params.slug ? "Update" : "Create"
        }}</v-btn>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      applications: [],
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
    };
  },

  created() {
    let vm = this;
    axios.get("/api/apps").then((resp) => {
      vm.applications = resp.data;
    });
    if (this.$route.params.slug) {
      axios.get("/api/users/" + this.$route.params.slug).then((resp) => {
        vm.user = resp.data;
        vm.user.selecteds = [];
        vm.user.app.forEach((app) => {
          vm.user.selecteds.push(app.id);
        });
      });
    }
  },

  methods: {
    reset: function () {
      this.$refs.form.reset();
    },
    createUser: function () {
      let vm = this;
      axios.post("/register", vm.user).then((resp) => {
        console.log(resp);
      });
    },
  },
};
</script>

<style scoped lang="scss">
div.list-applications {
  margin: 25px 0;
}
</style>