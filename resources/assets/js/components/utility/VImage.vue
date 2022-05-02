<template>
  <figure :class="['image', isContainer, isSize]">
    <img
      :src="image"
      alt="Image">
  </figure>
</template>

<script>
export default {
  name: "VImage",

  props: {
    image: {
      type: String,
      required: true
    },

    container: {
      type: Boolean,
      required: false,
      default: true
    },

    dimension: {
      type: String,
      required: false,
      default: "24"
    }
  },

  computed: {
    isContainer() {
      return this.container ? "container" : "";
    },

    isSize() {
      return `is-${this.dimension}x${this.dimension}`;
    }
  }
};
</script>

<style scoped>
img {
  border-radius: 50%;
}
</style>
