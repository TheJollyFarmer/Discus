<template>
  <v-favicon
    v-if="icon"
    :icon="icon"
    :style="{'color': iconColour}"/>
  <span 
    v-else 
    class="icon-number">
    {{ number + 1 }}
  </span>
</template>

<script>
import VFavicon from "./VFavicon";

export default {
  name: "VMenuItemIcon",

  components: { VFavicon },

  props: {
    icon: {
      type: String,
      required: false,
      default: ""
    },

    iconColour: {
      type: String,
      required: false,
      default: ""
    },

    number: {
      type: Number,
      required: false,
      default: null
    }
  }
};
</script>

<style scoped>
.icon-number {
  font-size: 1.2em;
  font-weight: 600;
  line-height: 1.1;
  margin-left: 0.3em;
}
</style>
