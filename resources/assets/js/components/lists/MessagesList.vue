<template>
  <v-data-list
    :data="messages"
    :label="label"
    model="auth/messages"
    #list="{ item: message }"
    @getData="getData">
    <messages-list-item
      :item="message"
      :truncate="truncate"
      @onClick="loadChat"
      @onToggle="toggleMarkAs"/>
  </v-data-list>
</template>

<script>
import MessagesListItem from "./MessagesListItem";
import VDataList from "../utility/VDataList";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "MessagesList",

  components: { MessagesListItem, VDataList },

  props: {
    label: {
      type: String,
      required: false,
      default: "messages"
    },

    truncate: {
      type: Number,
      required: false,
      default: 25
    },

    load: {
      type: String,
      required: false,
      default: "chat"
    }
  },

  computed: mapGetters("auth/messages", {
    messages: "getMessages"
  }),

  watch: {
    messages(messages) {
      if (messages.length) {
        setTimeout(() => {
          this.preloadChat(messages[0]);
        }, 200);
      }
    }
  },

  methods: {
    ...mapActions("auth", {
      getData: "messages/getData",
      markAs: "messages/markAs",
      createGroup: "groups/createGroup"
    }),

    loadChat(message) {
      this.load === "tab" || this.load === "page"
        ? this.loadChatEvent(message)
        : this.generateGroup(message);
    },

    preloadChat(message) {
      if (this.load === "page") {
        this.$emit("loadChat", message);
      }
    },

    loadChatEvent(message) {
      this.$emit("loadChat", message);
    },

    generateGroup(message) {
      this.createGroup({
        type: message.type,
        users: message.users
      });
    },

    toggleMarkAs(message) {
      this.markAs({
        group: message.group,
        marked: message.read
      });
    }
  }
};
</script>
