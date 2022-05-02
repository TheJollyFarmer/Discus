import axios from "axios";
import Vue from "vue";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}

axios.interceptors.request.use(config => {
  if (Vue.prototype.$echo.socketId()) {
    config.headers["X-Socket-Id"] = Vue.prototype.$echo.socketId();
  }

  return config;
});

export default axios;
