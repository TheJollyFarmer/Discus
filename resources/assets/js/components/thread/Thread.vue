<template>
  <v-media-object
    :avatar="thread.avatar"
    :is-v-centered="false">
    <thread-content :thread="thread"/>
    <thread-buttons
      v-if="isLoggedIn"
      @edit="updateThread"
      @comment="submit"
      @subscribe="toggleIsSubscribed"
      @lock="toggleIsLocked"
      @pin="toggleIsPinned"
      @delete="deleteThread"/>
    <transition-expand>
      <v-wysiwyg
        v-show="commenting"
        v-model="comment"
        name="Comment Form"/>
    </transition-expand>
    <thread-filters/>
  </v-media-object>
</template>

<script>
import ThreadButtons from "../../components/thread/ThreadButtons";
import ThreadContent from "./ThreadContent";
import ThreadFilters from "../../components/thread/ThreadFilters";
import TransitionExpand from "../transitions/TransitionExpand";
import VMediaObject from "../../components/utility/VMediaObject";
import VWysiwyg from "../../components/utility/VWysiwyg";
import { mapActions, mapGetters, mapState } from "vuex";

export default {
  name: "Thread",

  components: {
    ThreadButtons,
    ThreadContent,
    ThreadFilters,
    TransitionExpand,
    VMediaObject,
    VWysiwyg
  },

  props: {
    threadData: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      comment: ""
    };
  },

  computed: {
    ...mapGetters("auth", ["isLoggedIn"]),

    ...mapState("threads/thread", ["thread", "formType"]),

    commenting() {
      return this.formType === "commenting";
    }
  },

  created() {
    this.setThread(this.threadData);
  },

  mounted() {
    window.addEventListener("popstate", () => {
      location.search ? this.getData() : history.back();
    });
  },

  methods: {
    ...mapActions("threads/thread", [
      "setThread",
      "submitComment",
      "updateThread",
      "toggleIsSubscribed",
      "toggleIsLocked",
      "toggleIsPinned",
      "deleteThread"
    ]),

    ...mapActions("threads/thread/comments", ["getData"]),

    submit() {
      this.submitComment(this.comment).then(() => (this.comment = ""));
    }
  }
};
</script>
