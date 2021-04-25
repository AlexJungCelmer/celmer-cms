<template>
  <div>
    <h1>Add collection to the app</h1>
    <form>
      <v-text-field
        label="Collection name"
        required
        type="text"
        name="name"
        v-model="collection.name"
        :disabled="collection.id"
      ></v-text-field>
      <v-text-field
        label="Collection Label(what you will read)"
        required
        type="text"
        name="name"
        v-model="collection.label"
      ></v-text-field>
      <v-spacer></v-spacer>
      <h2>Fields</h2>
      <!-- fields goes here -->
      <div>
        <draggable v-model="collection.fields.order">
          <transition-group>
            <fields-components
              v-for="(field, index) in collection.fields"
              v-bind:key="'field' + index"
              v-on:toEdit="
                field_to_edit = $event;
                field_edit_dialog = true;
              "
              v-on:toRemove="collection.fields.splice(index, 1)"
              :field="field"
            ></fields-components>
          </transition-group>
        </draggable>
      </div>
      <v-btn class="ma-2" outlined color="indigo" v-on:click="appendField()">
        Add field
      </v-btn>
    </form>
    <!-- dialog for edit the field -->
    <v-dialog v-model="field_edit_dialog" max-width="500px">
      <v-card>
        <v-card-title> Editing field: {{ field_to_edit.label }} </v-card-title>
        <v-card-text>
          <v-select
            v-model="field_to_edit.type"
            :items="field_types"
            menu-props="auto"
            hide-details
            label="Select field type"
            single-line
          ></v-select>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" text @click="field_edit_dialog = false">
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-speed-dial bottom right absolute>
      <template v-slot:activator>
        <v-btn color="blue darken-2" dark fab v-on:click="store()">
          <v-icon> mdi-send </v-icon>
        </v-btn>
      </template>
    </v-speed-dial>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import fieldsComponents from "./FieldsComponents";
export default {
  components: { fieldsComponents },
  data() {
    return {
      collection: {
        name: "",
        label: "",
        options: "",
        fields: [],
      },
      field_edit_dialog: false,
      field_quantity: 0,
      field_to_edit: {},
      field_types: ["Text", "Select", "Rich text", "Number"],
    };
  },

  methods: {
    appendField: function () {
      let vm = this;
      vm.collection.fields.push({
        name: "new",
        label: "new",
        type: "text",
        order: "3",
      });
    },

    store: function () {
      let route = "/api/apps/" + this.$route.params.slug + "/collections/store";
      if (this.$route.params.collection != "create") {
        route = "/api/apps/"+this.$route.params.slug+"/collections/"+this.$route.params.collection+"/update";
      }
      axios.post(route, this.collection).then((resp) => {
        console.log(resp);
      });
    },
  },

  created() {
    let vm = this;
    axios
      .get(
        "/api/apps/" +
          vm.$route.params.slug +
          "/collections/" +
          vm.$route.params.collection
      )
      .then((resp) => {
        resp.data.fields = JSON.parse(resp.data.fields);
        vm.collection = resp.data;
        console.log("collection fields", resp.data);
      });
  },
  components: {
    draggable,
  },
};
</script>

<style>
</style>