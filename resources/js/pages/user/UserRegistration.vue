<template>
  <div>
    <form>
      <input type="name" name="name" id="name" v-model="user.name"/>
      <input type="email" name="email" id="email" v-model="user.email"/>
      <input type="password" name="password" id="password" v-model="user.password"/>
      <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        v-model="user.password_confirmation"
      />
    </form>
    <button v-on:click="createUser()">Make user</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: "Alex celmer",
        email: "asesaeas@dsdas.com",
        password: "12345678",
        password_confirmation: "12345678",
      },
    };
  },

  methods: {
    createUser: function () {
      let vm = this;
      axios.post("/register", vm.user).then((resp) => {
        console.log(resp);
      });
    },
  },
};
</script>

<style>
</style>