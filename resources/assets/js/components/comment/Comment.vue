<template>
  <v-media-object
    :id="`comment-${comment.id}`"
    :avatar="comment.avatar"
    :is-v-centered="false"
    class="comment">
    <comment-head
      :comment="comment"
      @favouritable="toggleFavourited"
      @isBest="toggleisBest"
      @toggle="toggleContent"/>
    <transition-expand>
      <div v-show="comment.showContent">
        <comment-body
          :comment="comment"
          :depth="depth"
          @reply="addReply"
          @edit="editComment"
          @delete="destroyComment"/>
        <comment-replies
          :replies="replies"
          :depth="depth"/>
      </div>
    </transition-expand>
  </v-media-object>
</template>

<script>
import CommentBody from "./CommentBody";
import CommentHead from "./CommentHead";
import CommentReplies from "./CommentReplies";
import TransitionExpand from "../transitions/TransitionExpand";
import VMediaObject from "../utility/VMediaObject";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Comment",

  components: {
    CommentBody,
    CommentHead,
    CommentReplies,
    TransitionExpand,
    VMediaObject
  },

  props: {
    commentKey: {
      type: Number,
      required: true
    },

    depth: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      replying: false,
      editing: false,
      showContent: true
    };
  },

  computed: {
    ...mapGetters("threads/thread/comments", ["getComment"]),

    comment() {
      return this.getComment(this.commentKey);
    },

    replies() {
      return this.comment.replies;
    }
  },

  methods: {
    ...mapActions("threads/thread", {
      setBestComment: "setBestComment",
      unsetBestComment: "unsetBestComment",
      submitReply: "comments/submitReply",
      updateBody: "comments/updateBody",
      deleteComment: "comments/deleteComment",
      favouriteComment: "comments/favouriteComment",
      unfavouriteComment: "comments/unfavouriteComment",
      toggleContent: "comments/toggleContent"
    }),

    addReply(form, cb) {
      this.submitReply(form).then(() => cb("resetForm"));
    },

    editComment(form, cb) {
      this.updateBody(form).then(() => cb("resetForm"));
    },

    destroyComment(id) {
      this.deleteComment({ id, parent: this.comment.parent });
    },

    toggleFavourited(id) {
      this.comment.isFavourited
        ? this.unfavouriteComment(id)
        : this.favouriteComment(id);
    },

    toggleisBest(id, isBest) {
      isBest ? this.unsetBestComment(id) : this.setBestComment(id);
    }
  }
};
</script>

<style scoped>
.comment {
  border-top: 1px solid rgba(219, 219, 219, 0.5);
  margin: 0;
  padding-top: 0.7rem;
}
</style>
