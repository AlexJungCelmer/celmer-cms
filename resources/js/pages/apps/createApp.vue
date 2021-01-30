<template>
  <div>
    <form>
      <input type="text" name="name" v-model="app.name" />
    </form>
    <button v-on:click="createApp()">send</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      app: {
        name: "",
      },
      resp: {},
    };
  },

  created() {
    let vm = this;
    console.log(vm);
    if (vm.$route.params.slug != "") {
      axios.get("/api/apps/" + vm.$route.params.slug).then((resp) => {
        vm.app = resp.data;
        console.log(resp);
      });
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