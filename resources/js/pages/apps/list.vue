<template>
  <ul>
    <li v-for="app in apps" v-bind:key="app.id">
      <router-link :to="{name: 'app.edit', params: {slug: app.slug}}">{{ app.name }}</router-link>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      apps: [],
    };
  },

  created() {
    let vm = this;
    axios.get("/api/apps").then((resp) => {
      console.log(resp);
      vm.apps = resp.data;
    });
  },
};
</script>

<style>
</style>