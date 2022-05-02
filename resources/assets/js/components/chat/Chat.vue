<template>
  <div :class="['chat', customClass]">
    <slot/>
    <transition-tab-slide type="single">
      <chat-list
        :key="group"
        :group="group"
        :messages="messages"
        @getData="getData"
        @deleteMessage="deleteMessage"/>
    </transition-tab-slide>
    <v-textarea
      v-model="message"
      :autofocus="display"
      rows="1"
      custom-class="is-radiusless"
      @onEnter="storeMessage"
      @input="isTypingEvent"/>
  </div>
</template>

<script>
import Chat from "../../store/modules/auth/chat/index";
import ChatList from "../lists/ChatList";
import TransitionTabSlide from "../transitions/TransitionTabSlide";
import VTextarea from "../utility/VTextarea";

export default {
  name: "Chat",

  components: {
    ChatList,
    TransitionTabSlide,
    VTextarea
  },

  props: {
    group: {
      type: Number,
      required: true
    },

    customClass: {
      type: String,
      required: false,
      default: ""
    },

    display: {
      type: Boolean,
      required: true
    }
  },

  data() {
    return {
      message: "",
      displayFriendInput: false
    };
  },

  computed: {
    messages() {
      return this.$store.getters[`auth/chat-${this.group}/getMessages`];
    },

    path() {
      return `auth/chat-${this.group}/`;
    }
  },

  watch: {
    group() {
      this.registerChatModule();

      if (!this.messages.length) {
        this.getData();
      }
    }
  },

  created() {
    this.registerChatModule();

    if (this.group !== 0) {
      this.getData();
    }
  },

  methods: {
    getData() {
      this.$store.dispatch(this.path + "getData", this.group);
    },

    storeMessage() {
      if (this.message.trim() !== "") {
        this.isTypingEvent(false);

        this.$store
          .dispatch(this.path + "submitMessage", {
            message: this.message,
            group: this.group
          })
          .then(() => {
            this.message = "";
          });
      }
    },

    deleteMessage(message) {
      this.$store.dispatch(this.path + "deleteMessage", message);
    },

    registerChatModule() {
      let modulePath = this.$store.state.auth;
      let moduleName = `chat-${this.group}`;

      if (!modulePath[moduleName]) {
        this.$store.registerModule(["auth", `chat-${this.group}`], Chat);
      }
    },

    isTypingEvent(typing = true) {
      let channel = this.$echo.private("chat." + this.group);

      setTimeout(function() {
        channel.whisper("typing", {
          typing: typing
        });
      }, 300);
    }
  }
};
</script>

<style lang="scss" scoped>
.chat {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.overflow-visible {
  overflow: visible !important;
}
</style>
