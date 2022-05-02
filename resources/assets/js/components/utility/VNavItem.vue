<template>
  <a
    v-tooltip:bottom="label"
    class="navbar-link is-arrowless"
    @click="$emit('onClick')">
    <v-favicon :icon="icon"/>
    <v-count
      v-if="unreadCount !== null"
      :count="unreadCount"/>
  </a>
</template>

<script>
import VFavicon from "./VFavicon";
import VCount from "./VCount";

export default {
  name: "VNavItem",

  components: { VCount, VFavicon },

  props: {
    icon: {
      type: String,
      required: false,
      default: null
    },

    unreadCount: {
      type: Number,
      required: false,
      default: null
    },

    label: {
      type: String,
      required: false,
      default: ""
    }
  }
};
</script>

<style scoped>
.navbar-link .icon {
  margin-left: -0.25rem;
  margin-right: -0.25rem;
}
</style>
