<template>
  <v-page :infinite-scroll="false">
    <thread :thread-data="thread"/>
    <transition-list>
      <comment
        v-for="commentKey in commentKeys"
        :key="commentKey"
        :comment-key="commentKey"
        :depth="0"/>
    </transition-list>
  </v-page>
</template>

<script>
import breadcrumbs from "../constants/Breadcrumbs";
import Comment from "../components/comment/Comment.vue";
import Thread from "../components/thread/Thread";
import TransitionList from "../components/transitions/TransitionList";
import VPage from "../components/utility/VPage";
import { mapActions, mapState } from "vuex";

export default {
  name: "ThreadView",

  components: {
    Comment,
    Thread,
    TransitionList,
    VPage
  },

  props: {
    thread: {
      type: Object,
      required: true
    }
  },

  computed: {
    ...mapState("threads/thread", {
      commentKeys: state => state.comments.keys,
      channelCrumb: state => state.breadcrumb.channel,
      threadCrumb: state => state.breadcrumb.thread
    })
  },

  created() {
    this.addBreadcrumbs([
      breadcrumbs.THREADS,
      this.channelCrumb,
      this.threadCrumb
    ]);
  },

  methods: mapActions(["addBreadcrumbs"])
};
</script>
