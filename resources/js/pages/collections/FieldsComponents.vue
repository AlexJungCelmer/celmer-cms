<template>
  <v-row>
    <v-col>
      <v-text-field
        label="Field name"
        required
        type="text"
        v-model="field.name"
      ></v-text-field>
    </v-col>
    <v-col>
      <v-text-field
        label="Field label"
        required
        type="text"
        v-model="field.label"
      ></v-text-field>
    </v-col>
    <v-col align="end">
      <v-btn color="primary" class="ma-2" dark v-on:click="$emit('toEdit', field)">
        <v-icon>mdi-cog</v-icon>
      </v-btn>
      <v-btn color="error" class="ma-2" dark v-on:click="$emit('toRemove', field)">
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  // data() {
  //   return {
  //     field: {
  //       name: "",
  //       label: "",
  //       type: "",
  //       order: "",
  //     },
  //   };
  // },
  props: ["field"],
};
</script>

<style>
</style>