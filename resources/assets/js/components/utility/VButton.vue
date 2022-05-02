<template>
  <transition-fade>
    <button
      :type="type"
      role="button"
      class="button is-primary"
      @click="emitClick">
      <v-favicon
        v-if="icon"
        :class="hasContent"
        :icon="icon"/>
      <slot/>
    </button>
  </transition-fade>
</template>

<script>
import throttle from "lodash/throttle";
import TransitionFade from "../transitions/TransitionFade";
import VFavicon from "./VFavicon";

export default {
  name: "VButton",

  components: { TransitionFade, VFavicon },

  props: {
    type: {
      type: String,
      required: false,
      default: "button"
    },

    icon: {
      type: String,
      required: false,
      default: ""
    }
  },

  computed: {
    hasContent() {
      return this.$slots.default ? "mr" : "";
    }
  },

  methods: {
    emitClick: throttle(function() {
      this.$emit("onClick");
    }, 1000)
  }
};
</script>

<style scoped>
.mr {
  margin-right: 0.25em !important;
}
</style>
