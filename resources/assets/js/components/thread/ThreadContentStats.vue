<template>
  <div class="buttons">
    <v-button
      v-if="isLocked"
      class="is-outlined" 
      icon="lock"/>
    <v-button 
      v-if="isSubscribed"
      class="is-outlined"
      icon="rss"/>
    <v-button 
      v-if="isPinned"
      class="is-outlined"
      icon="thumbtack"/>
  </div>
</template>

<script>
import VButton from "../utility/VButton";
import { mapState } from "vuex";

export default {
  name: "ThreadContentHeadStats",

  components: { VButton },

  computed: mapState("threads/thread", {
    isLocked: state => state.thread.isLocked,
    isPinned: state => state.thread.isPinned,
    isSubscribed: state => state.thread.isSubscribed
  })
};
</script>
