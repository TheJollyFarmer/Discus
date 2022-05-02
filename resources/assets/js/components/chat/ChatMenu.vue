<template>
  <v-menu-list>
    <v-menu-item
      :link-data="user"
      link="conversations.index"
      icon="envelope"
      label="Messages"/>
    <v-menu-item
      icon="sign-out-alt"
      label="Leave"
      @onClick="leaveChat"/>
    <v-menu-item
      icon="fire"
      label="Delete"
      @onClick="deleteChat"/>
    <v-menu-item
      icon="sign-out-alt"
      label="Add Friends"
      @onClick="toggleInput"/>
  </v-menu-list>
</template>

<script>
import ChatEvents from "../../mixins/ChatEvents";
import VMenuItem from "../utility/VMenuItem";
import VMenuList from "../utility/VMenuList";
import { mapState } from "vuex";

export default {
  name: "ChatMenu",

  components: { VMenuItem, VMenuList },

  mixins: [ChatEvents],

  computed: mapState("auth", ["user"])
};
</script>

<style lang="scss" scoped>
::v-deep .menu-list {
  margin-bottom: 0;
}
</style>
