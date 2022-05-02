<template>
  <div 
    v-if="!isLoggedIn" 
    class="navbar-end">
    <v-nav-item
      icon="sign-in-alt"
      label="Login"
      @onClick="openModal({type:'loginForm', image:'default'})"/>
    <v-nav-item
      icon="user-plus"
      label="Register"
      @onClick="openModal({type:'registerForm', image:'default'})"/>
  </div>
  <auth-nav-links v-else/>
</template>

<script>
import AuthNavLinks from "./AuthNavLinks";
import VNavItem from "../utility/VNavItem";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "NavLinks",

  components: {
    AuthNavLinks,
    VNavItem
  },

  computed: mapGetters("auth", ["isLoggedIn"]),

  methods: mapActions(["openModal"])
};
</script>
