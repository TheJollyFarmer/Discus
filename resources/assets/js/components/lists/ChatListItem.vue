<template>
  <v-media-object
    :avatar="friendAvatar"
    :is-v-centered="false"
    :media-is-right="authMessage">
    <div
      :class="['chat-message', authClass]"
      @mouseenter="toggleDelete"
      @mouseleave="toggleDelete">
      {{ message.body }}
      <v-delete
        v-show="isHovered"
        :is-left="authMessage"
        @onClick="deleteEvent"/>
    </div>
    <div>{{ message.created | time }} | {{ message.created | day }}</div>
    <template #mediaRight>
      <v-avatar
        v-if="authMessage"
        :path="message.avatar"/>
    </template>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters.js";
import VAvatar from "../utility/VAvatar";
import VDelete from "../utility/VDelete";
import VMediaObject from "../utility/VMediaObject";
import { mapState } from "vuex";

export default {
  name: "ChatListItem",

  components: { VAvatar, VDelete, VMediaObject },

  filters: {
    time: filters.time,
    day: filters.day
  },

  props: {
    message: {
      type: Object,
      required: true,
      default: null
    }
  },

  data() {
    return {
      hover: false
    };
  },

  computed: {
    ...mapState("auth", ["user"]),

    authMessage() {
      return this.user.username === this.message.user;
    },

    authClass() {
      return this.authMessage ? "" : "has-background-danger";
    },

    friendAvatar() {
      return this.authMessage ? "" : this.message.avatar;
    },

    isHovered() {
      return this.hover && this.authMessage;
    }
  },

  methods: {
    toggleDelete() {
      this.hover = !this.hover;
    },

    deleteEvent() {
      this.$emit("deleted", this.message);
    }
  }
};
</script>

<style lang="scss" scoped>
.chat-message {
  background-color: #00d1b2;
  border-radius: 8px;
  color: white;
  display: inline-flex;
  flex-grow: initial;
  hyphens: auto;
  -webkit-hyphens: auto;
  -moz-hyphens: auto;
  margin-bottom: 0.2em;
  padding: 0.35rem 0.45rem;
  position: relative;
}

::v-deep .media {
  margin-top: 0.3rem;
}

::v-deep .media-right {
  margin-left: 1rem;
}
</style>
