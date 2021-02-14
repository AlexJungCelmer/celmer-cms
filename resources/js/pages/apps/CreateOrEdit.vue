<template>
  <div>
    <div v-if="$store.state.user.user.is_admin">
      <form>
        <v-text-field
          label="Application name"
          required
          type="text"
          name="name"
          v-model="app.name"
        ></v-text-field>
      </form>
      <button v-on:click="createApp()">send</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      app: {
        name: "",
      },
    };
  },

  created() {
    let vm = this;

    if (vm.$route.params.slug != "") {
      axios.get("/api/apps/" + vm.$route.params.slug).then((resp) => {
        vm.app = resp.data;
      });
    }else{
      vm.$route.push({name: "app.list"})
    }
  },

  methods: {
    createApp: function () {
      let vm = this;
      axios.post("/api/apps/new", { name: vm.app.name }).then((resp) => {
        console.log(resp);
      });
    },
  },
};
</script>

<style>
</style>