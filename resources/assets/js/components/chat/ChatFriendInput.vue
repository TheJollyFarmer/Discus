<template>
  <transition-expand>
    <v-field
      v-show="display"
      class="friends-input"
      addons>
      <div class="control">
        <v-tag-input
          :autofocus="display"
          :placeholder="placeholder"
          @added="addFriend"
          @removed="removeFriend"/>
      </div>
      <div class="control">
        <v-button
          class="is-radiusless"
          icon="check"
          @onClick="addFriends"/>
      </div>
    </v-field>
  </transition-expand>
</template>

<script>
import TransitionExpand from "../transitions/TransitionExpand";
import VButton from "../utility/VButton";
import VField from "../utility/VField";
import VTagInput from "../utility/VTagInput";

export default {
  name: "ChatFriendInput",

  components: { TransitionExpand, VButton, VField, VTagInput },

  props: {
    display: {
      type: Boolean,
      required: true
    }
  },

  data() {
    return {
      friends: []
    };
  },

  computed: {
    placeholder() {
      return this.friends.length ? "" : "Add users to the chat.";
    }
  },

  methods: {
    addFriend(friend) {
      this.friends.push(friend);
    },

    addFriends() {
      if (this.friends) {
        this.$emit("addFriends", this.friends);

        this.friends = [];
      }
    },

    removeFriend(index) {
      this.friends.splice(index, 1);
    }
  }
};
</script>

<style scoped>
.friends-input {
  background-color: white;
  border-bottom: 1px solid #4a4a4a;
  box-shadow: 0 2px 14px rgba(0, 0, 0, 0.1);
  display: flex;
  margin: 0;
  width: 100%;
}

.friends-input > .control:first-child {
  flex-grow: 1;
  max-width: 100%;
  outline: none;
}
</style>
