<template>
  <div>
    <v-data-table
      :loading="loading"
      loading-text="Carregando dados"
      :headers="headers"
      :items="entries"
      class="elevation-1"
      v-model="selected"
      show-select
    >
      <template v-slot:item.actions="{ item }">
        <router-link
          :to="{
            name: 'app.collections.entries.edit',
            params: {
              slug: $route.params.slug,
              collection: $route.params.collection,
              id: item.id,
            },
          }"
          ><v-icon class="mr-2"> mdi-pencil </v-icon></router-link
        >
        <v-icon @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import Api from "../../services/api";

export default {
  data() {
    return {
      loading: true,
      entries: [],
      headers: [],
      selected: [],
    };
  },

  created() {
    let api = Api.new();
    let vm = this;

    api
      .getEntries(this.$route.params.slug, this.$route.params.collection)
      .then((resp) => {
        for (let entrie of resp.data) {
          for (let key in entrie) {
            vm.headers.push({
              value: key,
              text: key,
            });
          }
        }
        vm.headers.push({ text: "Actions", value: "actions", sortable: false }),
          (vm.entries = resp.data);
      }).catch(err => {
      }).finally(e => {
        vm.loading = false
      });
  },

  methods: {
    editItem(item) {
      alert("a");
    },

    deleteItem(item) {
      alert("a");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>