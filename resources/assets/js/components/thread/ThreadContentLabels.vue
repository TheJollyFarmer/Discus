<template>
  <div>
    <transition-fade>
      <v-input
        v-if="editing"
        v-model="value"
        @input="inputEvent"/>
      <div
        v-else
        v-text="value"/>
    </transition-fade>
    <a :href="route('profiles.show', username)">
      {{ username }}
    </a>
  </div>
</template>

<script>
import api from "../../api";
import VInput from "../utility/VInput";
import TransitionFade from "../transitions/TransitionFade";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "ThreadContentHeadLabels",

  components: { TransitionFade, VInput },

  props: {
    value: {
      type: String,
      required: false,
      default: ""
    },

    username: {
      type: String,
      required: true
    },

    editing: {
      type: Boolean,
      required: true
    }
  },

  methods: {
    route: api.route,

    inputEvent() {
      this.$emit("input");
    }
  }
};
</script>
