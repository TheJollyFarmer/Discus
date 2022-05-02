import autofocus from "./Autofocus";
import tooltip from "./Tooltip";

export default {
  install(Vue) {
    Vue.directive("autofocus", {
      bind: autofocus,
      update: autofocus
    });

    Vue.directive("tooltip", {
      bind: tooltip.bind,
      update: tooltip.update,
      unbind(el) {
        el.remove();
      }
    });
  }
};
