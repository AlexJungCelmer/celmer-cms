<template>
  <p>Aqui</p>
</template>

<script>
export default {
  created() {
    axios.get("/api/apps/" + vm.$route.params.slug + "/collections").then((resp) => {
      vm.app = resp.data;
    });
  },
};
</script>

<style>
</style>