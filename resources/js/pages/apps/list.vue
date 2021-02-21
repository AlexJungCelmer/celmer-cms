<template>
  <div>
    <v-subheader class="my-5">
      <v-text-field
        v-model="search"
        :placeholder="'Search application (' + apps.length + ')'"
        class="mt-0 pt-0"
        hide-details
        single-line
        type="search"
      ></v-text-field>
    </v-subheader>
    <v-spacer></v-spacer>
    <v-row dense v-if="apps.length">
      <v-col :cols="appsPerCol" v-for="app in apps" v-bind:key="app.id">
        <v-card elevation="4" outlined style="width: 95%" class="mb-5"
          ><v-img
            height="250"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
          ></v-img>
          <v-card-title>{{ app.name }}</v-card-title>
          <v-card-actions>
            <v-btn
              v-if="isUserInScope('application')"
              color="deep-purple lighten-2"
              text
              :to="{ name: 'app.edit', params: { slug: app.slug } }"
            >
              Edit
            </v-btn>
            <v-btn
              v-if="isUserInScope('collection:view')"
              color="deep-purple lighten-2"
              text
              :to="{ name: 'app.collections', params: { slug: app.slug } }"
            >
              Collections
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col>
        <h2>No applications founded</h2>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      search: "",
      appsPerCol: 3,
    };
  },

  created() {
    console.log('created', this, this.user_scopes);
  },

  computed: {
    apps() {
      console.log(this.$store.getters.applications.length);
      if (this.$store.getters.applications.length >= 1) {
        const search = this.search.toLowerCase().trim();
        if (!search) return this.$store.getters.applications;
        return this.$store.getters.applications.filter(
          (c) => c.name.toLowerCase().indexOf(search) > -1
        );
      } else {
        return this.$store.dispatch("getApplications");
      }
    },
  },
};
</script>

<style>
</style>