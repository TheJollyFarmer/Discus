<template>
  <header class="timeline-header">
    <span :class="['tag', size, type]">
      <slot>
        {{ label }}
      </slot>
    </span>
  </header>
</template>

<script>
export default {
  name: "VTimelineHeader",

  props: {
    label: {
      type: String,
      required: false,
      default: ""
    },

    size: {
      type: String,
      required: false,
      default: ""
    },

    type: {
      type: String,
      required: false,
      default: "is-primary"
    }
  }
};
</script>
