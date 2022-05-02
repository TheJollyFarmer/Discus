<template>
  <div class="userpanel-header">
    <v-avatar
      :path="user.avatar_path"
      dimension="64"/>
    <h4 class="is-uppercase">
      {{ user.username }}
    </h4>
    <h5>
      <v-favicon icon="star"/>
      {{ user.reputation }}
    </h5>
  </div>
</template>

<script>
import VAvatar from "../utility/VAvatar";
import VFavicon from "../utility/VFavicon";

export default {
  name: "UserPanelHeader",

  components: { VAvatar, VFavicon },

  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
.userpanel-header {
  background-color: #00d1b2;
  padding: 3.2em 0;
  text-align: center;
}

.userpanel-header figure {
  margin-bottom: 1em;
}
</style>
