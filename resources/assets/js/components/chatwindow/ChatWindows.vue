<template>
  <div
    v-show="displayWindows"
    id="chat-windows">
    <chat-window
      v-for="(group, index) in groups"
      v-show="index + 1 <= maxWindows"
      :key="group.id"
      :group="group"
      :index="index"
      @addFriends="addFriends"
      @closed="removeChat"
      @leave="leaveChat"
      @deleted="deleteChat"
      @toggleDisplay="setChatDisplayState"/>
  </div>
</template>

<script>
import api from "../../api/index";
import ChatWindow from "./ChatWindow.vue";
import debounce from "lodash/throttle";
import { mapState, mapActions } from "vuex";

export default {
  name: "ChatWindows",

  components: { ChatWindow },

  data() {
    return {
      windowWidth: window.innerWidth
    };
  },

  computed: {
    ...mapState({
      groups: state => state.auth.groups.keys,
      auth: state => state.auth.user.id
    }),

    maxWindows() {
      return parseInt((this.windowWidth - 375) / 320);
    },

    displayWindows() {
      return api.currentRoute() !== "groups.index";
    }
  },

  mounted() {
    this.getGroups();
    this.setMaxGroups(this.maxWindows);

    window.addEventListener("resize", this.handleWindowResize);
  },

  beforeDestroy() {
    window.removeEventListener("resize", this.handleWindowResize);
  },

  methods: {
    ...mapActions("auth/groups", [
      "getGroups",
      "createGroup",
      "addGroupUsers",
      "removeGroup",
      "leaveGroup",
      "deleteGroup",
      "setMaxGroups",
      "setGroupDisplay"
    ]),

    createChat(friends) {
      this.createGroup(friends);
    },

    addFriends(payload) {
      this.addGroupUsers(payload);
    },

    removeChat(group) {
      this.removeGroup(group);
    },

    leaveChat(group) {
      this.leaveGroup(group);
    },

    deleteChat(group) {
      this.deleteGroup(group);
    },

    setChatDisplayState(group) {
      this.setGroupDisplay(group);
    },

    handleWindowResize: debounce(function(event) {
      this.windowWidth = event.currentTarget.innerWidth;

      if (this.maxWindows !== this.groups.maxGroups) {
        this.setMaxGroups(this.maxWindows);
      }
    }, 500)
  }
};
</script>
