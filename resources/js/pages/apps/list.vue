<template>
  <ul>
    <li
      v-for="app in apps"
      v-bind:key="app.id"
      v-bind:click="$store.commit('setCurrent', app)"
    >
      <p>{{ app.name }}</p>
      <p>
        <router-link :to="{ name: 'app.edit', params: { slug: app.slug } }">
          Edit
        </router-link>
      </p>
      <p>
        <router-link
          :to="{ name: 'app.collections', params: { slug: app.slug } }"
        >
          Collections
        </router-link>
      </p>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      // apps: [],
    };
  },

  computed: {
    apps() {
      console.log( this.$store.getters.applications.length );
      if( this.$store.getters.applications.length >= 1 ){
        return this.$store.getters.applications
      }else{
        return this.$store.dispatch('getApplications');
      }
    },
  },
};
</script>

<style>
</style>