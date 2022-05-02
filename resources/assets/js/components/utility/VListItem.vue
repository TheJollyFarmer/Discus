<template>
  <component
    :is="elementType"
    class="dropdown-item"
    @click="$emit('onClick')">
    <slot/>
  </component>
</template>

<script>
export default {
  name: "VListItem",

  props: {
    hasLink: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    elementType() {
      return this.hasLink ? "a" : "div";
    }
  }
};
</script>

<style scoped>
.dropdown-item {
  width: 100%;
}

a.dropdown-item {
  padding-right: 1rem;
}
</style>
