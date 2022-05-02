require("./bootstrap");
import store from "./store/index.js";
import Vue from "vue";
import { mapActions } from "vuex";

new Vue({
  el: "#app",
  store,

  created() {
    this.getChannels();
    this.getAuthUser();
  },

  methods: mapActions({
    getChannels: "getChannels",
    getAuthUser: "auth/getAuthUser"
  })
});
