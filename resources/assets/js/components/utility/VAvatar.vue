<template>
  <figure :class="['image', isContainer, isSize]">
    <img
      :class="isCircle"
      :src="path"
      alt="User's Avatar">
  </figure>
</template>

<script>

export default {
  name: "VAvatar",

  props: {
    container: {
      type: Boolean,
      required: false,
      default: true
    },

    dimension: {
      type: String,
      required: false,
      default: "42"
    },

    path: {
      type: String,
      required: false,
      default: ""
    },

    circle: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    isContainer() {
      return this.container ? "container" : "";
    },

    isCircle() {
      return this.circle ? "is-circle" : "";
    },

    isSize() {
      return `is-${this.dimension}x${this.dimension}`;
    }
  }
};
</script>

<style scoped>
img {
  border-radius: 8px;
  border: 1px solid black;
}

.is-circle {
  border-radius: 50%;
}
</style>
