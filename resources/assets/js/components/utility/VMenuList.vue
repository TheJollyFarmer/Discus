<template>
  <div>
    <p 
      v-if="label" 
      :class="['menu-label', classes]">
      <v-favicon 
        v-if="icon" 
        :icon="icon"/>
      {{ label }}
    </p>
    <ul class="menu-list">
      <slot/>
    </ul>
  </div>
</template>

<script>
import VFavicon from "./VFavicon";

export default {
  name: "VMenuList",

  components: { VFavicon },

  props: {
    label: {
      type: String,
      required: false,
      default: ""
    },

    icon: {
      type: String,
      required: false,
      default: ""
    },

    type: {
      type: String,
      required: false,
      default: "primary"
    },

    size: {
      type: String,
      required: false,
      default: "5"
    }
  },

  computed: {
    classes() {
      return [`has-text-${this.type}`, `is-size-${this.size}`];
    }
  }
};
</script>

<style scoped>
.menu-list {
  margin-bottom: 1em;
}
</style>
