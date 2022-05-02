<template>
  <div class="navbar-end">
    <v-nav-item
      icon="plus"
      label="Create Thread"
      @onClick="openModal({type:'threadForm', image:'default'})"/>
    <nav-dropdown
      icon="envelope"
      label="messages"
      component="messages"
      link="groups"/>
    <nav-dropdown
      icon="user-friends"
      label="friend Requests"
      component="friendRequests"
      link="friends.requests"/>
    <nav-dropdown
      icon="bell"
      label="notifications"
      component="notifications"
      link="notifications"/>
    <v-nav-item
      icon="home"
      label="Open UserPanel"
      @onClick="openUserPanel"/>
  </div>
</template>

<script>
import NavDropdown from "./NavDropdown";
import VNavItem from "../utility/VNavItem";
import { mapActions } from "vuex";

export default {
  name: "AuthNavLinks",

  components: { NavDropdown, VNavItem },

  methods: mapActions(["openModal", "openUserPanel"])
};
</script>
