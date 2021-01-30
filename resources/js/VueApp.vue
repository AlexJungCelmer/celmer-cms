<template>
  <div>
    <p>
      <router-link :to="{ name: 'login' }" style="color: black"
        >Login</router-link
      >
    </p>
    <p>
      <router-link :to="{ name: 'app.list' }" style="color: black"
        >list apps</router-link
      >
    </p>

    <p>
      <router-link :to="{ name: 'user.new' }" style="color: black"
        >new user</router-link
      >
    </p>
    <p>
      <router-link :to="{ name: 'user.list' }" style="color: black"
        >User list</router-link
      >
    </p>
    <p>
      <router-link :to="{ name: 'user.profile' }" style="color: black"
        >Profile</router-link
      >
    </p>

    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  created() {
    if (axios.defaults.headers.common["Authorization"]) {
      axios.get("/api/user").then((resp) => {
        console.log(resp.data);
      });
    }
  },
};
</script>

<style>
</style>