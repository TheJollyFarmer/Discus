<template>
  <div>
    <v-wysiwyg
      v-model="editForm.body"
      :editing="isEditing"/>
    <template v-if="canComment">
      <comment-body-buttons
        :comment="comment.user"
        :children="comment.replies"
        :depth="depth"
        @form="setForm"
        @cancel="closeForm"
        @submit="submitEvent"
        @delete="deleteEvent"/>
      <transition-expand>
        <v-wysiwyg
          v-show="isReplying"
          v-model="replyForm.body"
          :autofocus="isReplying"
          name="Reply Form"/>
      </transition-expand>
    </template>
  </div>
</template>

<script>
import CommentBodyButtons from "./CommentBodyButtons";
import TransitionExpand from "../transitions/TransitionExpand";
import VWysiwyg from "../utility/VWysiwyg";
import { mapGetters } from "vuex";

export default {
  name: "CommentBody",

  components: {
    CommentBodyButtons,
    TransitionExpand,
    VWysiwyg
  },

  props: {
    comment: {
      type: Object,
      required: true
    },

    depth: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      displayForm: false,
      oldBody: this.comment.body,
      editForm: {
        body: this.comment.body,
        reply: this.comment.id
      },
      replyForm: {
        body: "",
        parent_id: this.comment.id
      }
    };
  },

  computed: {
    ...mapGetters({
      isLoggedIn: "auth/isLoggedIn",
      isThreadLocked: "threads/thread/isThreadLocked"
    }),

    isReplying() {
      return this.displayForm === "reply";
    },

    isEditing() {
      return this.displayForm === "edit";
    },

    canComment() {
      return this.isLoggedIn && !this.isThreadLocked;
    }
  },

  methods: {
    setForm(type) {
      this.displayForm = type;
    },

    closeForm() {
      if (this.displayForm === "edit") {
        this.editForm.body = this.oldBody;
      }

      this.displayForm = false;
    },

    submitEvent(cb) {
      this.displayForm === "reply" ? this.submitReply(cb) : this.submitEdit(cb);
    },

    deleteEvent() {
      this.$emit("delete", this.comment.id);
    },

    submitReply(callback) {
      if (this.replyForm.body) {
        this.$emit("reply", this.replyForm, done => {
          if (done) {
            this.displayForm = false;
            this.replyForm.body = "";

            callback("hideButtons");
          }
        });
      }
    },

    submitEdit(callback) {
      if (this.editForm.body && this.editForm.body !== this.oldBody) {
        this.$emit("edit", this.editForm, done => {
          if (done) {
            this.oldBody = this.editForm.body;
            this.displayForm = false;

            callback("hideButtons");
          }
        });
      }
    }
  }
};
</script>
