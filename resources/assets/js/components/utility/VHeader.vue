<template>
  <component 
    :is="elementType"
    :class="['has-text-primary header is-uppercase', classes]">
    <v-favicon 
      v-if="icon" 
      :icon="icon"/>
    <slot/>
  </component>
</template>

<script>
import VFavicon from "./VFavicon";

export default {
  name: "VHeader",

  components: { VFavicon },

  props: {
    type: {
      type: String,
      required: false,
      default: "1"
    },

    size: {
      type: String,
      required: false,
      default: "5"
    },

    icon: {
      type: String,
      required: false,
      default: ""
    }
  },

  computed: {
    elementType() {
      return `h${this.type}`;
    },

    classes() {
      return `is-size-${this.size}`;
    }
  }
};
</script>

<style scoped>
.header {
  letter-spacing: 0.1em;
  margin-bottom: 1em;
}
</style>
