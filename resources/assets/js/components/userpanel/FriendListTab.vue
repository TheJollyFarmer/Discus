<template>
  <div>
    <friends-list/>
    <v-button
      v-tooltip="'Create new group'"
      class="is-fullwidth is-radiusless"
      @onClick="createGroupWindow">
      <v-favicon 
        class="is-marginless"
        icon="users"/>
    </v-button>
  </div>
</template>

<script>
import FriendsList from "../lists/FriendsList";
import VButton from "../utility/VButton";
import VFavicon from "../utility/VFavicon";
import { mapActions } from "vuex";

export default {
  components: {
    FriendsList,
    VButton,
    VFavicon
  },

  methods: {
    ...mapActions(["toggleContent", "openModal"]),

    createGroupWindow() {
      this.toggleContent("panel");

      setTimeout(() => {
        this.openModal({ type: "createGroup", image: "default" });
      }, 400);
    }
  }
};
</script>

<style scoped>
.is-fullwidth {
  box-shadow: 0 -2px 1px rgba(0, 0, 0, 0.1);
}
</style>
