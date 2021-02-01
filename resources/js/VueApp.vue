<template>
  <div>
    <nav-bar v-if="$store.getters.isAuthenticated"></nav-bar>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
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
    } else {
      if (this.$route.name != "app.list") {
        this.$router.push({ name: "app.list" });
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
@import "node_modules/bootstrap/scss/bootstrap.scss";
@import "node_modules/bootstrap-vue/src/index.scss";
</style>