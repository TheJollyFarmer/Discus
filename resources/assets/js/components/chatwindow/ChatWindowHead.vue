<template>
  <div>
    <v-level
      class="chat-window-head"
      @click.self.native="toggleWindow">
      <chat-window-head-title :users="users"/>
      <template #levelRight>
        <chat-window-head-actions
          @closeWindow="closeWindow"
          @leaveChat="leaveChat"
          @deleteChat="deleteChat"
          @toggleInput="toggleFriendInput"/>
      </template>
    </v-level>
    <chat-friend-input
      :display="displayFriendInput"
      @addFriends="addFriends"/>
  </div>
</template>

<script>
import ChatEvents from "../../mixins/ChatEvents";
import ChatFriendInput from "../chat/ChatFriendInput";
import ChatWindowHeadActions from "./ChatWindowHeadActions";
import ChatWindowHeadTitle from "./ChatWindowHeadTitle";
import VLevel from "../utility/VLevel";

export default {
  name: "ChatWindowHead",

  components: {
    ChatFriendInput,
    ChatWindowHeadActions,
    ChatWindowHeadTitle,
    VLevel
  },

  mixins: [ChatEvents],

  props: {
    users: {
      type: Array,
      required: true
    }
  },

  data() {
    return {
      displayFriendInput: false
    };
  },

  methods: {
    toggleFriendInput() {
      this.displayFriendInput = !this.displayFriendInput;

      this.toggleInput();
    }
  }
};
</script>

<style scoped>
.chat-window-head {
  background-color: #00d1b2;
  border-radius: 0.5em 0.5em 0 0;
  box-shadow: 0 2px 14px rgba(0, 0, 0, 0.1);
  color: white;
  cursor: pointer;
  margin: 0;
  padding: 0.5em;
}
</style>
