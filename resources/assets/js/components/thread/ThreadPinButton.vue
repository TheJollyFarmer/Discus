<template>
  <v-button
    :class="pinClass"
    :icon="pinIcon"
    @onClick="pinEvent"/>
</template>

<script>
import VButton from "../utility/VButton";
import { mapState } from "vuex";

export default {
  name: "ThreadPinButton",

  components: { VButton },

  computed: {
    ...mapState("threads/thread", {
      isPinned: state => state.thread.isPinned
    }),

    pinClass() {
      return this.isPinned ? "is-danger" : "is-primary";
    },

    pinIcon() {
      return this.isPinned ? "" : "thumbtack";
    }
  },

  methods: {
    pinEvent() {
      this.$emit("pin");
    }
  }
};
</script>
