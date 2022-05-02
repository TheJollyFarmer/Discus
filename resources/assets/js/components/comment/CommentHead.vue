<template>
  <v-level 
    class="comment-header" 
    @click.native="toggleContent">
    <comment-head-labels :comment="comment"/>
    <v-rotate :rotate="comment.showContent"/>
    <template #levelRight>
      <comment-head-stats
        :comment="comment"
        @favouritable="favouritableEvent"
        @isBest="isBestEvent"/>
    </template>
  </v-level>
</template>

<script>
import CommentHeadLabels from "./CommentHeadLabels";
import CommentHeadStats from "./CommentHeadStats";
import VLevel from "../utility/VLevel";
import VRotate from "../utility/VRotate";

export default {
  name: "CommentHead",

  components: {
    CommentHeadLabels,
    CommentHeadStats,
    VLevel,
    VRotate
  },

  props: {
    comment: {
      type: Object,
      required: true
    }
  },

  methods: {
    favouritableEvent(comment) {
      this.$emit("favouritable", comment);
    },

    isBestEvent(comment) {
      this.$emit("isBest", comment);
    },

    toggleContent() {
      this.$emit("toggle", this.comment.id);
    }
  }
};
</script>

<style lang="scss" scoped>
.comment-header {
  margin-bottom: 0.75rem;
  .button.is-primary.is-outlined:focus {
    background-color: white;
    color: #00d1b2;
  }
}
</style>
