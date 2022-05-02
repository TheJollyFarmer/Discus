<template>
  <v-media-object
    :avatar="avatar"
    dimension="72"
    class="profile-header">
    <profile-header-labels :user="user"/>
    <template #mediaRight>
      <div class="buttons">
        <avatar
          :auth="auth"
          :user="user"
          @changed="updateAvatar"/>
        <friend-button :auth="auth"/>
      </div>
    </template>
  </v-media-object>
</template>

<script>
import Avatar from "../avatar/Avatar.vue";
import FriendButton from "./ProfileFriendButton.vue";
import ProfileHeaderLabels from "./ProfileHeadLabels";
import VMediaObject from "../utility/VMediaObject";
import { mapState } from "vuex";

export default {
  name: "ProfileHeader",

  components: {
    Avatar,
    FriendButton,
    ProfileHeaderLabels,
    VMediaObject
  },

  props: {
    user: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      avatar: this.user.avatar_path
    };
  },

  computed: mapState({
    auth: state => state.auth.user
  }),

  methods: {
    updateAvatar(avatar) {
      this.avatar = avatar;
    }
  }
};
</script>

<style scoped>
.profile-header {
  margin-bottom: 1em;
}
</style>
