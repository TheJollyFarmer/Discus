<template>
  <v-timeline-item
    :icon="icon"
    :classes="classes">
    <v-media-object
      :avatar="data.avatar"
      :is-v-centered="false">
      <thread-head-labels
        :thread="data"
        :truncate="30"/>
      <v-quote :quote="data.body"/>
      <div class="buttons are-small">
        <slot :activity="data"/>
      </div>
    </v-media-object>
  </v-timeline-item>
</template>

<script>
import dataStructures from "../../../utils/dataStructures";
import ThreadHeadLabels from "../../threads/ThreadHeadLabels";
import VMediaObject from "../../utility/VMediaObject";
import VQuote from "../../utility/VQuote";
import VTimelineItem from "../../utility/timeline/VTimelineItem";

export default {
  name: "Activity",

  components: {
    ThreadHeadLabels,
    VMediaObject,
    VTimelineItem,
    VQuote
  },

  props: {
    activity: {
      type: Object,
      required: true
    },

    icon: {
      type: String,
      required: true
    },

    type: {
      type: String,
      required: false,
      default: "replies"
    },

    classes: {
      type: String,
      required: false,
      default: "is-primary"
    }
  },

  data() {
    return {
      data: dataStructures.activity[this.type](this.activity)
    };
  }
};
</script>
