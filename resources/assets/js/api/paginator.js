import api from "./index.js";

export default {
  getRequestForm() {
    return api.getItem("local", "requestForm");
  },

  setRequestForm(form) {
    return api.setItem("local", "requestForm", form);
  }
}