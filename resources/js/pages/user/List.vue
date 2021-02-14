<template>
  <div>
    <v-subheader class="my-5">
      <v-text-field
        v-model="search"
        :placeholder="'Search application (' + users.length + ')'"
        class="mt-0 pt-0"
        hide-details
        single-line
        type="search"
      ></v-text-field>
    </v-subheader>
    <v-row dense v-if="users.length">
      <v-col :cols="appsPerCol" v-for="user in users" v-bind:key="user.id">
        <v-card class="mx-auto" max-width="344" outlined>
          <v-list-item three-line>
            <v-list-item-content>
              <v-list-item-title class="headline mb-1">
                {{ user.name }}
              </v-list-item-title>
            </v-list-item-content>

            <v-list-item-avatar tile size="80" color="blue"
              ><span class="white--text headline">{{
                user.name[0].toUpperCase()
              }}</span></v-list-item-avatar
            >
          </v-list-item>

          <v-card-actions>
            <v-btn
              color="deep-purple lighten-2"
              text
              :to="{ name: 'user.edit', params: { slug: user.id } }"
              ><v-icon>mdi-create</v-icon> Edit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col>
        <h2>No users founded</h2>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      appsPerCol: 3,
      users: [],
    };
  },

  created() {
    let vm = this;
    axios.get("/api/users/").then((resp) => {
      vm.users = resp.data;
    });
  },
};
</script>

<style>
</style>