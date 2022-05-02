import { getValue } from "./helpers/getters";

export default {
  getErrors: state => type => {
    if (state.errors && state.errors[type]) {
      return state.errors[type][0];
    }
  },

  getBreadcrumbs: getValue("breadcrumbs")
};
