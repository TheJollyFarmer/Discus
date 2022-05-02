<template>
  <div :class="['dropdown-item', 'is-size-' + size]">
    <slot>
      {{ text }}
    </slot>
  </div>
</template>
<script>
export default {
  name: "VError",

  props: {
    text: {
      type: String,
      required: true
    },

    size: {
      type: String,
      required: false,
      default: "6"
    }
  }
};
</script>
