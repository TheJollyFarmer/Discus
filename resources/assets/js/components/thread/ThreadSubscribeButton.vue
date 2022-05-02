<template>
  <v-button
    :class="subscribeClass"
    :icon="subscribeIcon"
    @onClick="subscribeEvent"/>
</template>

<script>
import VButton from "../utility/VButton";
import { mapState } from "vuex";

export default {
  name: "ThreadSubscribedButton",

  components: { VButton },

  computed: {
    ...mapState("threads/thread", {
      isSubscribed: state => state.thread.isSubscribed
    }),

    subscribeClass() {
      return this.isSubscribed ? "is-danger" : "is-primary";
    },

    subscribeIcon() {
      return this.isSubscribed ? "bell-slash" : "rss";
    }
  },

  methods: {
    subscribeEvent() {
      this.$emit("subscribe");
    }
  }
};
</script>
