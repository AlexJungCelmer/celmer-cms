<template>
  <div>
    <p>{{ user.name }}</p>
    <p>{{ user.email }}</p>
    <form action="">
      <input type="name" name="name" v-model="user.name" />
      <input type="email" name="email" v-model="user.email" />
      <input type="password" name="password" v-model="user.password" />
    </form>
    <div v-if="user.is_admin == 1">
      <h2>All Apps</h2>
      <ul>
        <li v-for="app in user.admin_apps" v-bind:key="app.id">
          <router-link :to="{ name: 'app.edit', params: { slug: app.slug } }">{{
            app.name
          }}</router-link>
        </li>
      </ul>
    </div>
    <div v-else>
      <h2>My Apps</h2>
      <ul>
        <li v-for="app in user.admin_apps" v-bind:key="app.id">
          <input
            type="checkbox"
            :name="app.slug"
            :id="app.slug"
            v-model="user_apps"
            :value="app.slug"
          />{{ app.name }}
        </li>
      </ul>
    </div>
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
        user_apps: [],
      },
    };
  },

  created() {
    let vm = this;
    axios.get("/api/user").then((resp) => {
      vm.user = resp.data;
    });
  },
};
</script>

<style>
</style>