<template>
  <span
    v-show="count > 0"
    class="icon-counter"
    v-text="count"/>
</template>

<script>
export default {
  name: "VCount",

  props: {
    count: {
      type: Number,
      required: true
    }
  }
};
</script>

<style scoped>
.icon-counter {
  position: absolute;
  padding: 0 0.5em 0 0.5em;
  background-color: rgba(171, 171, 255, 1);
  border-radius: 20%;
  font-size: 0.6rem;
  top: 0.6rem;
  right: 0.1rem;
}
</style>
