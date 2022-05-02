<template>
  <div class="globals">
    <template v-if="isLoggedIn">
      <chat-windows/>
      <v-flash message=""/>
      <user-panel/>
    </template>
    <v-modal>
      <component :is="componentName"/>
    </v-modal>
  </div>
</template>

<script>
import ChatWindows from "../chatwindow/ChatWindows";
import UserPanel from "../userpanel/UserPanel";
import VFlash from "../utility/VFlash";
import VModal from "../utility/VModal";
import { mapGetters, mapState } from "vuex";

export default {
  name: "Globals",

  components: {
    ChatWindows,
    UserPanel,
    VFlash,
    VModal
  },

  computed: {
    ...mapState(["modal"]),
    ...mapGetters("auth", ["isLoggedIn"]),

    componentName() {
      return this.modal ? () => import(`./${this.modal}Modal.vue`) : "";
    }
  }
};
</script>
