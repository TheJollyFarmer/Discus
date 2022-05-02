<template>
  <div class="level-item">
    <slot>
      <v-button :icon="icon"/>
    </slot>
  </div>
</template>

<script>
import VButton from "./VButton";

export default {
  name: "VLevelItem",

  components: { VButton },

  props: {
    icon: {
      type: String,
      required: false,
      default: null
    }
  }
};
</script>
