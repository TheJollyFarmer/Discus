<template>
  <v-list-item v-show="typing">
    <v-media-object
      icon="auth"
      dimension="42">
      <v-typing-indicator
        :group="group"
        @typing="typing = $event"/>
    </v-media-object>
  </v-list-item>
</template>

<script>
import VListItem from "../utility/VListItem";
import VMediaObject from "../utility/VMediaObject";
import VTypingIndicator from "../utility/VTypingIndicator";

export default {
  name: "ChatTypingIndicator",

  components: {
    VListItem,
    VMediaObject,
    VTypingIndicator
  },

  props: {
    group: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      typing: false
    };
  }
};
</script>
