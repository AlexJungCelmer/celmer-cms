<template>
  <div>
    <p>
      <router-link :class="($route.name == 'login' ? 'active' : '' )" :to="{ name: 'login' }">Login</router-link>
    </p>
    <p>
      <router-link :class="($route.name == 'app.list' ? 'active' : '' )" :to="{ name: 'app.list' }">list apps</router-link>
    </p>

    <p>
      <router-link :class="($route.name == 'user.new' ? 'active' : '' )" :to="{ name: 'user.new' }">new user</router-link>
    </p>
    <p>
      <router-link :class="($route.name == 'user.list' ? 'active' : '' )" :to="{ name: 'user.list' }">User list</router-link>
    </p>
    <p>
      <router-link :class="($route.name == 'user.profile' ? 'active' : '' )" :to="{ name: 'user.profile' }">Profile</router-link>
    </p>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
a {
  color: black;
}
a:active{
  color: blue;
}
</style>