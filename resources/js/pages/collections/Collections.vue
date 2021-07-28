<template>
  <div>
    <v-subheader class="my-5">
      <v-text-field
        v-model="search"
        :placeholder="'Search collection (' + collections.length + ')'"
        class="mt-0 pt-0"
        hide-details
        single-line
        type="search"
      ></v-text-field>
    </v-subheader>
    <v-spacer></v-spacer>
    <v-row dense v-if="collections.length">
      <v-col
        :cols="4"
        v-for="collection in collections"
        v-bind:key="collection.id"
      >
        <v-card elevation="4" outlined style="width: 95%" class="mb-5"
          ><v-img
            height="250"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
          ></v-img>
          <v-card-title>{{ collection.label }}</v-card-title>
          <v-card-actions>
            <v-btn
              color="deep-purple lighten-2"
              text
              :to="{
                name: 'app.collections.edit',
                params: {
                  slug: $route.params.slug,
                  collection: collection.name,
                },
              }"
            >
              Edit
            </v-btn>
            <v-btn
              color="deep-purple lighten-2"
              text
              :to="{
                name: 'app.collections.entries',
                params: {
                  slug: $route.params.slug,
                  collection: collection.name,
                },
              }"
            >
              Entries
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col>
        <h2>No Collections founded</h2>
      </v-col>
    </v-row>

    <v-speed-dial :bottom="true" :right="true" absolute>
      <template v-slot:activator>
        <router-link :to="{ name: 'app.collections.edit', params:{ slug: $route.params.slug, collection: 'create' } }">
          <v-btn color="blue darken-2" dark fab>
            <v-icon> mdi-plus </v-icon>
          </v-btn>
        </router-link>
      </template>
    </v-speed-dial>
  </div>
</template>

<script>
import HELPER from "../../helper";

export default {
  data() {
    return {
      collectionss: [],
      search: "",
    };
  },

  computed: {
    collections() {
      return HELPER.getFiltered(this.search, this.collectionss);
    },
  },

  created() {
    let vm = this;
    axios
      .get("/api/apps/" + vm.$route.params.slug + "/collections")
      .then((resp) => {
        vm.collectionss = resp.data;
      });
  },
};
</script>

<style>
</style>