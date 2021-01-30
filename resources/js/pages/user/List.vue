<template>
  <div></div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
    };
  },

  created() {
    let vm = this;
    axios.get("/api/users/").then((resp) => {
      vm.users = resp.data;
    });
  },
};
</script>

<style>
</style>