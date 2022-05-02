<template>
  <v-data-list
    :data="messages"
    :label="label"
    :links="false"
    :is-chat="true"
    :model="`auth/chat-${group}`"
    #list="{ item: message }"
    @getData="getDataEvent">
    <chat-list-item
      :message="message"
      @deleted="deleteMessageEvent"/>
    <chat-typing-indicator :group="group"/>
  </v-data-list>
</template>

<script>
import ChatListItem from "./ChatListItem";
import ChatTypingIndicator from "../chat/ChatTypingIndicator";
import VDataList from "../utility/VDataList";

export default {
  name: "ChatList",

  components: {
    ChatListItem,
    ChatTypingIndicator,
    VDataList
  },

  props: {
    group: {
      type: Number,
      required: true
    },

    messages: {
      type: Array,
      required: true
    },

    label: {
      type: String,
      required: false,
      default: "messages"
    }
  },

  methods: {
    deleteMessageEvent(message) {
      this.$emit("deleteMessage", message);
    },

    getDataEvent() {
      this.$emit("getData");
    }
  }
};
</script>
