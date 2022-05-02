<template>
  <div :class="['timeline-item', classes]">
    <v-timeline-mark
      :class="['is-outlined', classes]"
      :icon="icon"/>
    <div class="timeline-content">
      <slot/>
    </div>
  </div>
</template>

<script>
import VTimelineMark from "./VTimelineMark";

export default {
  name: "VTimelineItem",

  components: { VTimelineMark },

  props: {
    icon: {
      type: String,
      required: false,
      default: "reply"
    },

    label: {
      type: String,
      required: false,
      default: ""
    },

    body: {
      type: String,
      required: false,
      default: ""
    },

    classes: {
      type: String,
      required: false,
      default: "is-primary"
    }
  }
};
</script>
