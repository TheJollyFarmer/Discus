<template>
  <form
    class="form"
    novalidate
    @submit.prevent="submitEvent">
    <slot/>
    <slot name="buttons">
      <v-field :grouped="isFlatButtons">
        <v-button
          class="is-fullwidth"
          type="submit">
          {{ buttonOne }}
        </v-button>
        <v-button
          v-if="isFlatButtons"
          class="is-fullwidth is-danger"
          @onClick="cancelEvent">
          {{ buttonTwo }}
        </v-button>
      </v-field>
      <v-field v-if="!isFlatButtons">
        <v-button
          class="is-fullwidth is-danger"
          @onClick="cancelEvent">
          {{ buttonTwo }}
        </v-button>
      </v-field>
    </slot>
  </form>
</template>

<script>
import VButton from "./VButton";
import VField from "./VField";

export default {
  name: "VForm",

  components: { VButton, VField },

  props: {
    buttonOne: {
      type: String,
      required: false,
      default: "Submit"
    },

    buttonTwo: {
      type: String,
      required: false,
      default: "Cancel"
    },

    isFlatButtons: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  methods: {
    submitEvent() {
      this.$emit("submit");
    },

    cancelEvent() {
      this.$emit("cancel");
    }
  }
};
</script>

<style>
.is-fullwidth:first-of-type {
  margin-right: 1.25rem;
}
</style>
