<template>
  <v-container fill-height fluid>
    <v-row align="center" justify="center">
      <v-col sm="6" md="4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
            type="email"
          ></v-text-field>

          <v-text-field
            v-model="password"
            label="Password"
            required
            type="password"
          ></v-text-field>

          <v-text-field
            v-model="password_confirmation"
            label="Password confirm"
            required
            type="password"
          ></v-text-field>

          <v-btn color="success" class="mr-4 mb-4" @click="doLogin"
            >Login</v-btn
          >
          <v-btn color="error" class="mr-4 mb-4" @click="reset">
            Reset Form
          </v-btn>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      email: "alex.celmer@hotmail.com",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      password: "12345678",
      password_confirmation: "12345678",
      token: "",
    };
  },
  created() {},

  methods: {
    validate: function () {
      this.$refs.form.validate();
    },
    reset: function () {
      this.$refs.form.reset();
    },
    doLogin: function () {
      if (this.$refs.form.validate()) {
        let vm = this;
        let user = {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        };
        this.$store.dispatch("login", user).then( async (login) => {
          await this.$store.dispatch("user").then((resp) => {
            console.log("a");
            vm.$router.push({ name: "app.list" });
          });
        });
      }
    },
  },
};
</script>

<style>
</style>