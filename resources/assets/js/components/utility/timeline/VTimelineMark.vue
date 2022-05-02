<template>
  <div :class="['timeline-marker', markType]">
    <slot>
      <v-favicon
        v-if="icon"
        :icon="icon"/>
    </slot>
  </div>
</template>

<script>
import VFavicon from "../VFavicon";

export default {
  name: "VTimelineMark",

  components: { VFavicon },

  props: {
    icon: {
      type: String,
      required: false,
      default: ""
    },

    type: {
      type: String,
      required: false,
      default: "icon"
    }
  },

  computed: {
    markType() {
      switch (this.type) {
        case "icon":
          return "is-icon";

        case "image":
          return "is-image";

        default:
          return "";
      }
    }
  }
};
</script>
