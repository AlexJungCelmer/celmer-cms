<template>
  <div>
    <!-- if admin to edit preferences -->
    <div v-if="$store.state.user.user.is_admin">
      <form>
        <v-text-field
          label="Application name"
          required
          type="text"
          name="name"
          v-model="app.name"
        ></v-text-field>
        <v-text-field
          label="Production Url"
          required
          type="text"
          name="production_url"
          v-model="app.production_url"
        ></v-text-field>
        <v-text-field
          label="Dev Url"
          required
          type="text"
          name="dev_url"
          v-model="app.dev_url"
        ></v-text-field>
        <v-switch
          v-model="app.is_production"
          label="Is in Production"
        ></v-switch>
      </form>
      <v-btn color="primary" class="mr-4 mb-4" v-on:click="createApp()">{{
        $route.params.slug ? "Update" : "Create"
      }}</v-btn>
    </div>
    <!-- collection list -->
    <div>
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
                  name: 'collection.entries',
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      app: {
        name: "",
        production_url: "",
        dev_url: "",
        is_production: "",
      },
      collections: [],
    };
  },

  created() {
    let vm = this;

    if (vm.$route.params.slug != "") {
      axios.get("/api/apps/" + vm.$route.params.slug).then((resp) => {
        vm.app = resp.data;
        axios
          .get("/api/apps/" + vm.$route.params.slug + "/collections")
          .then((resp) => {
            resp.data.forEach(element => {
              console.log(element);
              vm.collections.push(element)
            });
          });
      });
    } else {
      vm.$route.push({ name: "app.list" });
    }
  },

  methods: {
    createApp: function () {
      let vm = this;
      axios.post("/api/apps/new", { name: vm.app.name }).then((resp) => {
        console.log(resp);
      });
    },
  },
};
</script>

<style>
</style>