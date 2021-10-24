<template>
  <q-page class="flex flex-center full-width">
    <div id="form-wrapper" class="full-width">
      <q-form @submit="onSubmit" class="q-gutter-md">
        <q-input
          outlined
          v-model="email"
          label="e-mail"
          hint="E-mail"
          lazy-rules
          :rules="[ val => val && val.length > 0 || 'Please type something']"
        />

        <q-input
          outlined
          type="password"
          v-model="password"
          label="********"
          lazy-rules
          :rules="[ val => val !== null && val !== '' || 'Please type your password']"
        />

        <div class="flex flex-center">
          <q-btn label="Submit" type="submit" color="primary" />
        </div>
      </q-form>
    </div>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'
import { user as userService } from '../services'

export default defineComponent({
  name: 'PageIndex',

  data () {
    return {
      email: 'alex@example.com',
      password: '12345678'
    }
  },

  methods: {
    onSubmit: function () {
      this.$store.dispatch('user/login', { email: this.email, password: this.password }).then(() => {
        console.log(userService)
        userService.get().then(resp => {
          console.log(resp)
        })
      })
    }
  }
})
</script>

<style lang="scss" scoped>
div#form-wrapper{
  max-width: 350px;
}
</style>
