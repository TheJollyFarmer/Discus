<template>
  <div
    :class="['chat-window', isCollapsed]"
    :style="windowPosition">
    <chat
      :display="display"
      :group="group" 
      custom-class="overflow-visible">
      <chat-window-head
        :users="users"
        @closeWindow="closeWindow"
        @leaveChat="leaveChat"
        @deleteChat="deleteChat"
        @toggleWindow="toggleWindow"
        @toggleInput="toggleFriendInputEvent"/>
    </chat>
  </div>
</template>

<script>
import Chat from "../chat/Chat";
import ChatWindowHead from "./ChatWindowHead";
import { mapGetters } from "vuex";

export default {
  name: "ChatWindow",

  components: {
    Chat,
    ChatWindowHead
  },

  props: {
    group: {
      type: Number,
      required: true
    },

    index: {
      type: Number,
      required: true
    }
  },

  computed: {
    ...mapGetters("auth/groups", ["getGroupUsers", "getGroupDisplay"]),

    users() {
      return this.getGroupUsers(this.group);
    },

    display() {
      return this.getGroupDisplay(this.group);
    },

    isCollapsed() {
      return { "is-collapsed": !this.display };
    },

    windowPosition() {
      let position = this.index * 20 + 22;

      return `right: ${position}em`;
    }
  },

  methods: {
    addFriends(friends) {
      this.$emit("addFriends", { group: this.group, users: friends });

      this.displayFriendInput = false;
    },

    closeWindow() {
      this.$emit("closed", this.group);
    },

    leaveChat() {
      this.$emit("leave", this.group);
    },

    deleteChat() {
      this.$emit("deleted", this.group);
    },

    toggleWindow() {
      this.$emit("toggleDisplay", this.group);
    },

    toggleFriendInputEvent() {
      if (!this.display) {
        this.toggleWindow();
      }
    }
  }
};
</script>

<style scoped>
.chat-window {
  position: fixed;
  bottom: 0;
  width: 280px;
  height: 296px;
  border-top-left-radius: 0.6em;
  border-top-right-radius: 0.6em;
  background-color: white;
  transition: transform 0.2s ease-in-out;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
  z-index: 40;
}

.is-collapsed {
  transform: translate3d(0, 260px, 0);
}
</style>
