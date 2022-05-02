export default {
  methods: {
    addFriends(friends) {
      this.$emit("addFriends", friends);
    },

    closeWindow() {
      this.$emit("closeWindow");
    },

    deleteChat() {
      this.$emit("deleteChat");
    },

    leaveChat() {
      this.$emit("leaveChat");
    },

    toggleInput() {
      this.$emit("toggleInput");
    },

    toggleWindow() {
      this.$emit("toggleWindow");
    }
  }
};
