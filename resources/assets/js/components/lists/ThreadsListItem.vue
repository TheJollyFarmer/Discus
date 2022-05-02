<template>
  <v-media-object 
    :avatar="thread.avatar"
    :is-v-centered="false"
    class="thread"
    @onClick="toggleBody">
    <thread-head :thread="thread"/>
    <transition-expand>
      <v-quote
        v-show="thread.showContent"
        :quote="thread.body"
        :truncate="truncate"/>
    </transition-expand>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters";
import ThreadHead from "../threads/ThreadHead";
import TransitionExpand from "../transitions/TransitionExpand";
import VMediaObject from "../utility/VMediaObject";
import { mapActions } from "vuex";
import VQuote from "../utility/VQuote";

export default {
  name: "ThreadsListItem",

  filters: {
    truncate: filters.truncate
  },

  components: {
    VQuote,
    ThreadHead,
    TransitionExpand,
    VMediaObject
  },

  props: {
    thread: {
      type: Object,
      required: true
    },

    truncate: {
      type: Number,
      required: true
    }
  },

  methods: {
    ...mapActions("threads", ["toggleContent"]),

    toggleBody() {
      this.toggleContent(this.thread.id);
    }
  }
};
</script>

<style lang="scss" scoped>
.thread {
  font-size: 1rem;
  .level {
    margin-bottom: 0;
    padding-bottom: 0.375rem;
  }
  .quote {
    margin: 0 0 0.4rem 0;
  }
}
</style>
