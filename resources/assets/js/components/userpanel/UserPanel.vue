<template>
  <v-overlay type="panel">
    <transition 
      name="sidenav-slide" 
      @after-leave="closeOverlay">
      <div
        v-show="displayPanel"
        class="userpanel">
        <user-panel-header :user="user"/>
        <user-panel-tabs :username="user.username"/>
      </div>
    </transition>
  </v-overlay>
</template>

<script>
import UserPanelHeader from "./UserPanelHeader";
import UserPanelTabs from "./UserPanelTabs";
import VOverlay from "../utility/VOverlay";
import { mapActions, mapState } from "vuex";

export default {
  name: "UserPanel",

  components: {
    UserPanelHeader,
    UserPanelTabs,
    VOverlay
  },

  computed: mapState({
    user: state => state.auth.user,
    displayPanel: state => state.displayUserPanel
  }),

  methods: mapActions(["closeOverlay"])
};
</script>

<style lang="scss" scoped>
.userpanel {
  box-shadow: 0 3px 10px rgba(34, 25, 25, 0.8);
  background-color: white;
  color: white;
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
  position: fixed;
  top: 0;
  right: 0;
  width: 325px;
  z-index: 1600;
}

.sidenav-slide-enter-active {
  animation: slide 0.3s ease;
}

.sidenav-slide-leave-active {
  animation: slide 0.3s ease reverse;
}

@keyframes slide {
  from {
    transform: translate3d(100%, 0, 0);
  }
  to {
    transform: translate3d(0, 0, 0);
  }
}
</style>
