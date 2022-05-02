<template>
  <v-form>
    <v-field>
      <v-input
        v-model="name"
        :errors="getErrors('name')"
        placeholder="Name"
        icon-left="user"/>
    </v-field>
    <v-field>
      <v-input
        v-model="description"
        :errors="getErrors('description')"
        placeholder="Description"
        icon-left="info"/>
    </v-field>
    <v-field>
      <v-input
        v-model="colour"
        :errors="getErrors('colour')"
        placeholder="Colour"
        icon-left="palette"/>
    </v-field>
    <v-field>
      <v-select
        v-model="status"
        :options="['active', 'archived']"
        :errors="getErrors('name')"
        icon="archive"/>
    </v-field>
  </v-form>
</template>

<script>
import VField from "../utility/VField";
import VForm from "../utility/VForm";
import VInput from "../utility/VInput";
import VSelect from "../utility/VSelect";
import { mapGetters } from "vuex";

export default {
  name: "EditChannelModal",

  components: {
    VField,
    VForm,
    VInput,
    VSelect
  },

  computed: {
    ...mapGetters(["getErrors"]),

    name: {
      get() {
        return this.channelForm.name;
      },

      set(value) {
        this.updateName(value);
      }
    },

    description: {
      get() {
        return this.channelForm.description;
      },

      set(value) {
        this.updateDescripiton(value);
      }
    },

    colour: {
      get() {
        return this.channelForm.colour;
      },

      set(value) {
        this.updateColour(value);
      }
    },

    status: {
      get() {
        return this.channelForm.status;
      },

      set(value) {
        this.updateStatus(value);
      }
    }
  }
};
</script>
