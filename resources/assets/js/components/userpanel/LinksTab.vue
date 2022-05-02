<template>
  <v-menu-list class="user-links">
    <v-menu-item
      :link-data="user"
      link="profiles.show"
      icon="home" 
      label="My Profile"/>
    <v-menu-item
      link="admin.index"
      icon="user-cog"
      label="Admin"/>
    <v-menu-item
      link="admin.index"
      icon="cog"
      label="Settings"/>
    <v-menu-item
      icon="sign-out-alt"
      label="Sign Out"
      @onClick="logout"/>
  </v-menu-list>
</template>

<script>
import VMenuItem from "../utility/VMenuItem";
import VMenuList from "../utility/VMenuList";
import { mapActions } from "vuex";

export default {
  name: "LinksTab",

  components: { VMenuItem, VMenuList },

  props: {
    user: {
      type: String,
      required: true
    }
  },

  methods: mapActions("auth", ["logout"])
};
</script>
