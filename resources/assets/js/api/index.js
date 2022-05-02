import axios from "../routes/axios";
import route from "../../../../vendor/tightenco/ziggy/src/js/route";
import store from "../store/index";
import { Ziggy } from "../routes/ziggy";

export default {
  route: (name, params, absolute) => route(name, params, absolute, Ziggy),

  request(type, route, payload) {
    return axios[type](route, payload)
      .then(response => {
        if (response.status === 200) {
          return response.data;
        }
      })
      .catch(e => {
        if (e.response) {
          console.log(e.response);
        } else if (e.request) {
          console.log(e.request);
        } else {
          console.log("Error", e.message);
        }

        store.dispatch("setErrors", e.response.data.errors);

        return Promise.reject(e);
      });
  },

  goTo(route, params) {
    window.location.href = this.route(route, params);
  },

  getItem(type, key) {
    return JSON.parse(window[type + "Storage"].getItem(key));
  },

  setItem(type, key, payload) {
    window[type + "Storage"].setItem(key, JSON.stringify(payload));
  },

  removeItem(type, key) {
    window[type + "Storage"].removeItem(key);
  },

  currentRoute() {
    return this.route().current();
  }
};
