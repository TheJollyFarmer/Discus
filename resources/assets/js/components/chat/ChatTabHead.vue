<template>
  <div>
    <div class="buttons has-addons">
      <v-button
        class="is-outlined"
        icon="arrow-left"
        @onClick="backEvent"/>
      <v-button
        ref="inputButton"
        :class="['is-outlined', inputButtonClass]"
        icon="user-plus"
        @onClick="toggleFriendInput"/>
      <v-button
        ref="menuButton"
        :class="['is-outlined', menuButtonClass]"
        icon="cog"
        @onClick="toggleMenu"/>
    </div>
    <chat-friend-input :display="displayInput"/>
    <transition-expand>
      <chat-menu 
        v-show="displayMenu"
        @leaveChat="leaveChat"
        @deleteChat="deleteChat"
        @toggleInput="toggleFriendInput"/>
    </transition-expand>
  </div>
</template>

<script>
import ChatEvents from "../../mixins/ChatEvents";
import ChatFriendInput from "./ChatFriendInput";
import ChatMenu from "./ChatMenu";
import TransitionExpand from "../transitions/TransitionExpand";
import VButton from "../utility/VButton";

export default {
  name: "ChatTabHead",

  components: {
    ChatFriendInput,
    ChatMenu,
    TransitionExpand,
    VButton
  },

  mixins: [ChatEvents],

  props: {
    group: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      displayMenu: false,
      displayInput: false,
      buttonActiveClass: ["has-background-white", "has-text-primary"]
    };
  },

  computed: {
    inputButtonClass() {
      return this.displayInput ? this.buttonActiveClass : "";
    },

    menuButtonClass() {
      return this.displayMenu ? this.buttonActiveClass : "";
    }
  },

  methods: {
    backEvent() {
      if (this.displayMenu || this.displayInput) {
        this.displayInput = false;
        this.displayMenu = false;

        setTimeout(() => {
          this.$emit("back");
        }, 350);
      } else {
        this.$emit("back");
      }
    },

    toggleMenu() {
      this.displayMenu = !this.displayMenu;

      this.$refs.menuButton.$el.blur();
    },

    toggleFriendInput() {
      this.displayInput = !this.displayInput;

      this.$refs.inputButton.$el.blur();
    }
  }
};
</script>

<style lang="scss" scoped>
.buttons {
  box-shadow: #4a4a4a 0px -3px 14px 0px;
  margin-bottom: 0;
  position: relative;
  z-index: 8;
  .button {
    border-color: #4a4a4a !important;
    border-radius: 0;
    border-width: 0 0.5px 1px 0.5px;
    color: #4a4a4a;
    flex: 1;
    margin-bottom: 0;
    &:hover,
    &:focus {
      background-color: white;
      box-shadow: none;
      color: #00d1b2;
    }
    &:first-child {
      border-left-width: 0;
    }
    &:last-child {
      border-right-width: 0;
    }
  }
}

::v-deep .menu-list {
  border-bottom: 1px solid #4a4a4a;
  box-shadow: 0 8px 14px rgba(0, 0, 0, 0.1);
}
</style>
