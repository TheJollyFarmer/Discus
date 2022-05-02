<template>
  <div class="messages-tab">
    <transition-tab-slide :type="transitionType">
      <messages-list
        v-show="displayMessages"
        :truncate="18"
        load="tab"
        @loadChat="setGroup"/>
    </transition-tab-slide>
    <transition-tab-slide :type="transitionType">
      <chat
        v-show="!displayMessages"
        :display="!displayMessages"
        :group="group">
        <chat-tab-head
          :group="group"
          @back="clearGroup"
          @leave="leaveChat"
          @delete="deleteChat"/>
      </chat>
    </transition-tab-slide>
  </div>
</template>

<script>
import Chat from "../chat/Chat";
import ChatTabHead from "../chat/ChatTabHead";
import MessagesList from "../lists/MessagesList";
import TransitionTabSlide from "../transitions/TransitionTabSlide";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "MessagesTab",

  components: {
    Chat,
    ChatTabHead,
    MessagesList,
    TransitionTabSlide
  },

  data() {
    return {
      group: 0,
      displayMessages: true
    };
  },

  computed: {
    transitionType() {
      return this.displayMessages ? "next" : "prev";
    }
  },

  methods: {
    ...mapActions("auth/groups", ["leaveGroup", "deleteGroup"]),

    setGroup(message) {
      this.group = message.group;

      this.$nextTick(() => {
        this.displayMessages = false;
      });
    },

    clearGroup() {
      this.displayMessages = true;
    },

    leaveChat(group) {
      this.leaveGroup(group);
    },

    deleteChat(group) {
      this.deleteGroup(group);
    }
  }
};
</script>

<style lang="scss" scoped>
.messages-tab {
  min-height: 100%;
  .chat {
    height: calc(100vh - 271px);
    overflow: hidden;
  }
}
</style>
