<template>
  <v-level>
    <thread-head-labels :thread="thread"/>
    <v-rotate :rotate="thread.showContent"/>
    <template #levelRight>
      <thread-head-stat-tags :thread="thread"/>
    </template>
  </v-level>
</template>

<script>
import ThreadHeadLabels from "./ThreadHeadLabels";
import ThreadHeadStatTags from "./ThreadHeadStatTags";
import VLevel from "../utility/VLevel";
import VRotate from "../utility/VRotate";

export default {
  name: "ThreadHead",

  components: {
    ThreadHeadLabels,
    ThreadHeadStatTags,
    VRotate,
    VLevel
  },

  props: {
    thread: {
      type: Object,
      required: true
    }
  }
};
</script>
