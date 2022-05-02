<template>
  <div :class="['tags', { 'has-addons': addons }]">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "VTags",

  props: {
    addons: {
      type: Boolean,
      required: false,
      default: false
    }
  }
};
</script>
