import channels from "./channels/index";
import threads from "./threads/index";

export default {
  namespaced: true,

  modules: {
    channels,
    threads
  }
};
