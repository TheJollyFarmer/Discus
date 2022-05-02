<template>
  <div>
    <transition-list :has-data="hasReplies">
      <reply
        v-for="(reply, index) in replies"
        v-if="replyFitsCriteria(index)"
        :key="reply"
        :comment-key="reply"
        :depth="depth + 1"/>
    </transition-list>
    <v-button
      v-show="isExtraComments"
      icon="eye"
      class="is-pulled-right"
      @onClick="showExtraComments">
      <span>{{ hiddenReplies }} Show all comments</span>
    </v-button>
  </div>
</template>

<script>
import TransitionList from "../transitions/TransitionList";
import VButton from "../utility/VButton";

export default {
  name: "CommentReplies",

  components: {
    Reply: () => import("./Comment"),
    TransitionList,
    VButton
  },

  props: {
    replies: {
      type: Array,
      required: true
    },

    depth: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      showComments: false
    };
  },

  computed: {
    hiddenReplies() {
      return this.replies.length > 4 ? this.replies.length - 4 : 0;
    },

    hasReplies() {
      return !!this.replies.length;
    },

    isExtraComments() {
      return this.replies.length > 4 && !this.showComments;
    }
  },

  methods: {
    showExtraComments() {
      this.showComments = true;
    },

    replyFitsCriteria(index) {
      return index <= 3 || (index > 3 && this.showComments === true)
    }
  }
};
</script>

<style scoped>
.is-pulled-right {
  margin-bottom: 1em;
}
</style>
