<template>
  <div>
    <!-- <v-data-table
      :headers="headers"
      :items="desserts"
      :items-per-page="5"
      class="elevation-1"
    ></v-data-table> -->
  </div>
</template>

<script>
import Api from "../../services/api";

export default {
  data() {
    return {
      entries: [],
    };
  },

  created() {
    let api = Api.new();
		api.getEntries(this.$route.params.slug, this.$route.params.collection)
  },
};
</script>

<style lang="scss" scoped>
</style>