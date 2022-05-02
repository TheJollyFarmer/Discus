<template>
  <v-button
    :class="lockClass"
    :icon="lockIcon"
    @onClick="lockEvent"/>
</template>

<script>
import VButton from "../utility/VButton";
import { mapState } from "vuex";

export default {
  name: "ThreadLockButton",

  components: { VButton },

  computed: {
    ...mapState("threads/thread", {
      isLocked: state => state.thread.isLocked
    }),

    lockClass() {
      return this.isLocked ? "is-primary" : "is-danger";
    },

    lockIcon() {
      return this.isLocked ? "unlock" : "lock";
    }
  },

  methods: {
    lockEvent() {
      this.$emit("lock");
    }
  }
};
</script>
