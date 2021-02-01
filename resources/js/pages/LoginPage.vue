<template>
  <section>
    <form>
      <input type="email" name="email" v-model="email" />
      <input type="password" name="password" v-model="password" />
      <input
        type="password"
        name="password_confirmation"
        v-model="password_confirmation"
      />
    </form>
    <button v-on:click="doLogin()">Login</button>
    <p>{{ token }}</p>
  </section>
</template>

<script>
export default {
  data() {
    return {
      email: "alex.celmer@hotmail.com",
      password: "12345678",
      password_confirmation: "12345678",
      token: "",
    };
  },
  created() {},

  methods: {
    doLogin: function () {
      let vm = this;
      let user = {
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };
      this.$store.dispatch("login", user).then((resp) => {
        this.$store.dispatch("user").then((resp) =>{
          vm.$router.push({name: "apps.list"})
        });
      });
    },
  },
};
</script>

<style>
</style>