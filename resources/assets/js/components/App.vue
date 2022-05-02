<template>
  <div>
    <nav-bar/>
    <section :class="['section', sectionHasPadding]">
      <div class="container">
        <div class="columns">
          <side-bar :trending="trending"/>
          <slot/>
        </div>
      </div>
    </section>
    <globals/>
  </div>
</template>

<script>
import currentRoute from "../api/index";
import Globals from "./modals/Globals";
import NavBar from "./nav/NavBar";
import SideBar from "./sidebar/SideBar";

export default {
  name: "App",

  components: { Globals, NavBar, SideBar },

  props: {
    trending: {
      type: Array,
      required: true
    }
  },

  computed: {
    sectionHasPadding() {
      return this.currentRoute() === "groups.index" ? "paddingBottomZero" : "";
    }
  },

  methods: currentRoute
};
</script>

<style scoped>
.paddingBottomZero {
  padding-bottom: 0;
}
</style>
