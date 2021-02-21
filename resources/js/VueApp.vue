<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      app
      v-if="$store.getters.isAuthenticated"
    >
      <v-sheet color="grey lighten-4" class="pa-4">
        <v-avatar class="mb-4" color="blue darken-1" size="64">
          <span class="white--text headline">{{
            (
              $store.state.user.user.name[0] +
              $store.state.user.user.name.split(" ")[1][0]
            ).toUpperCase()
          }}</span>
        </v-avatar>

        <div>
          Hello
          <span style="text-transform: capitalize; font-weight: bold">{{
            $store.state.user.user.name.split(" ")[0]
          }}</span>
          what's up?
        </div>
      </v-sheet>

      <v-divider></v-divider>

      <v-list>
        <v-list-item
          v-for="[icon, text, route, rule] in links"
          :key="icon"
          link
          :to="{ name: route }"
        >
          <v-list-item-icon v-if="rule">
            <v-icon>{{ icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content v-if="rule">
            <v-list-item-title>{{ text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Sizes your content based upon application components -->
    <v-main>
      <!-- Provides the application the proper gutter -->
      <v-container fluid fill-height v-if="$route.name == 'login'">
        <router-view :key="$route.fullPath"></router-view>
      </v-container>
      <v-container fluid else>
        <router-view :key="$route.fullPath"></router-view>
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    cards: ["Today", "Yesterday"],
    drawer: null,
    links: [
      ["mdi-apps", "Applications", "app.list", () => {return true}],
      ["mdi-account-circle","Users","user.list",() => {return this.$store.state.user.user.is_admin;}],
    ],
  }),
  created() {
    let vm = this;
    axios.interceptors.response.use(
      (response) => {
        return response;
      },
      (error) => {
        if (error.response.status === 401) {
          this.$root.$bvToast.toast("You have no permission to access this", {
            title: "Permission denied",
            variant: "warning",
            solid: true,
          });
        }
        vm.$router.push({ name: "login" });
        return error;
      }
    );

    if (this.$store.getters.isAuthenticated == false) {
      if (this.$route.name != "login") {
        this.$router.push({ name: "login" });
      }
    }
    if (this.$store.getters.isAuthenticated) {
      this.$store.dispatch("user").then((resp) => {});
      this.$store.dispatch("getApplications").then((resp) => {});
    }
  },
};
</script>

<style lang="scss">
// @import "node_modules/bootstrap/scss/bootstrap.scss";
// @import "node_modules/bootstrap-vue/src/index.scss";

@import "vuetify/dist/vuetify.min.css";

main {
  height: 100%;
  width: 100%;
}
#app {
  min-height: 100vh;

  div#general-app-wrapper {
    min-height: 100vh;
  }
}
</style>