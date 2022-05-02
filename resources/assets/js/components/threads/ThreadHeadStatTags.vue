<template>
  <v-field
    grouped
    multiline>
    <div class="control">
      <v-tag 
        v-if="thread.hasUpdates"
        class="has-text-weight-bold has-background-danger">
        NEW
      </v-tag>
    </div>
    <v-stat-tag 
      :stat="thread.visits" 
      icon="eye"/>
    <v-stat-tag
      :stat="thread.comments"
      icon="reply-all"/>
  </v-field>
</template>

<script>
import VField from "../utility/VField";
import VStatTag from "../utility/VStatTag";
import VTag from "../utility/VTag";

export default {
  name: "ThreadStatTags",

  components: {
    VField,
    VStatTag,
    VTag
  },

  props: {
    thread: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
.control {
  line-height: normal;
}
</style>
