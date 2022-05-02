<template>
  <nav
    class="navbar is-fixed-top is-primary has-shadow"
    role="navigation"
    aria-label="main navigation">
    <div class="container">
      <div class="navbar-brand">
        <v-nav-brand>
          <span class="is-size-4">DISCUS</span>
        </v-nav-brand>
        <v-hamburger/>
      </div>
      <div
        id="app-navbar-collapse"
        class="navbar-menu">
        <div class="navbar-end">
          <nav-search/>
          <nav-links/>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import NavLinks from "./NavLinks";
import NavSearch from "./NavSearch";
import VHamburger from "../utility/VHamburger";
import VNavBrand from "./NavBrand";

export default {
  name: "NavBar",

  components: {
    NavLinks,
    NavSearch,
    VHamburger,
    VNavBrand
  }
};
</script>
