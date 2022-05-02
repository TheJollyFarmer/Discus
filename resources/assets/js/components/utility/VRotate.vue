<template>
  <v-favicon
    :class="['rotate', isActive]"
    :size="size"
    icon="chevron-right"/>
</template>

<script>
import VFavicon from "./VFavicon";
export default {
  name: "VRotate",

  components: { VFavicon },

  props: {
    size: {
      type: String,
      required: false,
      default: ""
    },

    rotate: {
      type: Boolean,
      required: true
    }
  },

  computed: {
    isActive() {
      return this.rotate ? "is-active" : "";
    }
  }
};
</script>

<style lang="scss" scoped>
.rotate {
  margin-left: 1em;
  transform: rotate(0deg);
  transition: transform 0.5s;
  &.is-active {
    transform: rotate(90deg);
    transition: transform 0.5s;
  }
}
</style>
